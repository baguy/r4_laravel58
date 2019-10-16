@if (isset($user->id))

{{
  Form::model(
    $user,
    array(
      'id' => 'userForm',
      'method' => 'PUT',
      'route' => array('users.update', $user->id),
      'data-resource-id' => $user->id,
      'data-validation-errors' => trans('application.msg.error.validation-errors')
    )
  )
}}

@else

{{
  Form::open(
    array(
      'id' => 'userForm',
      'route' => 'users.store',
      'data-validation-errors' => trans('application.msg.error.validation-errors')
    )
  )
}}

@endif

  <div class="card">
    <div class="card-header">
      <h3 class="card-title">
        @if (isset($user->id))
          {{ trim(trans('application.action.edit', ['icon' => '<i class="fas fa-edit"></i>'])) }}
        @else
          {{ trim(trans('application.action.create', ['icon' => '<i class="fas fa-save"></i>'])) }}
        @endif
      </h3>
    </div>
    <div class="card-body">

      <div class="form-group {{ ($errors->has('name')) ? 'has-error' : '' }}">

        {{ Form::label('name', trans('users.lbl.name')) }}<span class="obrigatorio">*</span>

        <div class="input-group">

          {{
            Form::text(
              'name',
              Input::old('name'),
              array(
                'class'            => ($errors->has('name')) ? 'form-control has-error__icon' : 'form-control',
                'placeholder'      => trans('users.plh.name'),
                'aria-describedby' => 'nameAddon'
              )
            )
          }}

          <div class="input-group-append">
            <span id="nameAddon" class="input-group-text rounded-right">
              <i class="fas fa-user fa-fw"></i>
            </span>
          </div>

          @if ($errors->has('name'))
          <div class="invalid-feedback">
            {{ $errors->first('name') }}
          </div>
          @endif

        </div>

      </div>

      <div class="form-group {{ ($errors->has('email')) ? 'has-error' : '' }}">

        {{ Form::label('email', trans('users.lbl.email')) }}<span class="obrigatorio">*</span>

        <div class="input-group">

          {{
            Form::email(
              'email',
              Input::old('email'),
              array(
                'class'            => ($errors->has('email')) ? 'form-control has-error__icon' : 'form-control',
                'placeholder'      => trans('users.plh.email'),
                'aria-describedby' => 'emailHelp',
                'aria-labelledby'  => 'emailAddon'
              )
            )
          }}

          <div class="input-group-append">
            <span id="emailAddon" class="input-group-text rounded-right">
              <i class="fas fa-envelope fa-fw"></i>
            </span>
          </div>

          @if ($errors->has('email'))
          <div class="invalid-feedback">
            {{ $errors->first('email') }}
          </div>
          @endif

        </div>

      </div>


      @if (isset($user->id))

        @if (!Auth::user()->hasRole('ADMIN') || $user->userIsAuth($user))

          <div class="form-group {{ ($errors->has('actual_password')) ? 'has-error' : '' }}">

            {{ Form::label('actual_password', trans('users.lbl.actual-password')) }}

            <div class="input-group">

              {{
                Form::input(
                  'password',
                  'actual_password',
                  Input::old('actual_password'),
                  array(
                    'class'            => ($errors->has('actual_password')) ? 'form-control has-error__icon' : 'form-control',
                    'placeholder'      => trans('users.plh.actual-password'),
                    'aria-describedby' => 'actualPasswordHelp',
                    'aria-labelledby'  => 'actualPasswordAddon'
                  )
                )
              }}

              <div class="input-group-append">
                <span id="actualPasswordAddon" class="input-group-text rounded-right">
                  <i class="fas fa-lock fa-fw"></i>
                </span>
              </div>

              @if ($errors->has('actual_password'))
              <div class="invalid-feedback">
                {{ $errors->first('actual_password') }}
              </div>
              @endif

            </div>

            <small id="actualPasswordHelp" class="form-text text-muted">
              <i class="fas fa-asterisk"></i> {{ trans('users.help.actual.password') }}
            </small>

          </div>

          <div class="form-group {{ ($errors->has('password')) ? 'has-error' : '' }}">

            {{ Form::label('password', (isset($user->id)) ? trans('users.lbl.new-password') : trans('users.lbl.password')) }}

            <div class="input-group">

              {{
                Form::input(
                  'password',
                  'password',
                  Input::old('password'),
                  array(
                    'class'            => ($errors->has('password')) ? 'form-control has-error__icon' : 'form-control',
                    'placeholder'      => (isset($user->id)) ? trans('users.plh.new-password') : trans('users.plh.password'),
                    'aria-describedby' => 'passwordHelp',
                    'aria-labelledby'  => 'passwordAddon'
                  )
                )
              }}

              <div class="input-group-append">
                <span id="passwordAddon" class="input-group-text rounded-right">
                  <i class="fas fa-lock fa-fw"></i>
                </span>
              </div>

              @if ($errors->has('password'))
              <div class="invalid-feedback">
                {{ $errors->first('password') }}
              </div>
              @endif

            </div>

            @if (isset($user->id))
            <small id="passwordHelp" class="form-text text-muted">
              <i class="fa fa-asterisk"></i> {{ trans('users.help.password') }}
            </small>
            @endif

          </div>

          <div class="form-group {{ ($errors->has('password_confirmation')) ? 'has-error' : '' }}">

            {{
              Form::label(
                'password_confirmation',
                (isset($user->id)) ? trans('users.lbl.new-password-confirmation') : trans('users.lbl.password-confirmation')
              )
            }}

            <div class="input-group">

              {{
                Form::input(
                  'password',
                  'password_confirmation',
                  Input::old('password_confirmation'),
                  array(
                    'class'            => ($errors->has('password_confirmation')) ? 'form-control has-error__icon' : 'form-control',
                    'placeholder'      => (isset($user->id)) ?
                      trans('users.plh.new-password-confirmation') :
                      trans('users.plh.password-confirmation'),
                    'aria-describedby' => 'passwordConfirmationHelp',
                    'aria-labelledby'  => 'passwordConfirmationAddon'
                  )
                )
              }}

              <div class="input-group-append">
                <span id="passwordConfirmationAddon" class="input-group-text rounded-right">
                  <i class="fas fa-check-square fa-fw"></i>
                </span>
              </div>

              @if ($errors->has('password_confirmation'))
              <div class="invalid-feedback">
                {{ $errors->first('password_confirmation') }}
              </div>
              @endif

            </div>

            @if (isset($user->id))
            <small id="passwordConfirmationHelp" class="form-text text-muted">
              <i class="fa fa-asterisk"></i> {{ trans('users.help.password') }}
            </small>
            @endif

          </div>


        @endif

      @else

        <div class="form-group {{ ($errors->has('password')) ? 'has-error' : '' }}">

          {{ Form::label('password', trans('users.lbl.password')) }}<span class="obrigatorio">*</span>

          <div class="input-group">

            {{
              Form::input(
                'password',
                'password',
                Input::old('password'),
                array(
                  'class'            => ($errors->has('password')) ? 'form-control has-error__icon' : 'form-control',
                  'placeholder'      => (isset($user->id)) ? trans('users.plh.new-password') : trans('users.plh.password'),
                  'aria-describedby' => 'passwordHelp',
                  'aria-labelledby'  => 'passwordAddon'
                )
              )
            }}

            <div class="input-group-append">
              <span id="passwordAddon" class="input-group-text rounded-right">
                <i class="fas fa-lock fa-fw"></i>
              </span>
            </div>

            @if ($errors->has('password'))
            <div class="invalid-feedback">
              {{ $errors->first('password') }}
            </div>
            @endif

          </div>

        </div>

        <div class="form-group {{ ($errors->has('password')) ? 'has-error' : '' }}">

          {{ Form::label('password_confirmation', trans('users.lbl.password-confirmation')) }}<span class="obrigatorio">*</span>

          <div class="input-group">

            {{
              Form::input(
                'password',
                'password_confirmation',
                Input::old('password_confirmation'),
                array(
                  'class'            => ($errors->has('password_confirmation')) ? 'form-control has-error__icon' : 'form-control',
                  'placeholder'      => (isset($user->id)) ?
                    trans('users.plh.new-password-confirmation') :
                    trans('users.plh.password-confirmation'),
                  'aria-describedby' => 'passwordConfirmationHelp',
                  'aria-labelledby'  => 'passwordConfirmationAddon'
                )
              )
            }}

            <div class="input-group-append">
              <span id="password_confirmationAddon" class="input-group-text rounded-right">
                <i class="fas fa-lock fa-fw"></i>
              </span>
            </div>

            @if ($errors->has('password_confirmation'))
            <div class="invalid-feedback">
              {{ $errors->first('password_confirmation') }}
            </div>
            @endif

          </div>




      @endif

      @if (Auth::user()->hasRole('ADMIN'))

      <div class="form-group {{ ($errors->has('roles')) ? 'has-error' : '' }}">

        {{ Form::label('roles', trans('users.lbl.roles'))}}<span class="obrigatorio">*</span>

        <div id="roles">
          @foreach ($roles as $role)

            @if (isset($user->id))

              @if ($user->userIsAuth($user) || ($user->minRole()->id <= Auth::user()->minRole()->id))

                @if (in_array($role->name, $user->roles->lists('name')))

                  <label class="form-check-label">
                    <span class="badge badge-secondary">{{ $role->name }}</span>
                  </label>

                @endif

              @else

                @if ($role->id > Auth::user()->minRole()->id)

                  <label
                    class="form-check-label d-block {{ ($role->id > $user->minRole()->id) ? 'not-allowed' : '' }}"
                    style="width: fit-content;">

                    {{
                      Form::checkbox(
                        'roles['.$role->id.']',
                        $role->id,
                        in_array($role->name, $user->roles->lists('name')) ? 'checked' : null,
                        array(
                          'id'    => 'role_'.$role->id,
                          'class' => 'icheck'
                        )
                      )
                    }}

                    {{ $role->name }}

                    <span class="text-secondary d-block">
                      <i class="fas fa-level-down-alt text-dark" style="margin-left: 25px;"></i>
                      {{ $role->description }}
                    </span>

                  </label>

                @endif

              @endif

            @else

              @if ($role->id > Auth::user()->minRole()->id)

                <label class="form-check-label d-block" style="width: fit-content;">

                  {{
                    Form::checkbox(
                      'roles['.$role->id.']',
                      $role->id,
                      null,
                      array(
                        'id'    => 'role_'.$role->id,
                        'class' => 'icheck'
                      )
                    )
                  }}

                  {{ $role->name }}

                  <span class="text-secondary d-block">
                    <i class="fas fa-level-down-alt text-dark" style="margin-left: 25px;"></i>
                    {{ $role->description }}
                  </span>

                </label>

              @endif

            @endif

          @endforeach
        </div>

        @if ($errors->has('roles'))
        <div class="invalid-feedback">
          {{ $errors->first('roles') }}
        </div>
        @endif

        @if (!isset($user->id) || !$user->userIsAuth($user) && ($user->minRole()->id > Auth::user()->minRole()->id))

          <small id="rolesHelp" class="form-text text-muted">
            <i class="fas fa-asterisk"></i> <strong>OBS.:</strong>
            <ol class="pl-3">
              <li>{{ trans('users.help.roles.ol_li-1') }}</li>
              <li>{{ trans('users.help.roles.ol_li-2') }}</li>
              <li>{{ trans('users.help.roles.ol_li-3') }}</li>
              <li>{{ trans('users.help.roles.ol_li-4') }}</li>
            </ol>
          </small>

        @endif

      </div>

      @endif

      @if (
        Auth::user()->hasRole('ADMIN') &&
        isset($user->id) &&
        !$user->userIsAuth($user) &&
        ($user->minRole()->id > Auth::user()->minRole()->id)
      )

      <div class="form-group">

        {{ Form::label('active', trans('application.lbl.status'), array('class' => 'd-block'))}}

          {{
            Form::checkbox(
              'active',
              1,
              ($user->trashed()) ? null : 'checked',
              array(
                'data-toggle'   => 'toggle',
                'data-on'       => trans('application.lbl.active'),
                'data-off'      => trans('application.lbl.inactive'),
                'data-onstyle'  => 'success',
                'data-offstyle' => 'danger'
              )
            )
          }}

        </div>

        <div class="form-group {{ ($errors->has('resetar')) ? 'has-error' : '' }}">

          {{ Form::label('resetar', trans('users.lbl.resetar'), array('class' => 'd-block'))}}

            {{
              Form::checkbox(
                'reset_senha',
                1,
                Input::old('resetar'),
                array(
                  'data-toggle'   => 'toggle',
                  'data-on'       => trans('application.lbl.yes'),
                  'data-off'      => trans('application.lbl.no'),
                  'data-onstyle'  => 'success',
                  'data-offstyle' => 'danger'
                )
              )
            }}

            <small id="rolesHelp" class="form-text text-muted">
              {{trans('users.help.reset.password')}}
            </small>

        </div>

      @endif

    </div><!-- .card-body -->

    <div class="card-footer text-right">
      @if (isset($user->id))

        {{
          link_to_route(
            'users.show',
            trans('application.btn.cancel'),
            $user->id,
            array(
              'class' => 'btn btn-default'
            )
          )
        }}

        {{ Form::submit(trans('application.btn.update'), array('class' => 'btn btn-primary')) }}

      @else

        {{ Form::submit(trans('application.btn.save'), array('class' => 'btn btn-primary')) }}

      @endif
    </div>

  </div>

{{ Form::close() }}
