@if(($has_min_permission && !$is_trashed) || ($has_min_permission && $is_printable) || $has_max_permission)

  <li class="nav-item dropdown">

    <a
      class="nav-link dropdown-toggle"
      href="#"
      data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
      {{ trans('application.lbl.options') }}
    </a>

    <div class="dropdown-menu">

      @if($has_max_permission)

        @if($is_trashed)

          <a
            class="dropdown-item"
            href="#modalRestore_{{ $modal_id }}"
            data-toggle="modal">
            <i class="fas fa-recycle fa-fw text-warning"></i> {{ trans('application.btn.restore') }}
          </a>

        @else

          <a
            class="dropdown-item"
            href="#modalDelete_{{ $modal_id }}"
            data-toggle="modal">
            <i class="fas fa-trash-alt fa-fw text-danger"></i> {{ trans('application.btn.delete') }}
          </a>

        @endif

      @endif

      @if($is_printable)

        <div class="dropdown-divider {{ ($is_trashed && !$has_max_permission) ? 'd-none' : '' }}"></div>

        <a
          href="{{ $route_print_one }}"
          class="dropdown-item"
          target="_blank">
          <i class="fas fa-print fa-fw"></i> {{ trans('application.btn.print') }}
        </a>

      @endif

    </div>

  </li>

  @endif
