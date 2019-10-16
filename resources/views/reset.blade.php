@extends('templates.auth')

@section('PAGE_TITLE')
  {{ trans('auth.page.title.reset') }}
@stop

@section('MAIN')

<div class="login-box">

  <div class="login-logo">
    <b>{{ trans('application.config.name') }}</b>{{ trans('application.config.nickname') }}
  </div>

  <div class="card">

    <div class="card-body login-card-body">

      <p class="login-box-msg text-muted">{{ trans('auth.page.reset.info.text') }}</p>

      @include('templates/parts/_messages')

      {{ Form::open(array('action' => 'AuthController@postReset')) }}

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group">

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

            <div id="emailAddon" class="input-group-append">
              <span class="input-group-text rounded-right">
                <i class="fas fa-envelope fa-fw"></i>
              </span>
            </div>

            @if ($errors->has('email'))
            <div class="invalid-feedback">
              {{ $errors->first('email') }}
            </div>
            @endif

          </div>

          <small id="emailHelp" class="form-text text-muted">
            {{ trans('application.misc.institutional-email') }} - <code class="text-info" 
            data-tooltip="tooltip" 
            data-placement="bottom" 
            data-container="small" 
            title="{{ trans('application.misc.click-to-copy') }}" style="cursor: pointer;">
              {{'@'}}{{ trans('application.config.site-domain') }}
            </code>
          </small>

        </div>

        <div class="input-group mb-3 {{ ($errors->has('password')) ? 'has-error' : '' }}">
          {{ 
            Form::input(
              'password', 
              'password', 
              Input::old('password'), 
              array(
                'class' => 'form-control', 
                'placeholder' => trans('users.lbl.new-password')
              )
            ) 
          }}

          <div class="input-group-append">
            <span class="input-group-text rounded-right">
              <i class="fas fa-lock"></i>
            </span>
          </div>

          @if ($errors->has('password'))
          <div class="invalid-feedback">
            {{ $errors->first('password') }}
          </div>
          @endif
        </div>

        <div class="input-group mb-3 {{ ($errors->has('password_confirmation')) ? 'has-error' : '' }}">
          {{ 
            Form::input(
              'password', 
              'password_confirmation', 
              Input::old('password_confirmation'), 
              array(
                'class' => 'form-control', 
                'placeholder' => trans('users.lbl.new-password-confirmation')
              )
            ) 
          }}

          <div class="input-group-append">
            <span class="input-group-text rounded-right">
              <i class="fas fa-lock"></i>
            </span>
          </div>
          
          @if ($errors->has('password_confirmation'))
          <div class="invalid-feedback">
            {{ $errors->first('password_confirmation') }}
          </div>
          @endif
        </div>

        <div class="row">
          <div class="col-12">
            {{ Form::submit(trans('application.btn.redefine'), array('class' => 'btn btn-primary btn-block btn-flat')) }}
          </div>
        </div>

      {{ Form::close() }}

    </div>

  </div>

</div>

@stop