@extends('templates.application')

@section('PAGE_TITLE')
  {{ trans('users.page.title.change-password') }}
@stop

@section('MAIN')

	{{ 
		Form::model(
			$user, 
			array(
				'id' => 'changePasswordForm', 
				'method' => 'PATCH', 
				'route' => array('users.alter-password', $user->id), 
      	'data-validation-errors' => trans('application.msg.error.validation-errors')
      )
    ) 
  }}

	  <div class="card">
	    <div class="card-header">
	      <h3 class="card-title">
	        {{ trim(trans('application.action.info', ['icon' => '<i class="fas fa-edit"></i>'])) }}
	      </h3>
	    </div>
	    <div class="card-body">

        <div class="form-group {{ ($errors->has('actual_password')) ? 'has-error' : '' }}">

          {{ Form::label('actual_password', trans('users.lbl.actual-password')) }}

          <div class="input-group">

            {{
              Form::input(
                'password', 
                'actual_password', 
                Input::old('actual_password'), 
                array(
                  'class'            => 'form-control', 
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

	        {{ Form::label('password', trans('users.lbl.new-password')) }}

	        <div class="input-group">

	          {{ 
	            Form::input(
	              'password', 
	              'password', 
	              Input::old('password'), 
	              array(
	                'class'            => 'form-control', 
	                'placeholder'      => trans('users.plh.new-password'), 
	                'aria-describedby' => 'passwordAddon'
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

	      <div class="form-group {{ ($errors->has('password_confirmation')) ? 'has-error' : '' }}">

	        {{ Form::label('password_confirmation', trans('users.lbl.new-password-confirmation')) }}

	        <div class="input-group">

	          {{ 
	            Form::input(
	              'password', 
	              'password_confirmation', 
	              Input::old('password_confirmation'), 
	              array(
	                'class'            => 'form-control', 
	                'placeholder'      => (isset($user->id)) ? 
	                  trans('users.plh.new-password-confirmation') : 
	                  trans('users.plh.password-confirmation'), 
	                'aria-describedby' => 'passwordConfirmationAddon'
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

	      </div>

	    </div>

	    <div class="card-footer text-right">
	      {{ Form::submit(trans('application.btn.update'), array('class' => 'btn btn-primary')) }}
	    </div>

	  </div>

	{{ Form::close() }}

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

  <!-- $_ChangePassword -->
  <script src="{{ asset('assets/js/$_change.password.js') }}"></script>
  
@stop