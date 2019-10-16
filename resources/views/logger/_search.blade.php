{{ Form::open(array('method' => 'GET', 'route' => 'logs.index')) }}

  <div class="input-group">

    <div class="input-group-prepend">
    
      <a 
        href="{{ route('logs.index') }}" 
        class="btn btn-outline-secondary" 
        data-tooltip="tooltip" 
        data-placement="top" 
        data-original-title="{{ trans('application.btn.clean') }}">
        <i class="fas fa-times"></i>
      </a>

    </div>
    
    {{ Form::text(
        'search', 
        Input::get('search'), 
        array(
          'class'       => 'form-control', 
          'placeholder' => trans('logger.plh.search')
        )
      ) 
    }}
    
    <div class="input-group-append">

      {{ Form::submit(trans('application.btn.filter'), array('class' => 'btn btn-primary')) }}

    </div>

  </div>

{{ Form::close() }}