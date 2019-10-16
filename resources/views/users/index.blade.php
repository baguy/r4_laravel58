@extends('templates.application')

@section('PAGE_TITLE')
  {{ trans('users.page.title.index') }}
@stop

@section('STYLES')

  <!-- &_Users -->
  <link rel="stylesheet" href="{{ asset('assets/css/&_users.css') }}">

@stop

@section('MAIN')

<div class="card">

  <div class="card-header">

    @include('users/_legends')

    <span class="float-right">
      {{
        link_to_route(
          'users.create',
          trans('application.btn.add-new'),
          null,
          array(
            'class' => 'btn btn-success btn-sm'
          )
        )
      }}
    </span>

  </div>

  <div class="card-body">

    @include('users/_filter-form')

    <div id="usersDataTableContainer" data-datatable-error="{{ trans('application.msg.error.datatable') }}"></div>

  </div>

  <div class="card-footer">

    @include('users/_legends')

    <span class="float-right">
      {{
        link_to_route(
          'users.create',
          trans('application.btn.add-new'),
          null,
          array(
            'class' => 'btn btn-success btn-sm'
          )
        )
      }}
    </span>

  </div>

</div>

@stop

@section('SCRIPTS')

  <!-- Search Panel -->
  <script src="{{ asset('assets/js/()_search.panel.js') }}"></script>

  <!-- Filter Form -->
  <script src="{{ asset('assets/js/()_filter.form.js') }}"></script>

  <!-- Table Description -->
  <script src="{{ asset('assets/js/()_table.description.js') }}"></script>

  <!-- DataTable -->
  <script src="{{ asset('assets/js/()_datatable.js') }}"></script>

  <!-- JQuery File Download -->
  <!-- <script src="{{ asset('assets/plugins/jquery-fileDownload/jquery.fileDownload.js') }}"></script> -->

  <!-- Data Export -->
  <script src="{{ asset('assets/js/()_data.export.js') }}"></script>

  <!-- Data Print -->
  <script src="{{ asset('assets/js/()_data.print.js') }}"></script>

  <!-- ()_Select2Builder -->
  <script src="{{ asset('assets/js/()_select2.builder.js') }}"></script>

  <!-- DataTable - Initialize -->
  <script type="text/javascript">

  $(function() {

    // ()_SearchPanel - Show / Hide
    var searchPanel = new AdminTR.SearchPanel('USERS');

    searchPanel.initialize();

    // ()_Datatable - onLoad
    var dataTable = new AdminTR.DataTable('users', $('#usersDataTableContainer'), false, false);

    dataTable.initialize();

    // ()_FilterForm - Disable / Enable filter form buttons and Reset DataTable on submit and on clean
    var filterForm = new AdminTR.FilterForm(
                                  'users',
                                  $('#usersDataTableContainer'),
                                  $('#usersFilterForm'),
                                  $('#usersFilterSubmit'),
                                  $("#usersFilterClean")
                                );

    filterForm.initialize();
  });

</script>

@stop
