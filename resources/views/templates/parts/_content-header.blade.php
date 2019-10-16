<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-1">
      <div class="col-sm-6">
        <h1>@yield('PAGE_TITLE')</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right mt-1">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ trans('application.lbl.home') }}</a></li>
          <li class="breadcrumb-item active">@yield('PAGE_TITLE')</li>
        </ol>
      </div>
    </div>
  </div>
</section>