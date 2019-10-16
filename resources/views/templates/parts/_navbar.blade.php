<nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">

  <!-- Left navbar links -->
  <ul class="navbar-nav">

    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
    </li>

    <li class="nav-item d-none d-sm-inline-block">
      <a href="{{ url('/') }}" class="nav-link">{{ trans('application.lbl.home') }}</a>
    </li>

  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">

    {{-- @if(Auth::user()->hasRole('ADMIN')) --}}

      <!-- Messages Dropdown Menu -->
      @include('templates/parts/_navbar__messages-menu')

      <!-- Notifications Dropdown Menu -->
      @include('templates/parts/_navbar__notifications-menu')

    {{-- @endif --}}

    <li class="nav-item">
      <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
        <i class="fas fa-th"></i>
      </a>
    </li>

  </ul>

</nav>
