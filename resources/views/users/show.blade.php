@extends('templates.application')

@section('PAGE_TITLE')
  {{ trans('users.page.title.show') }}
@stop

@section('MAIN')

  @define $isAdmin           = Auth::user()->hasRole('ADMIN')

  @define $userIsAuth        = $user->userIsAuth($user)

  @define $isTrashed         = $user->trashed()

  @define $isSuspended       = $user->throttle->suspended

  @define $isDefaultPassword = $user->throttle->is_default_password

  @define $userMinRoleId     = $user->minRole()->id

  @define $authMinRoleId     = Auth::user()->minRole()->id


  <div class="row">

    <div class="col-md-4">

      <!-- Profile Image -->
      <div class="card card-primary card-outline">

        <div class="card-body box-profile">

          <div class="text-center">

            @if(is_null($user->avatar))
              <img class="profile-user-img img-fluid img-circle"
                   src="{{ asset('assets/_dist/img/avatar_128x128.png') }}"
                   alt="{{ $user->name }}">
            @else
              <img class="profile-user-img img-fluid img-circle"
                   style="height:128px; width:128px;"
                   src="{{ asset('assets/_dist/img/avatar/'.$user->avatar) }}"
                   alt="{{ $user->name }}">
            @endif

          </div>

          <h3 class="profile-username text-center">{{ $user->name }}</h3>

          <p class="text-muted text-center">{{ $user->email }}</p>

          <p class="text-muted text-center">
            <label>{{ trans('users.page.title.avatar') }}</label>
            {{
              link_to_route(
                'users.avatar',
                trans('application.btn.upload'),
                Auth::user()->id,
                array(
                  'class' => 'btn btn-primary btn-sm'
                )
                )
              }}
          </p>

          <ul class="list-group list-group-unbordered mb-3">

            <li class="list-group-item">
              <b>{{ trans('application.lbl.created-at') }}</b>
              <a class="float-right text-secondary">{{ FormatterHelper::dateTimeToPtBR($user->created_at) }}</a>
            </li>

            @if(strtotime($user->updated_at) > 0)

              <li class="list-group-item">
                <b>{{ trans('application.lbl.updated-at') }}</b>
                <a class="float-right text-secondary">{{ FormatterHelper::dateTimeToPtBR($user->updated_at) }}</a>
              </li>

            @endif

            @if($user->deleted_at)

              <li class="list-group-item {{ $isSuspended ? 'text-warning' : 'text-danger' }}">
                <b>{{ $isSuspended ? trans('users.lbl.suspended-at') : trans('application.lbl.deleted-at') }}</b>
                <a class="float-right">{{ FormatterHelper::dateTimeToPtBR($user->deleted_at) }}</a>
              </li>

            @endif

          </ul>

        </div>

        <div class="card-footer text-right">

          @if($isAdmin)

            @if($isTrashed)

              <a
                class="btn btn-light text-warning {{ ($userIsAuth || $userMinRoleId <= $authMinRoleId) ? 'disabled' : '' }}"
                href="#modalRestore_{{ $user->id }}"
                data-toggle="modal"
                data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.restore') }}">
                <i class="fas fa-recycle fa-fw"></i>
              </a>

            @else

              <a
                class="btn btn-light text-danger {{ ($userIsAuth || $userMinRoleId <= $authMinRoleId) ? 'disabled' : '' }}"
                href="#modalDelete_{{ $user->id }}"
                data-toggle="modal"
                data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.delete') }}">
                <i class="fas fa-trash-alt fa-fw"></i>
              </a>

            @endif

          @endif

          <a
            href="{{ route('users.edit', [ $user->id ]) }}"
            class="btn btn-light text-info {{ ($isTrashed) ? 'disabled' : '' }}"
            data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.edit') }}">
            <i class="fas fa-pencil-alt fa-fw"></i>
          </a>

          <a
            href="{{ route('users.change-password', [ $user->id ]) }}"
            class="btn btn-light text-warning {{ ($isTrashed || !$userIsAuth) ? 'disabled' : '' }}"
            data-tooltip="tooltip" data-placement="top" title="{{ trans('users.page.title.change-password') }}">
            <i class="fas fa-lock fa-fw"></i>
          </a>

          {{-- <a
            href="{{ route('users.print-one', [ $user->id ]) }}"
            class="btn btn-light text-dark"
            target="_blank"
            data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.print') }}">
            <i class="fas fa-print fa-fw"></i>
          </a> --}}

        </div>

      </div>
      <!-- /.Profile Image -->

      <!-- About Me Box -->
      <div class="card card-primary">

        <div class="card-header">
          <h3 class="card-title">{{ trans('application.lbl.about') }}</h3>
        </div>

        <div class="card-body">
          <strong><i class="fas fa-user fa-fw mr-1"></i> {{ trans('users.lbl.name') }}</strong>

          <p class="text-muted">{{ $user->name }}</p>

          <hr>

          <strong><i class="fas fa-envelope fa-fw mr-1"></i> {{ trans('users.lbl.email') }}</strong>

          <p class="text-muted">{{ $user->email }}</p>

          <hr>

          <strong class="d-block"><i class="fas fa-toggle-on fa-fw mr-1"></i> {{ trans('application.lbl.status') }}</strong>

          <span class="badge {{ ($isTrashed) ? 'badge-danger' : 'badge-success' }} badge-pill text-uppercase">
            {{ ($isTrashed) ? trans('application.lbl.inactive') : trans('application.lbl.active') }}
          </span>

          <hr>

          <strong class="d-block"><i class="fas fa-layer-group fa-fw mr-1"></i> {{ trans('users.lbl.roles') }}</strong>

          <span class="badge badge-secondary">
            {{ $user->minRole()->name }}
          </span>

        </div>

      </div>
      <!-- /.About Me Box -->

    </div>

    <div class="col-md-8">

      <!-- Nav Tabs Custom -->
      <div class="card">

        <div class="card-header p-2">
          <ul class="nav nav-pills">
            <li class="nav-item">
              <a class="nav-link active" href="#activity" data-toggle="tab">
                {{ trans('users.tab.activity') }}
              </a>
            </li>
          @if ( Auth::user()->hasRole('ADMIN') )
            <li class="nav-item">
              <a class="nav-link" href="#logs" data-toggle="tab">
                {{ trans('users.tab.logs') }}
              </a>
            </li>
          @endif
          </ul>
        </div>

        <!-- Card Body -->
        <div class="card-body">

          <!-- Tab Content -->
          <div class="tab-content">

            <!-- Tab Pane -->
            <div class="active tab-pane" id="activity">

              <!-- Post -->
              <div class="post">

                <strong><i class="fas fa-sign-in-alt fa-fw mr-1"></i> {{ trans('users.lbl.last-access') }}</strong>

                <p class="text-muted">
                  @if(strtotime($user->throttle->last_access_at) > 0)

                    {{
                      trans('users.msg.last-access', [
                        'datetime' => FormatterHelper::dateTimeToPtBR($user->throttle->last_access_at)
                      ])
                    }}

                  @else

                    {{ trans('users.msg.no-access') }}

                  @endif
                </p>

                <hr>

                @define $minutes = 0

                @if ($isSuspended)

                  @define $time    = strtotime($user->throttle->last_attempt_at . User::SUSPENSION_TIME) - strtotime('now');

                  @define $minutes = round(((($time % 604800) % 86400) % 3600) / 60);

                @endif

                <strong><i class="fas fa-clock fa-fw mr-1"></i> {{ trans('users.lbl.suspended') }}</strong>

                <p class="text-muted">

                  @if ($minutes > 0)

                    {{ trans('users.msg.suspended', ['minutes' => $minutes]) }}

                  @else

                    @if ($isSuspended)

                      {{ trans('users.msg.suspension-time-ended') }}

                    @else

                      {{ trans('users.msg.not-suspended') }}

                    @endif

                  @endif

                </p>


              </div>
              <!-- /.Post -->

            </div>
            <!-- /.Tab Pane -->


          </div>
          <!-- /.Tab Content -->

        </div>
        <!-- /.Card Body -->

      </div>
      <!-- /.Nav Tabs Custom -->

    </div>
    <!-- /.Col -->

  </div>

  @if(!$isTrashed)

    @include('users/_modal-delete')

  @endif

  @if($isTrashed)

    @include('users/_modal-restore')

  @endif

@stop
