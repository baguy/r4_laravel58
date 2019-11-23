<?php

namespace App\Http\Controllers;

use App\User;
use App\Throttle;
use App\Role;
use App\Logger;
use Input;
use Auth;
use Redirect;
use App\Http\Services\UserService;
use App\helpers\LoggingHelper;
use App\helpers\LoggerHelper;
use App\validators\UserValidator;

class UserController extends BaseController {

  protected $user;

  protected $role;

  protected $service;

  protected $selects;

  public function __construct(User $user, Role $role, UserService $service) {

    parent::__construct($service);

    $this->user    = $user;
    $this->role    = $role;
    $this->service = $service;

    $this->selects = $this->service->selects();

    $this->middleware('role:SUPER', array('only' => array('redefinePassword')));
    $this->middleware('role:ADMIN', array('only' => array(
      'create', 'store', 'destroy', 'restore', 'report', 'export', 'printAll'
    )));
  }

  public function index() {

    return view('users.index')->with('selects', $this->service->selects(true));
  }

  public function create() {

    $roles = $this->role->orderBy('id', 'ASC')->get(['id', 'name', 'description']);

    return view('users.create')->with('roles', $roles)->with('selects', $this->selects);
  }

  public function store() {

    $input = FormatterHelper::filter(Input::all(), array('name'));

    $validator = UserValidator::store($input);

    if ($validator->passes()) {

      try {

        $this->service->store($input);

        return Redirect::route('users.index')
                        ->with('_status', trans('application.msg.status.resource-created-successfully'));

      } catch (Exception $e) {

        Session::flash('_old_input', Input::all());

        return Redirect::back()->with('_error', trans('application.msg.error.something-went-wrong'));
      }
    }

    return Redirect::route('users.create')
                    ->withInput()
                    ->withErrors($validator)
                    ->with('_error', trans('application.msg.error.validation-errors'));
  }

  public function show($id) {

    $user = $this->user->withTrashed()->find($id);

    $this->service->accessVerification($user);

    LoggingHelper::show($user);

    $take   = 10;

    $colors = LoggerHelper::getColors();

    $icons  = LoggerHelper::getIcons();

    $logs   = $user->loggers()->orderBy('id', 'DESC')->take($take)->get();

    return view('users.show', compact(['user', 'logs', 'colors', 'icons', 'take']));
  }

  public function edit($id) {

    $user = $this->user->find($id);

    // Roles

    $roles = $this->role->orderBy('id', 'ASC')->get(['id', 'name', 'description']);

    $this->service->accessVerification($user);

    return view('users.edit', compact('user'))
                                                  ->with('roles', $roles)
                                                  ->with('selects', $this->selects);
  }

  public function update($id) {

    $input = FormatterHelper::filter(array_except(Input::all(), '_method'), array('name'));

    try {

      $this->service->update($input, $id);

      return Redirect::route('users.show', $id)
                      ->with('_status', trans('application.msg.status.resource-updated-successfully'));

    } catch (Exception $e) {

      Session::flash('_old_input', Input::all());

      return Redirect::back()->with('_error', trans('application.msg.error.something-went-wrong'));
    }

  }


  public function destroy($id) {

    $user = $this->user->find($id);

    $this->service->accessVerification($user, false, true);

    try {

      $this->service->destroy($id);

      return Redirect::route('users.index')
                      ->with('_status', trans('application.msg.status.resource-deleted-successfully'));

    } catch (Exception $e) {

      return Redirect::back()->with('_error', trans('application.msg.error.something-went-wrong'));
    }
  }

  public function restore($id) {

    $user = $this->user->withTrashed()->find($id);

    $this->service->accessVerification($user, false, true);

    try {

      $this->service->restore($id);

      return Redirect::route('users.index')
                      ->with('_status', trans('application.msg.status.resource-restored-successfully'));

    } catch (Exception $e) {

      return Redirect::back()->with('_error', trans('application.msg.error.something-went-wrong'));
    }
  }

  public function changePassword($id) {

    $user = $this->user->find($id);

    $this->service->accessVerification($user, true);

    if ($user->throttle->is_default_password)

      Session::flash('_warn', trans('users.msg.is-default-password'));

    return view('users.change-password', compact('user'));
  }

  public function alterPassword($id) {

    $input = Input::except('_method');

    $validator = UserValidator::alterPassword($input, $id);

    if ($validator->passes()) {

      try {

        $this->service->alterPassword($input, $id);

        return Redirect::route('users.show', $id)
                        ->with('_status', trans('application.msg.status.resource-updated-successfully'));

      } catch (Exception $e) {

        Session::flash('_old_input', Input::all());

        return Redirect::back()->with('_error', trans('application.msg.error.something-went-wrong'));
      }
    }

    return Redirect::route('users.change-password', $id)
                    ->withInput()
                    ->withErrors($validator)
                    ->with('_error', trans('application.msg.error.validation-errors'));
  }

  public function redefinePassword($id) {

    try {

      $this->service->redefinePassword($id);

      return Redirect::route('users.index')
                      ->with('_status', trans('users.msg.password-redefined-successfully'));

    } catch (Exception $e) {

      return Redirect::back()->with('_error', trans('application.msg.error.something-went-wrong'));
    }
  }


  public function createAvatar() {

    return view('users.create_avatar');
  }

  public function uploadAvatar() {

    if(Input::hasFile('file')){

      try {

        $file = Input::file('file');
        $file->move('assets/_dist/img/avatar/'.Auth::user()->email.'/', $file->getClientOriginalName());

        $user = User::find(Auth::user()->id);
        $user->avatar = $user->email .'/'. $file->getClientOriginalName();
        $user->save();

        return Redirect::back()
                        ->with('_status', trans('application.msg.status.upload-successfull'));

      } catch (Exception $e) {

        Session::flash('_old_input', Input::all());

        return Redirect::back()->with('_error', trans('application.msg.error.something-went-wrong'));
      }

    }

    return Redirect::back()
                    ->withInput()
                    ->with('_error', trans('application.msg.error.upload'));
  }

}
