<div class="small-box {{ $small_box_color }}">
  <div class="inner">
    <h3>{{ $small_box_value }}</h3>
    <p>{{ $small_box_lbl }}</p>
  </div>
  <div class="icon">
    <i class="{{ $small_box_icon }}"></i>
  </div>
  <a href="{{ $small_box_route }}" class="small-box-footer">
    {{ trans('application.lbl.more-info') }} <i class="fa fa-arrow-circle-right"></i>
  </a>
</div>