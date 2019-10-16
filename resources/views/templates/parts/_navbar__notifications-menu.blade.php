<li class="nav-item dropdown">

  <a class="nav-link" data-toggle="dropdown" href="#">
    <i class="fas fa-bell"></i> <span class="badge badge-warning navbar-badge">{{ $navbar_vars['notifications']->count() }}</span>
  </a>

  <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

    <span class="dropdown-item dropdown-header">{{ trans('menus.navbar.notifications.last', ['count' => Logger::count()]) }}</span>

    <div class="dropdown-divider"></div>

    @foreach ($navbar_vars['notifications'] as $log)

      <a href="#" class="dropdown-item not-allowed" tabindex="-1" aria-disabled="true">

        <i class="far fa-bell mr-2"></i> {{ $log->action }}

        <span class="float-right text-muted text-sm">
          {{ FormatterHelper::dateTimeToPtBR($log->created_at) }}
        </span>

        <small class="d-block text-info text-truncate">
          {{ htmlspecialchars($log->message) }}
        </small>

      </a>

      <div class="dropdown-divider"></div>

    @endforeach
    
    <a href="{{ route('logs.index') }}" class="dropdown-item dropdown-footer">{{ trans('menus.navbar.notifications.all') }}</a>

  </div>

</li>