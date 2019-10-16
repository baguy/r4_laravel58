@extends('templates.auth')

@section('PAGE_TITLE')
  {{ trans('auth.page.title.remind') }}
@stop

@section('MAIN')

<div class="login-box">

  <div class="login-logo">
    <b>{{ trans('application.config.name') }}</b>{{ trans('application.config.nickname') }}
  </div>

  <div class="card">

    <div class="card-body login-card-body">

      <p class="login-box-msg text-muted">{{ trans('auth.page.remind.info.text') }}</p>

      @include('templates/parts/_messages')

      {{ Form::open(array('action' => 'AuthController@postRemind')) }}

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