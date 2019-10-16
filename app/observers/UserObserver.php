<?php

class UserObserver {

  public function creating($model) {

  }

  public function created($model) {

    LoggingHelper::create($model);
  }

  public function saving($model) {

    // Update

    if (Request::is('users/*') && Request::isMethod('patch')) {

      // Change Password

      if (Input::has('password'))

        LoggerHelper::log('AUTH', Lang::get('users.log.password.change', [
          'email' => $model->email, 'id' => $model->id
        ]));

      // Edit Roles

      $roles = Input::get('roles');

      if ($roles) {

        $OLD_ROLE = $model->minRole();

        $NEW_ROLE = Role::find(min($roles));

        if ($OLD_ROLE->id !== $NEW_ROLE->id)

          LoggerHelper::log('EDIT', Lang::get('users.log.edit.roles', [
            'email'     => $model->email,
            'original'  => $OLD_ROLE->name, 
            'value'     => $NEW_ROLE->name, 
            'id'        => $model->id
          ]));
      }
    }

    // Redefine Password

    if (Request::is('users/*/redefine-password')) {

      LoggerHelper::log('AUTH', Lang::get('users.log.password.redefined', [
        'email' => $model->email, 'id' => $model->id
      ]));
    }
  }

  public function saved($model) {

  }

  public function updating($model) {

  }

  public function updated($model) {

    if (!Request::is('users/*/restore'))

      LoggingHelper::update($model);
  }

  public function deleting($model) {
    
  }

  public function deleted($model) {

    if($model->forceDeleting)

      LoggingHelper::delete($model);

    else

      LoggingHelper::destroy($model);
  }

  public function restoring($model) {
    
  }

  public function restored($model) {

    LoggingHelper::restore($model);
  }
}