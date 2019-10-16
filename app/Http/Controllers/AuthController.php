<?php

namespace App\Http\Controllers;
use App\Logger;
use App\User;

class AuthController extends BaseController {

  public function getLogin() {

    // $cookie = Cookie::forever('laravel_access_id', Hash::make(Str::random(10)));

    return Response::view('auth.login'); // ->withCookie($cookie);
  }

  public function postLogin() {

    $input = Input::all();

    $validator = AuthValidator::login($input);

    if ($validator->passes()) {

      $remember = false;

      if (Input::get('remember'))

        $remember = true;

      Event::fire('auth.trying', $input['email']);

      if (Auth::attempt(array('email' => $input['email'], 'password' => $input['password']), $remember)) {

        $user = Auth::user();

        Event::fire('auth.login', array($user));

        if ($user->throttle->is_first_access)

          return Redirect::route('users.change-password', Auth::user()->id);

        return Redirect::route('users.show', Auth::user()->id);

      } else {

        Event::fire('auth.attempting', $input['email']);

        $user = User::where('email', $input['email'])->withTrashed()->first();

        $message = Lang::get('auth.msg.error.invalid-user');

        if ($user) {

          $throttle = $user->throttle()->first();

          if ($throttle->suspended) {

            $time    = strtotime($throttle->last_attempt_at . User::SUSPENSION_TIME) - strtotime('now');

            $minutes = round(((($time % 604800) % 86400) % 3600) / 60);

            $message = Lang::get('auth.msg.error.user-suspended', ['minutes' => $minutes]);
          }
        }

        return Redirect::to('login')->withInput()->with('_warn', $message);
      }
    }

    return Redirect::to('login')
                    ->withInput()
                    ->withErrors($validator)
                    ->with('_error', Lang::get('application.msg.error.validation-errors'));
  }

  public function getLogout(){

    Auth::logout();

    return Redirect::to('/login');
  }

  public function getRemind() {

    return View::make('auth.remind');
  }

  public function postRemind() {

    $validator = AuthValidator::remind(Input::all());

    if ($validator->passes()) {

      switch ($response = Password::remind(Input::only('email'), function($message) {

        $message->subject(Lang::get('auth.mail.remind.subject.password-reset'));

        LoggerHelper::log('AUTH', Lang::get('auth.log.password.remind', ['email' => Input::get('email')]));

      })) {

        case Password::INVALID_USER:
          return Redirect::back()->with('_warn', Lang::get($response));

        case Password::REMINDER_SENT:
          return Redirect::back()->with('_status', Lang::get($response));
      }
    }

    return Redirect::to('password/remind')
                    ->withInput()
                    ->withErrors($validator)
                    ->with('_error', Lang::get('application.msg.error.validation-errors'));
  }

  public function getReset($token = null) {

    if (is_null($token))

      return App::abort(404);

    return View::make('auth.reset')->with('token', $token);
  }

  public function postReset() {

    $input = Input::all();

    $validator = AuthValidator::reset($input);

    if ($validator->passes()) {

      $credentials = array(
        'email'                 => $input['email'],
        'password'              => $input['password'],
        'password_confirmation' => $input['password_confirmation'],
        'token'                 => $input['token']
      );

      $response = Password::reset($credentials, function($user, $password) {

        $user->password = Hash::make($password);

        $user->save();

        LoggerHelper::log('AUTH', Lang::get('auth.log.password.reset', ['email' => $user->email, 'id' => $user->id]));
      });

      switch ($response) {

        case Password::INVALID_PASSWORD:
        case Password::INVALID_TOKEN:
        case Password::INVALID_USER:
          return Redirect::back()->with('_warn', Lang::get($response));

        case Password::PASSWORD_RESET:
          return Redirect::to('login')->with('_status', Lang::get($response));
      }
    }

    return Redirect::back()
                    ->withInput()
                    ->withErrors($validator)
                    ->with('_error', Lang::get('application.msg.error.validation-errors'));
  }

  public function passwordVerify() {

    $actualPassword = Input::get('actual_password');

    if (Hash::check($actualPassword, Auth::user()->getAuthPassword()))

      return 'true';

    return 'false';
  }

  public function newUser() {

    return View::make('auth.new-user');

  }

  public function newStore(){
    $input = FormatterHelper::filter(Input::all(), array('name'));
    $input['roles'][0] = 3;

    if($input['password'] == $input['password_confirmation']){

      $validator = UserValidator::store($input);

        if ($validator->passes()) {

          try {

            UserService::store($input);

            return Redirect::back()
                            ->with('_status', Lang::get('application.msg.status.resource-created-successfully'));

          } catch (Exception $e) {

            Session::flash('_old_input', Input::all());

            return Redirect::back()->with('_error', Lang::get('application.msg.error.something-went-wrong'));
          }
        }
        return Redirect::back()
                        ->withInput()
                        ->withErrors($validator)
                        ->with('_error', Lang::get('application.msg.error.validation-errors'));

      }

      return Redirect::back()
                      ->withInput()
                      ->with('_error', Lang::get('application.msg.error.password_confirmation'));

    }

}
