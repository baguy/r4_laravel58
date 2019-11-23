<div class="login-box">

  <div class="card">

    <div class="card-body login-card-body">

      <p class="login-box-msg text-muted">{{ trans('main.info.helper') }}</p>

      @include('templates/parts/_messages')

      {{
        Form::open(
          array(
            'id' => 'twitterForm',
            'route' => 'twitter.newQuery',
            'data-validation-errors' => trans('application.msg.error.validation-errors')
          )
        )
      }}


        <div class="input-group mb-3 {{ ($errors->has('username')) ? 'has-error' : '' }}">

          {{
            Form::input(
              'username',
              'username',
              Input::old('username'),
              array(
                'class'       => 'form-control',
                'placeholder' => trans('main.lbl.username')
              )
            )
          }}

          <div class="input-group-append">
            <span class="input-group-text rounded-right">
              <i class="fab fa-twitter fa-fw"></i>
            </span>
          </div>

          @if ($errors->has('username'))
          <div class="invalid-feedback">
            {{ $errors->first('username') }}
          </div>
          @endif
        </div>

        <div class="row">

          <div class="col-4">
          </div>

          <div class="col-4">
            {{ Form::submit(trans('main.btn.send'), array('class' => 'btn btn-primary btn-block btn-flat')) }}
          </div>

        </div>

      {{ Form::close() }}

    </div>

  </div>

</div>
