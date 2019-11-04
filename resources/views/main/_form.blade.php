<div class="login-box">

  <div class="card">

    <div class="card-body login-card-body">

      <p class="login-box-msg text-muted">{{ trans('main.info.helper') }}</p>

      @include('templates/parts/_messages')

      {{ Form::open(array('url' => 'atprofile.newQuery')) }}


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
              <i class="fab fa-twitter fa-fw"></i>
            </span>
          </div>

          @if ($errors->has('password'))
          <div class="invalid-feedback">
            {{ $errors->first('password') }}
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
