<div class="input-group">

  {{
    Form::select(
      'DT_per_page',
      [
        '10'  => mb_strtoupper(Lang::get('application.form.select.items-per-page', ['number' => 10]), 'UTF-8'),
        '25'  => mb_strtoupper(Lang::get('application.form.select.items-per-page', ['number' => 25]), 'UTF-8'),
        '50'  => mb_strtoupper(Lang::get('application.form.select.items-per-page', ['number' => 50]), 'UTF-8'),
        '100' => mb_strtoupper(Lang::get('application.form.select.items-per-page', ['number' => 100]), 'UTF-8')
      ],
      null,
      array(
        'id'    => 'DT_per_page',
        'class' => 'custom-select custom-select-sm'
      )
    )
  }}

  @if ($show_tools)

    <div class="input-group-append">

      <button
        class="btn btn-outline-secondary btn-sm rounded-right"
        type="button"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static"
        data-tooltip="tooltip" data-placement="top" title="{{ trans('application.lbl.options') }}">
        <i class="fas fa-cog align-middle"></i>
      </button>

      <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left">

        @if ($show_print)

          <a href="{{ $route_print_all }}" target="_blank" class="dropdown-item js-print-all">
            <i class="fas fa-print fa-fw"></i> {{ trans('application.btn.print') }}
          </a>

        @endif

        @if ($show_export)

          <a href="{{ $route_export }}" class="dropdown-item js-export-xls">
            <i class="fas fa-table fa-fw"></i> {{ trans('application.btn.excel') }}
          </a>

        @endif

        @if (($show_print || $show_export) && $is_groupable)

          <div class="dropdown-divider"></div>

        @endif

        @if ($is_groupable)

          <h6 class="dropdown-header text-uppercase text-left">{{ trans('application.btn.group') }}</h6>

          @foreach ($groupables as $groupable)

            <a
              href="?action=group_by"
              class="dropdown-item text-secondary"
              data-group="{{ $groupable['group'] }}"
              data-groupable="true">

              <i
                class="fas fa-object-group"
                data-tooltip="tooltip"
                data-placement="left"
                data-original-title="{{ trans('application.btn.group') }}"
                data-replacement-title="{{ trans('application.btn.ungroup') }}">
                <span class="bs-font-family">{{ $groupable['label'] }}</span>
              </i>

            </a>

          @endforeach

        @endif

      </div>

    </div>

  @endif

</div>
