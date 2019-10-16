@extends('templates.auth')

@section('PAGE_TITLE')
  {{ trans('auth.page.title.login') }}
@stop

@section('MAIN')

<div class="login-box">

  <div class="login-logo">
    <img class="img-circle elevation-3" src="assets/img/icone.png" alt="SEPEDI" style="height:15%; width:15%; background-color:#7a2100">
    <b>{{ trans('application.config.name') }}</b>{{ trans('application.config.nickname') }}
  </div>

  <div class="card">

    <div class="card-body login-card-body">

      <p class="login-box-msg text-muted">{{ trans('auth.page.login.info.text') }}</p>

      @include('templates/parts/_messages')

      {{ Form::open(array('url' => 'login')) }}


      <!-- Logar com email -->
        <div class="form-group">

          <div class="input-group {{ ($errors->has('email')) ? 'has-error' : '' }}">

            {{
              Form::email(
                'email',
                Input::old('email'),
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


        <div class="input-group mb-3 {{ ($errors->has('password')) ? 'has-error' : '' }}">

          {{
            Form::input(
              'password',
              'password',
              Input::old('password'),
              array(
                'class'       => 'form-control',
                'placeholder' => trans('users.lbl.password')
              )
            )
          }}

          <div class="input-group-append">
            <span class="input-group-text rounded-right">
              <i class="fas fa-lock fa-fw"></i>
            </span>
          </div>

          @if ($errors->has('password'))
          <div class="invalid-feedback">
            {{ $errors->first('password') }}
          </div>
          @endif
        </div>
        <div class="row">
          <div class="col-8">
            <div class="checkbox">
              <label class="icheck__label">
                {{ Form::checkbox('remember', 'remember', false, array('class' => 'icheck')) }} {{ trans('auth.lbl.remember') }}
              </label>
            </div>
          </div>
          <div class="col-4">
            {{ Form::submit(trans('application.btn.login'), array('class' => 'btn btn-primary btn-block btn-flat')) }}
          </div>
        </div>

      {{ Form::close() }}

      <p class="mt-2 mb-1 text-right">
        <a href="{{ url('password/remind') }}" class="">
          {{ trans('auth.lbl.forgot-my-password') }} <i class="fas fa-arrow-right"></i>
        </a>
      </p>

      <p class="mt-2 mb-1 text-right">
        <a href="{{ url('new') }}" class="">
          {{ trans('auth.lbl.new-user') }} <i class="fas fa-arrow-right"></i>
        </a>
      </p>

    </div>

  </div>

</div>

@stop
