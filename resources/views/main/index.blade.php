@extends('templates.home')

@section('PAGE_TITLE')

@stop

@section('STYLES')

@stop

@section('MAIN')

<div class="card">

  <div class="row">
    <div class="col-11">
    </div>

    @if(Auth::user())
      <div class="col-1">
        <span class="float-right mr-2">
          <a href="{{ route('users.show', auth()->user()->id) }}">{{trans('users.page.title.show')}}</a>
        </span>
      </div>

    @else
      <div class="col-1">
        <span class="float-right mr-2">
          <a href="/login/">{{trans('application.lbl.login-register')}}</a>
        </span>
      </div>

    @endif

  </div>

  <div class="card-header">

  </div>

  <div class="card-body">

    @include('main/_info')

    <br>

    @include('main/_form')

  </div>

  <div class="card-footer">

  </div>

</div>

@stop

@section('SCRIPTS')

  <!-- ()_SearchPanel -->
  <script src="/assets/js/()_search.panel.js"></script>

  <!-- ()_FilterForm -->
  <script src="/assets/js/()_filter.form.js"></script>

  <!-- ()_TableDescription -->
  <script src="/assets/js/()_table.description.js"></script>

  <!-- ()_DataTable -->
  <script src="/assets/js/()_datatable.js"></script>

  <!-- ()_DataTable - Initialize -->
  <script type="text/javascript">


    $(function() {

      // ()_SearchPanel - Show / Hide
      var searchPanel = new AdminTR.SearchPanel('MAINS');

      searchPanel.initialize();

      // ()_Datatable - onLoad
      var dataTable = new AdminTR.DataTable('main', $('#mainDataTableContainer'), false, false);

      dataTable.initialize();

      // ()_FilterForm - Disable / Enable filter form buttons and Reset DataTable on submit and on clean
      var filterForm = new AdminTR.FilterForm(
                                    'main',
                                    $('#mainDataTableContainer'),
                                    $('#mainFilterForm'),
                                    $('#mainFilterSubmit'),
                                    $("#mainFilterClean")
                                  );

      filterForm.initialize();
    });

  </script>

@stop
