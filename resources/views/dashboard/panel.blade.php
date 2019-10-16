@extends('templates.application')

@section('PAGE_TITLE')
  {{ trans('dashboard.page.title.panel') }}
@stop

@section('STYLES')

  <!-- CSS Bootstrap Datepicker -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css') }}"></link>

  <style>
    canvas {
      -moz-user-select: none!important;
      -webkit-user-select: none!important;
      -ms-user-select: none!important;
    }
  </style>

@stop

@section('MAIN')

  @define $users_total_strlen      = strlen($data['users']->total)
  @define $users_active            = str_pad($data['users']->active, $users_total_strlen, '0', STR_PAD_LEFT)
  @define $users_inactive          = str_pad($data['users']->inactive, $users_total_strlen, '0', STR_PAD_LEFT)
  @define $users_attempts          = str_pad($data['users']->attempts, $users_total_strlen, '0', STR_PAD_LEFT)
  @define $users_suspended         = str_pad($data['users']->suspended, $users_total_strlen, '0', STR_PAD_LEFT)

  @define $categorias_total_strlen = strlen($data['categorias']->total)
  @define $categorias_active       = str_pad($data['categorias']->active, $categorias_total_strlen, '0', STR_PAD_LEFT)
  @define $categorias_inactive     = str_pad($data['categorias']->inactive, $categorias_total_strlen, '0', STR_PAD_LEFT)

  @define $itens_total_strlen      = strlen($data['itens']['self']->total)
  @define $itens_active            = str_pad($data['itens']['self']->active, $itens_total_strlen, '0', STR_PAD_LEFT)
  @define $itens_inactive          = str_pad($data['itens']['self']->inactive, $itens_total_strlen, '0', STR_PAD_LEFT)

  @define $termos_total_strlen     = strlen($data['termos']['self']->total)
  @define $termos_active           = str_pad($data['termos']['self']->active, $termos_total_strlen, '0', STR_PAD_LEFT)
  @define $termos_inactive         = str_pad($data['termos']['self']->inactive, $termos_total_strlen, '0', STR_PAD_LEFT)

  <!-- Row -->
	<div class="row">

    <div class="col-lg-3 col-sm-6 col-12">

      <!-- Small Box -->
      @include('dashboard/parts/_small-box', [
        'small_box_color' => 'bg-info', 
        'small_box_value' => $data['users']->total, 
        'small_box_lbl'   => trans('users.users'), 
        'small_box_icon'  => 'fas fa-users', 
        'small_box_route' => route('users.index')
      ])

      <!-- Info Box -->
      @include('dashboard/parts/_info-box', [
        'info_box_color'     => 'bg-info', 
        'info_box_icon'      => 'fas fa-users', 
        'model_active'       => $users_active, 
        'model_active_avg'   => $data['users']->active_avg, 
        'model_inactive'     => $users_inactive, 
        'model_inactive_avg' => $data['users']->inactive_avg
      ])

    </div>

    <div class="col-lg-3 col-sm-6 col-12">

      <!-- Small Box -->
      @include('dashboard/parts/_small-box', [
        'small_box_color' => 'bg-success', 
        'small_box_value' => $data['categorias']->total, 
        'small_box_lbl'   => trans('categorias.categorias'), 
        'small_box_icon'  => 'fas fa-project-diagram', 
        'small_box_route' => route('categorias.index')
      ])

      <!-- Info-Box -->
      @include('dashboard/parts/_info-box', [
        'info_box_color'     => 'bg-success', 
        'info_box_icon'      => 'fas fa-project-diagram', 
        'model_active'       => $categorias_active, 
        'model_active_avg'   => $data['categorias']->active_avg, 
        'model_inactive'     => $categorias_inactive, 
        'model_inactive_avg' => $data['categorias']->inactive_avg
      ])

    </div>

    <div class="col-lg-3 col-sm-6 col-12">

      <!-- Small Box -->
      @include('dashboard/parts/_small-box', [
        'small_box_color' => 'bg-warning', 
        'small_box_value' => $data['itens']['self']->total, 
        'small_box_lbl'   => trans('itens.itens'), 
        'small_box_icon'  => 'fas fa-list-ol', 
        'small_box_route' => route('itens.index')
      ])

      <!-- Info Box -->
      @include('dashboard/parts/_info-box', [
        'info_box_color'     => 'bg-warning', 
        'info_box_icon'      => 'fas fa-list-ol', 
        'model_active'       => $itens_active, 
        'model_active_avg'   => $data['itens']['self']->active_avg, 
        'model_inactive'     => $itens_inactive, 
        'model_inactive_avg' => $data['itens']['self']->inactive_avg
      ])

    </div>

    <div class="col-lg-3 col-sm-6 col-12">

      <!-- Small Box -->
      @include('dashboard/parts/_small-box', [
        'small_box_color' => 'bg-danger', 
        'small_box_value' => $data['termos']['self']->total, 
        'small_box_lbl'   => trans('termos.termos'), 
        'small_box_icon'  => 'fas fa-scroll', 
        'small_box_route' => route('termos.index')
      ])

      <!-- Info Box -->
      @include('dashboard/parts/_info-box', [
        'info_box_color'     => 'bg-danger', 
        'info_box_icon'      => 'fas fa-scroll', 
        'model_active'       => $termos_active, 
        'model_active_avg'   => $data['termos']['self']->active_avg, 
        'model_inactive'     => $termos_inactive, 
        'model_inactive_avg' => $data['termos']['self']->inactive_avg
      ])

    </div>

  </div>

  <!-- Row -->
  <div class="row">

    <div class="col-md-12">

      <!-- Card -->
      <div class="card">

        <!-- Card Header -->
        <div class="card-header">

          <h5 class="card-title pr-6 text-truncate">{{ trans('dashboard.card.users-by-secretary') }}</h5>

          <!-- Card Tools -->
          <div class="card-tools">

            <button type="button" class="btn btn-tool" data-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>

            <div class="btn-group">

              <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                <i class="fas fa-wrench"></i>
              </button>

              <div class="dropdown-menu dropdown-menu-right" role="menu">

                <!-- Menu Chart Options -->
                @include('dashboard/menus/users-secretary-options')

              </div>

            </div>

          </div>

        </div>

        <!-- Card Body -->
        <div class="card-body">

          <div class="row">

            <div class="col-md-8">

              <!-- CHART - Users_secretary__Chart--horizontalBar -->
              @include('dashboard/charts/users-secretary__chart--horizontal-bar')

            </div>

            <div class="col-md-4">

              <!-- CHART - Users_roles__Chart--doughnut -->
              @include('dashboard/charts/users-roles__chart--doughnut')

              <h6 class="text-center py-1 mt-sm-3 mt-lg-5">
                <strong>
                  {{ trans('dashboard.chart.users-by-status.title') }} - {{ FormatterHelper::dateInFull() }}
                </strong>
              </h6>
              
              <!-- Progress Group -->
              @include('dashboard/parts/_progress-group', [
                'progress_lbl' => trans('dashboard.chart.users-by-status.opt.actives'), 
                'progress_partial' => $users_active, 
                'progress_total'   => $data['users']->total, 
                'progress_color'   => 'bg-success', 
                'progress_avg'     => $data['users']->active_avg
              ])

              <!-- Progress Group -->
              @include('dashboard/parts/_progress-group', [
                'progress_lbl' => trans('dashboard.chart.users-by-status.opt.inactives'), 
                'progress_partial' => $users_inactive, 
                'progress_total'   => $data['users']->total, 
                'progress_color'   => 'bg-danger', 
                'progress_avg'     => $data['users']->inactive_avg
              ])

              <!-- Progress Group -->
              @include('dashboard/parts/_progress-group', [
                'progress_lbl' => trans('dashboard.chart.users-by-status.opt.attempts'), 
                'progress_partial' => $users_attempts, 
                'progress_total'   => $data['users']->total, 
                'progress_color'   => 'bg-primary', 
                'progress_avg'     => $data['users']->attempts_avg
              ])

              <!-- Progress Group -->
              @include('dashboard/parts/_progress-group', [
                'progress_lbl' => trans('dashboard.chart.users-by-status.opt.suspended'), 
                'progress_partial' => $users_suspended, 
                'progress_total'   => $data['users']->total, 
                'progress_color'   => 'bg-warning', 
                'progress_avg'     => $data['users']->suspended_avg
              ])

            </div>

          </div>

        </div>

      </div>

    </div>

  </div>

  <!-- Row -->
  <div class="row">

    <div class="col-md-12">

      <!-- Card -->
      <div class="card">

        <!-- Card Header -->
        <div class="card-header">

          <h5 class="card-title pr-6 text-truncate">{{ trans('dashboard.card.subcategories-by-category') }}</h5>

          <!-- Card Tools -->
          <div class="card-tools">

            <button type="button" class="btn btn-tool" data-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>

            <div class="btn-group">

              <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                <i class="fas fa-wrench"></i>
              </button>

              <div class="dropdown-menu dropdown-menu-right" role="menu">

                <!-- Menu Chart Options -->
                @include('dashboard/menus/subcategories-category-options')

              </div>

            </div>

          </div>

        </div>

        <!-- Card Body -->
        <div class="card-body">

          <div class="row">

            <div class="col-md-12">

              <!-- CHART - Subcategories_category__Chart--horizontalBar -->
              @include('dashboard/charts/subcategories-category__chart--horizontal-bar')

            </div>

          </div>

        </div>

        <!-- Card Footer -->
        <div class="card-footer p-2">

          <!-- Carousel -->
          @include('dashboard/parts/_carousel', [
            'model'            => $data['subcategorias'], 
            'carousel_id'      => 'carousel__Subcategories_category', 
            'description_text' => 'categoria'
          ])

        </div>

      </div>

    </div>

  </div>

  <!-- Row -->
  <div class="row">

    <div class="col-md-12">

      <!-- Card -->
      <div class="card">

        <!-- Card Header -->
        <div class="card-header">

          <h5 class="card-title pr-6 text-truncate">{{ trans('dashboard.card.items-by-category') }}</h5>

          <!-- Card Tools -->
          <div class="card-tools">

            <button type="button" class="btn btn-tool" data-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>

            <div class="btn-group">

              <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                <i class="fas fa-wrench"></i>
              </button>

              <div class="dropdown-menu dropdown-menu-right" role="menu">

                <!-- Menu Chart Options -->
                @include('dashboard/menus/items-category-options')

              </div>

            </div>

          </div>

        </div>

        <!-- Card Body -->
        <div class="card-body">

          <div class="row">

            <div class="col-md-12">

              <!-- CHART - Items_category__Chart--radar -->
              @include('dashboard/charts/items-category__chart--radar')

            </div>

          </div>

        </div>

        <!-- Card Footer -->
        <div class="card-footer p-2">

          <!-- Carousel -->
          @include('dashboard/parts/_carousel', [
            'model'            => $data['itens']['por_categoria'], 
            'carousel_id'      => 'carousel__Items_category', 
            'description_text' => 'categoria'
          ])
          
        </div>

      </div>

    </div>

  </div>

  <!-- Row -->
  <div class="row">

    <div class="col-md-12">

      <!-- Card -->
      <div class="card">

        <!-- Card Header -->
        <div class="card-header">

          <h5 class="card-title pr-6 text-truncate">{{ trans('dashboard.card.terms-by-origin') }}</h5>

          <!-- Card Tools -->
          <div class="card-tools">

            <button type="button" class="btn btn-tool" data-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>

            <div class="btn-group">

              <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                <i class="fas fa-wrench"></i>
              </button>

              <div class="dropdown-menu dropdown-menu-right" role="menu">

                <!-- Menu Chart Options -->
                @include('dashboard/menus/terms-origin-options')

              </div>

            </div>

          </div>

        </div>

        <!-- Card Body -->
        <div class="card-body">
          
          <div class="form-row">

            <div class="form-group col-md-4">

              <div class="input-group">

                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-calendar-day fa-fw"></i>
                  </span>
                </div>

                {{ 
                  Form::text(
                    'S_year', 
                    date('Y'), 
                    array('class' => 'form-control js-datepicker-year', 'disabled' => true)
                  ) 
                }}

                <div class="input-group-append">
                  <span 
                    class="input-group-text bg-warning border-warning" 
                    data-tooltip="tooltip" data-placement="top" title="{{ trans('application.lbl.base-year') }}">
                    <i class="fas fa-exclamation fa-fw"></i>
                  </span>
                </div>
              
              </div>

            </div>

          </div>

          <div class="row">

            <div class="col-md-8">

              <!-- CHART - Terms_origin__Chart--bar -->
              @include('dashboard/charts/terms-origin__chart--bar')

            </div>

            <div class="col-md-4">

              <!-- CHART - Terms_destiny__Chart--polarArea -->
              @include('dashboard/charts/terms-destiny__chart--polar-area')

            </div>

          </div>

        </div>

        <!-- Card Footer -->
        <div class="card-footer p-2">

          <!-- Carousel -->
          @include('dashboard/parts/_carousel', [
            'model'            => $data['termos']['por_tipo'], 
            'carousel_id'      => 'carousel__Terms_origin', 
            'description_text' => 'tipo'
          ])

        </div>

      </div>

    </div>

  </div>

