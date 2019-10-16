<li class="nav-item dropdown">

  <a class="nav-link" data-toggle="dropdown" href="#">
    <i class="fas fa-users"></i>
    <span class="badge badge-danger navbar-badge">{{ $navbar_vars['messages']->count() }}</span>
  </a>

  <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

    @foreach ($navbar_vars['messages'] as $user)

      @define $attrColor = ($user->trashed()) ? (($user->throttle->suspended) ? 'warning' : 'danger') : 'success'

      <a href="#" class="dropdown-item not-allowed">

        <!-- Message Start -->
        <div class="media">

          <img 
            src="{{ asset('assets/_dist/img/avatar_128x128.png') }}" 
            alt="User Avatar" 
            class="img-size-50 mr-3 img-circle" 
            style="width: 60px; padding: 2px; border: 2px solid #adb5bd;">

          <div class="media-body">

            <h3 class="dropdown-item-title">
              {{ mb_strimwidth($user->name, 0, 17, "...") }}
              <span class="float-right text-sm text-{{ $attrColor }}"><i class="fas fa-star"></i></span>
            </h3>

            <p class="text-sm">

              <span class="text-{{ $attrColor }} text-uppercase">
                {{ 
                  ($user->trashed()) ? 
                    (($user->throttle->suspended) ? 
                      trans('users.lbl.suspended') : 
                      trans('application.lbl.inactive')) : 
                  trans('application.lbl.active') 
                }}
              </span>

              <span class="text-secondary float-right">
                {{ $user->throttle->attempts }} {{ trans('users.lbl.attempts') }}
              </span>

            </p>

            @if($user->deleted_at)

            <p class="text-sm text-{{ $attrColor }}">
              <i class="far fa-clock mr-1"></i> {{ FormatterHelper::dateTimeToPtBR($user->deleted_at) }}
            </p>

            @endif

          </div>

        </div>
        <!-- Message End -->

      </a>

      <div class="dropdown-divider"></div>

    @endforeach

    <a href="{{ route('users.index') }}" class="dropdown-item dropdown-footer">{{ trans('menus.navbar.messages.all') }}</a>

  </div>

</li>