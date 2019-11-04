<?php

namespace App\Http\Services;

use App\Http\Services\BaseService;
use App\User;
use App\Http\Controllers\AuthController;
use App\helpers\MainHelper;
use App\helpers\FormatterHelper;
use App\helpers\LoggingHelper;
use Input;
use App\Role;
use Auth;
use Hash;
use App\Throttle;
use DB;

class UserService extends BaseService {

	protected $user;

  public function __construct(User $user) {

    $this->user = $user;
  }

  public function selects($is_filter = false) {

    return [

      'status'              => MainHelper::fixArray('status', [
                                '1' => mb_strtoupper(trans('application.lbl.active'), 'UTF-8'),
                                '2' => mb_strtoupper(trans('application.lbl.inactive'), 'UTF-8'),
                                '3' => mb_strtoupper(trans('users.lbl.suspended'), 'UTF-8')
                              ]),

      // 'roles'               => MainHelper::fixArray('nível', Role::where('id', '>=', Auth::user()->minRole()->id)
      //                                                               ->orderBy('id', 'ASC')->lists('name', 'id')),

      'attempts'            => MainHelper::fixArray('tentativas', [
                                '0' => mb_strtoupper(trans('users.filter.attempts.opt.successful'), 'UTF-8'),
                                '1' => mb_strtoupper(trans('users.filter.attempts.opt.unsuccessful'), 'UTF-8')
                              ]),

      'is_default_password' => MainHelper::fixArray('senhas', [
                                true  => mb_strtoupper(trans('users.filter.is_default_password.opt.default'), 'UTF-8'),
                                false => mb_strtoupper(trans('users.filter.is_default_password.opt.changed'), 'UTF-8')
                              ]),

    ];
  }

  public static function store($input) {

  	DB::beginTransaction();

    try {

      $user = new User($input);

      $user->password = Hash::make($input['password']);

      $user->save();

			$user->roles()->sync($input['roles']);

      $throttle = new Throttle();

			$throttle->is_default_password = 0;

      $user->throttle()->save($throttle);

      DB::commit();

    } catch (Exception $e) {

      MainHelper::printLog($e);

      DB::rollback();

      throw $e;
    }
  }

  public function update($input, $id) {

  	DB::beginTransaction();

    try {

      $user = $this->user->find($id);

      $user->fill($input);

      if (!empty($input['password']))

        $user->password = Hash::make($input['password']);

      parent::hasChanges($user, array('password'));

			if(isset($input['reset_senha'])){
				$user->throttle->is_default_password = 1;
				$user->throttle->update();

				$user->password = '$2y$10$hravkHv4Whx6oXsw1jMwsOAovVvQ29vlTwVlLox1lgq9ZZUFOG6MO';
				$user->update();
			}

      $user->update();

      $this->syncRoles($input, $user);

      DB::commit();

      if (empty($input['active']) && ($user->id !== Auth::user()->id))

        $this->destroy($user->id);

    } catch (Exception $e) {

      MainHelper::printLog($e);

      DB::rollback();

      throw $e;
    }
  }

  public function destroy($id) {

    DB::beginTransaction();

    try {

      $this->user->find($id)->delete();

      DB::commit();

    } catch (Exception $e) {

      MainHelper::printLog($e);

      DB::rollback();

      throw $e;
    }
  }

  public function restore($id) {

    DB::beginTransaction();

    try {

      $user = $this->user->withTrashed()->find($id);

      $user->restore();

      if ($user->throttle->suspended) {

        $throttle = $user->throttle()->first();

        $throttle->attempts = 0;

        $throttle->last_attempt_at = null;

        $throttle->suspended = false;

        $throttle->update();
      }

      DB::commit();

    } catch (Exception $e) {

      MainHelper::printLog($e);

      DB::rollback();

      throw $e;
    }
  }

  public function alterPassword($input, $id) {

    DB::beginTransaction();

    try {

      $user = $this->user->find($id);

      if ($input['password'])

        $user->password = Hash::make($input['password']);

      $user->update();

      $throttle = $user->throttle()->first();

      if ($throttle->is_default_password) {

        $throttle->is_default_password = false;

        $throttle->update();
      }

      DB::commit();

    } catch (Exception $e) {

      MainHelper::printLog($e);

      DB::rollback();

      throw $e;
    }
  }

  public function redefinePassword($id) {

    DB::beginTransaction();

    try {

      $user = $this->user->find($id);

      $user->password = Hash::make(User::DEFAULT_PASSWORD);

      $user->update();

      $throttle = $user->throttle()->first();

      $throttle->is_default_password = true;

      $throttle->update();

      DB::commit();

    } catch (Exception $e) {

      MainHelper::printLog($e);

      DB::rollback();

      throw $e;
    }
  }

  public function export($users, $type) {

    $date       = Date('d-m-Y H-i-s');

    $title      = trans('users.user(s)');

    $parameters = Input::except('_token', '_method');

    switch ($type) {

      case 'xls':

        Excel::create($title . ' - ' . $date, function($excel) use ($users, $title, $parameters) {

            $excel->sheet($title, function($sheet) use ($users, $parameters) {

              LoggingHelper::report($this->user, $parameters);

              $sheet->loadView('users.report', array('users' => $users));

            });

            LoggingHelper::export($this->user, '.xls', $parameters);

        })->download('xls');

        break;

      case 'pdf':

        # code...

        break;
    }
  }

  public function accessVerification($user, $is_change_password = false, $is_destroy = false) {

    if (is_null($user))
      App::abort(404, trans('application.error.404.msg'));

    switch (true) {

      case !$this->user->userIsAuth($user) && !Auth::user()->hasRole('ADMIN'): // Edit and Show
      case !$this->user->userIsAuth($user) && $this->user->userMinRoleIsLessOrEqualThanAuthMinRole($user): // Edit and Show
      case !$this->user->userIsAuth($user) && $is_change_password: // Change Password
      case  $this->user->userIsAuth($user) && $is_destroy: // Destroy and Restore

        App::abort(403, trans('application.error.403.msg'));

        break;
    }
  }

  private function syncRoles($input, $user) {

    if (!empty($input['roles']))

      $user->roles()->sync($input['roles']);
  }

}