@stop

@section('SCRIPTS')

  <!-- JS Chartjs -->
  <script src="{{ asset('assets/plugins/chartjs/Chart.min.js') }}"></script>

  <!-- JQuery File Download -->
  <script src="{{ asset('assets/plugins/download/download.js') }}"></script>

  <!-- JS Bootstrap Datepicker -->
  <script src="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>

  <!-- JS Bootstrap Datepicker - Locale pt-BR -->
  <script src="{{ asset('assets/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.pt-BR.js') }}"></script>

  <!-- ()_ChartBuilder -->
  <script src="{{ asset('assets/js/()_chart.builder.js') }}"></script>

  <!-- ()_DataExport -->
  <script src="{{ asset('assets/js/()_data.export.js') }}"></script>

  <!-- ()_LazyLoader -->
  <script src="{{ asset('assets/js/()_lazy.loader.js') }}"></script>

  <!-- CHARTS -->

  <!-- Usuários por secretaria -->
  <script src="{{ asset('assets/js/charts/users-secretary__chart--horizontal-bar.js') }}"></script>

  <!-- Usuários por níveis -->
  <script src="{{ asset('assets/js/charts/users-roles__chart--doughnut.js') }}"></script>

  <!-- Subcategorias por categoria -->
  <script src="{{ asset('assets/js/charts/subcategories-category__chart--horizontal-bar.js') }}"></script>

  <!-- Itens por categoria -->
  <script src="{{ asset('assets/js/charts/items-category__chart--radar.js') }}"></script>

  <!-- Termos por Secretaria - Origem -->
  <script src="{{ asset('assets/js/charts/terms-origin__chart--bar.js') }}"></script>

  <!-- Termos por Secretarias - Destino -->
  <script src="{{ asset('assets/js/charts/terms-destiny__chart--polar-area.js') }}"></script>

  <script type="text/javascript">

    $(function() {

      // ()_DatePickerYear
      
      var datePickerYear = new AdminTR.DatePickerYear();
      
      datePickerYear.initialize();

      // ()_LazyLoader -> ()_Terms_origin__Chart_bar

      var $_element = $('#Terms_origin__Chart--bar');

      var object    = new AdminTR.Terms_origin__Chart_bar(datePickerYear);

      AdminTR.LazyLoader($_element, object);

      // ()_LazyLoader -> ()_Terms_destiny__Chart_polarArea

      var $_element = $('#Terms_destiny__Chart--polarArea');

      var object    = new AdminTR.Terms_destiny__Chart_polarArea(datePickerYear);

      AdminTR.LazyLoader($_element, object);
    });

  </script>
  
@stop