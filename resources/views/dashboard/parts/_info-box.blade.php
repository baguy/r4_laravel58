<div class="info-box">

  <span class="info-box-icon {{ $info_box_color }} elevation-1"><i class="{{ $info_box_icon }}"></i></span>

  <div class="info-box-content">

    <div class="w-100">
      <span class="text-success">
        {{ trans('application.lbl.active') }}
        <strong class="float-right w-auto text-dark text-right">
          {{ $model_active }} 
          <i class="fas fa-arrow-right fa-xs"></i> 
          <small class="text-secondary">
            {{ $model_active_avg }}
          </small>
        </strong>
      </span>
    </div>

    <div class="w-100">
      <span class="text-danger">
        {{ trans('application.lbl.inactive') }}
        <strong class="float-right w-auto text-dark text-right">
          {{ $model_inactive }} 
          <i class="fas fa-arrow-right fa-xs"></i>  
          <small class="text-secondary">
            {{ $model_inactive_avg }}
          </small>
        </strong>
      </span>
    </div>

  </div>

</div>