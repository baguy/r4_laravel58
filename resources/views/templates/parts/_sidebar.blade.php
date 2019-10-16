<aside class="main-sidebar sidebar-dark-primary elevation-4">

  <!-- Brand Logo -->
  <a href="{{ url('/') }}" class="brand-link">
    <img src="{{ asset('assets/img/icone.png') }}"
         alt="Solutions logo"
         class="brand-image img-circle elevation-3"
         style="opacity: .8">
    <span class="brand-text font-weight-light">
      <b>{{ trans('application.config.name') }}</b>
    </span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">

    <!-- Sidebar User (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        @if(is_null(Auth::user()->avatar))
          <i class="fas fa-user-circle fa-2x text-muted"></i>
        @else
          <img src="{{ asset('assets/_dist/img/avatar/'.Auth::user()->avatar) }}"
               alt="{{ Auth::user()->name }}"
               class="brand-image img-circle elevation-3"
               style="opacity: .8">
        @endif
      </div>
      <div class="info">
        <a href="{{ route('users.show', [ Auth::user()->id ]) }}" class="d-block ellipsis">{{ Auth::user()->name }}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">

      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        @if(Auth::user()->hasRole('ADMIN'))

        <!-- Logs -->

        <li class="nav-item">
          <a href="{{ route('logs.index') }}" class="nav-link {{ (Request::is('logs') ? 'active' : '') }}">
            <i class="nav-icon fas fa-database"></i>
            <p>
              {{ trans('menus.sidebar.item.logs') }}
            </p>
          </a>
        </li>

        @endif

        @if(Auth::user()->hasRole('ADMIN'))

          <!-- Users -->

          <li class="nav-item has-treeview {{ (Request::is('users') || Request::is('users/*') ? 'menu-open' : '') }}">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                {{ trans('menus.sidebar.item.users') }}

                @include('templates/parts/_sidebar__resource-marker', ['resource' => 'users'])

                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link {{ (Request::is('users') ? 'active' : '') }}">
                  <i class="far fa-circle nav-icon {{ (!Request::is('users') ? 'text-info' : '') }}"></i>
                  <p>{{ trans('menus.sidebar.action.list') }}</p>
                </a>
              </li>

              @if(Auth::user()->hasRole('ADMIN'))
                <li class="nav-item">
                  <a href="{{ route('users.create') }}" class="nav-link {{ (Request::is('users/create') ? 'active' : '') }}">
                    <i class="far fa-circle nav-icon {{ (!Request::is('users/create') ? 'text-success' : '') }}"></i>
                    <p>{{ trans('menus.sidebar.action.add') }}</p>
                  </a>
                </li>
              @endif

            </ul>
          </li>

        @endif
        
      </ul>

    </nav>
    <!-- /.Sidebar Menu -->

  </div>
  <!-- /.Sidebar -->

</aside>
