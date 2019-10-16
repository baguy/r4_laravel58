@extends('templates.auth')

@section('PAGE_TITLE')
  {{ trans('auth.page.title.remind') }}
@stop

@section('MAIN')

<div class="login-box">

  <div class="login-logo">
    <b>{{ trans('application.config.name') }}</b>
  </div>
  <center>
    {{  trans('auth.lbl.new-user') }}
  </center>

  <div class="card">

    <div class="card-body login-card-body">

      @include('templates/parts/_messages')

      {{
        Form::open(
          array(
            'id' => 'newuserForm',
            'route' => 'auth.newStore',
            'data-validation-errors' => trans('application.msg.error.validation-errors')
          )
        )
      }}

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

        <div class="form-group">

          {{ Form::label('email', trans('users.lbl.email')) }}<span class="obrigatorio">*</span>

          <div class="input-group {{ ($errors->has('email')) ? 'has-error' : '' }}">

            {{
              Form::email(
                'email', Input::old('email'),
                array(
                  'id'               => 'email',
                  'class'            => 'form-control',
                  'placeholder'      => trans('users.lbl.email'),
                  'aria-describedby' => 'emailHelp',
                  'aria-labelledby'  => 'emailAddon'
                )
              )
            }}

            <div class="input-group-append">
              <span id="nameAddon" class="input-group-text rounded-right">
                <i class="fas fa-at fa-fw"></i>
              </span>
            </div>

            @if ($errors->has('email'))
            <div class="invalid-feedback">
              {{ $errors->first('email') }}
            </div>
            @endif

          </div>

        </div>

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

        </div>

        <div class="row">
          <div class="col-12">
            {{ Form::submit(trans('application.btn.send'), array('class' => 'btn btn-primary btn-block btn-flat')) }}
          </div>
        </div>

      {{ Form::close() }}

      <p class="mt-2 mb-1">
        <a href="{{ url('login') }}" class="d-inline-block">
          <i class="fas fa-arrow-left"></i> {{ trans('application.btn.back') }}
        </a>
      </p>

    </div>

  </div>

</div>

@stop

@section('SCRIPTS')

  <!-- JQuery Validation -->
  <script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>

  <!-- JQuery Validation - Additional Methods -->
  <script src="{{ asset('assets/plugins/jquery-validation/additional-methods.min.js') }}"></script>

  <!-- JQuery Validation - Localization pt_BR -->
  <script src="{{ asset('assets/plugins/jquery-validation/localization/messages_pt_BR.min.js') }}"></script>

  <!-- JQuery Form Validator -->
  <script src="{{ asset('assets/js/jQuery.form.validator.js') }}"></script>

  <!-- $_Users -->
  <script src="{{ asset('assets/js/$_users.js') }}"></script>

@stop
