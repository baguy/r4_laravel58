@if( $is_trashed )

  <a
    class="btn btn-warning {{ !$has_permission ? 'disabled' : '' }}"
    href="#modalRestore_{{ $modal_id }}"
    data-toggle="modal"
    data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.restore') }}">
    <i class="fas fa-recycle fa-fw"></i>
  </a>

@elseif( Auth::user() )

  <a
    class="btn btn-danger"
    href="#modalDelete_{{ $modal_id }}"
    data-toggle="modal"
    data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.delete') }}">
    <i class="fas fa-trash-alt fa-fw"></i>
  </a>

@endif

@define $is_author = false;

@if( Auth::user() )
  @foreach(Auth::user()->comments as $key => $value)
    @if($value->id == $modal_id)
      @define $is_author = true;
    @endif
  @endforeach

@endif

@if($is_author)
  <a
    class="btn btn-info"
    href="#modalEdit_{{ $modal_id }}"
    data-toggle="modal"
    data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.edit') }}">
    <i class="fas fa-pencil-alt fa-fw"></i>
  </a>
@endif
