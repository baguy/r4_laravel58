@if ($elements->count())

  @define $isSuper = Auth::user()->hasRole('SUPER')

  @define $C_sort  = Input::get('C_sort')

  @define $C_group = Input::get('C_group')

  <div class="text-center text-secondary border-top py-3">
    {{
      trans('pagination.table.caption', [
        'total' => $elements->getTotal(),
        'currentPage' => $elements->getCurrentPage(),
        'lastPage' => $elements->getLastPage(),
        'perPage' => $elements->getPerPage()
      ])
    }}
  </div>

  <div class="table-responsive table-responsive--mh">

    <table class="table table-hover table-sm table-collapse datatable">

      <caption class="text-center">
        {{
          trans('pagination.table.caption', [
            'total' => $elements->getTotal(),
            'currentPage' => $elements->getCurrentPage(),
            'lastPage' => $elements->getLastPage(),
            'perPage' => $elements->getPerPage()
          ])
        }}
      </caption>

      <thead>

        <tr>

          <!-- BEGIN - Show only when is not grouping -->

          @if (!$C_group)

            <!-- DATATABLE - table > th - Collapse All  -->
            @include('templates/parts/datatable/_datatable__collapse--all')

            @include('templates/parts/datatable/_datatable__ordering', [
              'classes' => 'col-name',
              'sort'    => 'name',
              'order'   => $C_sort && !$C_group ? 'ASC' : 'DESC',
              'label'   => trans('users.lbl.name'),
              'icon'    => $C_sort && !$C_group ? 'fa-sort text-muted' : 'fa-sort-down'
            ])

            @include('templates/parts/datatable/_datatable__ordering', [
              'classes' => 'd-none d-md-table-cell col-email',
              'sort'    => 'email',
              'label'   => trans('users.lbl.email')
            ])

          @endif

          <!-- END - Show only when is not grouping -->

          <!-- BEGIN - Show only when is not grouping OR when is the specific group -->

          @if (!$C_group || $C_group === 'status')

            @include('templates/parts/datatable/_datatable__ordering', [
              'classes' => !$C_group ? 'd-none d-sm-table-cell col-status' : 'col-status',
              'sort'    => 'status',
              'label'   => trans('application.lbl.status'),
              'group'   => 'status'
            ])

          @endif

          @if (!$C_group || $C_group === 'roles')

            @include('templates/parts/datatable/_datatable__ordering', [
              'classes' => 'col-roles',
              'sort'    => 'roles.name',
              'label'   => trans('users.lbl.roles'),
              'group'   => 'roles'
            ])

          @endif

          <!-- END - Show only when is not grouping OR when is the specific group -->


          @if ($C_group === 'attempts')

            @include('templates/parts/datatable/_datatable__ordering', [
              'classes' => 'col-attempts',
              'sort'    => 'attempts',
              'label'   => trans('users.lbl.attempts'),
              'group'   => 'attempts'
            ])

          @endif

          <!-- END - Show only when is the specific group -->

          <!-- BEGIN - Show whenever is grouping -->

          @if ($C_group)

            <!-- DATATABLE - table > th - Total  -->
            @include('templates/parts/datatable/_datatable__total--th')

          @endif

          <!-- END - Show whenever is grouping -->

          <th class="col-options-4">

            <!-- DATATABLE - Options - List  -->
            @include('templates/parts/datatable/_datatable__options--list', array(
              'show_tools' => true,
              'show_print' => true,
              'route_print_all' => route('users.print-all'),
              'show_export' => true,
              'route_export' => route('users.export', ['type' => 'xls']),
                'is_groupable'    => true,
                'groupables'      => [
                  [
                    'group' => 'roles',
                    'label' => trans('users.lbl.roles')
                  ],
                  [
                    'group' => 'status',
                    'label' => trans('application.lbl.status')
                  ],
                  [
                    'group' => 'attempts',
                    'label' => trans('users.lbl.attempts')
                  ]
                ]
            ))

          </th>

        </tr>

      </thead>

      <tbody>

        @foreach ($elements as $user)

          @define $userIsAuth                    = $user->userIsAuth($user)

          @define $userRoleLessEqualThanAuthRole = $user->userMinRoleIsLessOrEqualThanAuthMinRole($user)

          @define $isTrashed                     = $user->trashed()

          @define $isSuspended                   = $user->throttle->suspended

          @define $isDefaultPassword             = $user->throttle->is_default_password

          <tr class="{{ ($isTrashed) ? (($isSuspended) ? 'table-warning' : 'table-danger') : '' }}">

            <!-- BEGIN - Show only when is not grouping -->

            @if (!$C_group)

              <!-- DATATABLE - table > td - Collapse One  -->
              @include('templates/parts/datatable/_datatable__collapse--one', [
                'collapse_id' => "collapseUser_$user->id"
              ])

              <td class="align-middle col-name">
                <small class="d-block ellipsis">{{ $user->name }}</small>
              </td>

              <td class="d-none d-md-table-cell align-middle col-email">
                <span class="d-block ellipsis text-secondary">{{ $user->email }}</span>
              </td>

            @endif

            <!-- END - Show only when is not grouping -->

            <!-- BEGIN - Show only when is not grouping OR when is the specific group -->

            @if (!$C_group || $C_group === 'status')

              @define $badgeColor = ($isTrashed) ? (($isSuspended) ? 'badge-warning' : 'badge-danger') : 'badge-success'

              <td class="align-middle px-2 text-uppercase {{ !$C_group ? 'd-none d-sm-table-cell col-status' : '' }}">
                <span class="badge {{ $badgeColor }} badge-pill d-block">
                  {{
                    ($isTrashed) ?
                      (($isSuspended) ?
                        trans('users.lbl.suspended') :
                        trans('application.lbl.inactive')) :
                    trans('application.lbl.active')
                  }}
                </span>
              </td>

            @endif

            @if (!$C_group || $C_group === 'roles')

              <td class="align-middle px-2 col-roles">
                <span class="badge badge-secondary d-block">
                  {{ $user->minRole()->name }}
                </span>
              </td>

            @endif

            <!-- END - Show only when is not grouping OR when is the specific group -->

            <!-- BEGIN - Show only when is the specific group -->

            @if ($C_group === 'attempts')

              <td class="align-middle col-attempts">
                {{ ($user->throttle->attempts > 0) ? trans('application.lbl.yes') : trans('application.lbl.no') }}
              </td>

            @endif

            <!-- END - Show only when is the specific group -->

            <!-- BEGIN - Show whenever is grouping -->

            @if ($C_group)

              <td class="align-middle col-total">
                {{ $user->total       ? $user->total       : null }}

                {{ $user->active      ? $user->active      : null }}
                {{ $user->inactive    ? $user->inactive    : null }}

                {{ $user->suspended   ? $user->suspended   : null }}

                {{ $user->attempts    ? $user->attempts    : null }}
                {{ $user->no_attempts ? $user->no_attempts : null }}
              </td>

            @endif

            <!-- END - Show whenever is grouping -->

            <td class="align-middle col-options-4">

              <!-- BEGIN - Show only when is not grouping -->

              @if (!$C_group)

                @if($isTrashed)

                  <a
                    class="btn btn-warning {{ ($userIsAuth || $userRoleLessEqualThanAuthRole) ? 'disabled' : '' }}"
                    href="#modalRestore_{{ $user->id }}"
                    data-toggle="modal"
                    data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.restore') }}">
                    <i class="fas fa-recycle fa-fw"></i>
                  </a>

                @else

                  <a
                    class="btn btn-danger {{ ($userIsAuth || $userRoleLessEqualThanAuthRole) ? 'disabled' : '' }}"
                    href="#modalDelete_{{ $user->id }}"
                    data-toggle="modal"
                    data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.delete') }}">
                    <i class="fas fa-trash-alt fa-fw"></i>
                  </a>

                @endif

                <a
                  href="{{ route('users.edit', [ $user->id ]) }}"
                  class="btn btn-info {{ ($isTrashed || (!$userIsAuth && $userRoleLessEqualThanAuthRole)) ? 'disabled' : '' }}"
                  data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.edit') }}">
                  <i class="fas fa-pencil-alt fa-fw"></i>
                </a>

                <a
                  href="{{ route('users.show', [ $user->id ]) }}"
                  class="btn btn-default {{ (!$userIsAuth && $userRoleLessEqualThanAuthRole) ? 'disabled' : '' }}"
                  data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.show') }}">
                  <i class="fas fa-search fa-fw"></i>
                </a>

                <a
                  href="{{ route('users.print-one', [ $user->id ]) }}"
                  class="btn btn-dark"
                  target="_blank"
                  data-tooltip="tooltip" data-placement="top" title="{{ trans('application.btn.print') }}">
                  <i class="fas fa-print fa-fw"></i>
                </a>

              @endif

              <!-- END - Show only when is not grouping -->

            </td>

          </tr>

          <!-- BEGIN - Show only when is not grouping -->

          @if (!$C_group)

          <tr>

            <td class="description">

              <div class="collapse" id="collapseUser_{{ $user->id }}">

                <div class="pt-3 px-3 pb-0">

                  <div class="row">

                    <div class="col-md-6">

                      <blockquote class="blockquote d-block d-md-none">
                        <p class="mb-0">
                          <i class="fas fa-envelope fa-fw mr-1"></i> {{ trans('users.lbl.email') }}
                        </p>
                        <footer class="blockquote-footer">
                          {{ $user->email }}
                        </footer>
                      </blockquote>

                      <blockquote class="blockquote d-block d-sm-none">
                        <p class="mb-0">
                          <i class="fas fa-signal fa-fw mr-1"></i> {{ trans('application.lbl.status') }}
                        </p>
                        <footer class="blockquote-footer">
                          <span
                            class="badge {{ ($isTrashed) ? 'badge-danger' : 'badge-success' }} badge-pill text-uppercase">
                            {{ ($isTrashed) ? trans('application.lbl.inactive') : trans('application.lbl.active') }}
                          </span>
                        </footer>
                      </blockquote>

                      <blockquote class="blockquote">
                        <p class="mb-0">
                          <i class="fas fa-calendar-alt fa-fw mr-1"></i> {{ trans('application.lbl.created-at') }}
                        </p>
                        <footer class="blockquote-footer">
                          {{ FormatterHelper::dateTimeToPtBR($user->created_at) }}
                        </footer>
                      </blockquote>

                      @if(strtotime($user->updated_at) > 0)

                        <blockquote class="blockquote">
                          <p class="mb-0">
                            <i class="fas fa-calendar-alt fa-fw mr-1"></i> {{ trans('application.lbl.updated-at') }}
                          </p>
                          <footer class="blockquote-footer">
                            {{ FormatterHelper::dateTimeToPtBR($user->updated_at) }}
                          </footer>
                        </blockquote>

                      @endif

                      @if($user->deleted_at)

                        <blockquote class="blockquote">
                          <p class="mb-0">
                            <i class="fas fa-calendar fa-fw mr-1"></i>
                            {{ ($isSuspended) ? trans('users.lbl.suspended-at') : trans('application.lbl.deleted-at') }}
                          </p>
                          <footer class="blockquote-footer {{ ($isSuspended) ? 'text-warning' : 'text-danger' }}">
                            {{ FormatterHelper::dateTimeToPtBR($user->deleted_at) }}
                          </footer>
                        </blockquote>

                      @endif

                      <blockquote class="blockquote">
                        <p class="mb-0">
                          <i class="fas fa-lock fa-fw mr-1"></i> {{ trans('users.ask.default-password-has-been-changed') }}
                        </p>
                        <footer class="blockquote-footer {{ ($isDefaultPassword) ? 'text-danger' : 'text-success' }}">

                          @if($isDefaultPassword)

                            <span class="badge badge-danger badge-pill text-uppercase">
                              {{ trans('application.lbl.no') }}
                            </span>

                          @else

                            <span class="badge badge-success badge-pill text-uppercase">
                              {{ trans('application.lbl.yes') }}
                            </span>

                          @endif

                        </footer>
                      </blockquote>


                    </div>

                    <div class="col-md-6">

                      <blockquote class="blockquote d-block">
                        <p class="mb-0">
                          <i class="fas fa-sign-in-alt fa-fw mr-1"></i> {{ trans('users.lbl.last-access') }}
                        </p>
                        <footer class="blockquote-footer">

                          @if(strtotime($user->throttle->last_access_at) > 0)

                            {{
                              trans('users.msg.last-access', [
                                'datetime' => FormatterHelper::dateTimeToPtBR($user->throttle->last_access_at)
                              ])
                            }}

                          @else

                            {{ trans('users.msg.no-access') }}

                          @endif

                        </footer>
                      </blockquote>

                      @define $minutes = 0

                      @if ($isSuspended)

                        @define $time = strtotime($user->throttle->last_attempt_at . User::SUSPENSION_TIME) - strtotime('now')

                        @define $minutes = round(((($time % 604800) % 86400) % 3600) / 60)

                      @endif

                      <blockquote class="blockquote d-block">
                        <p class="mb-0">
                          <i class="fas fa-clock fa-fw mr-1"></i> {{ trans('users.lbl.suspended') }}
                        </p>
                        <footer class="blockquote-footer">

                          @if ($minutes > 0)

                            {{ trans('users.msg.suspended', ['minutes' => $minutes]) }}

                          @else

                            @if ($isSuspended)

                              {{ trans('users.msg.suspension-time-ended') }}

                            @else

                              {{ trans('users.msg.not-suspended') }}

                            @endif

                          @endif

                        </footer>
                      </blockquote>

                      <blockquote class="blockquote d-block">
                        <p class="mb-0">
                          <i class="fas fa-list-ol fa-fw mr-1"></i> {{ trans('users.lbl.attempts') }}
                        </p>
                        <footer class="blockquote-footer">
                          {{ trans('users.msg.attempts', ['attempts' => $user->throttle->attempts]) }}
                        </footer>
                      </blockquote>

                      <blockquote class="blockquote d-block">
                        <p class="mb-0">
                          <i class="fas fa-calendar-day fa-fw mr-1"></i> {{ trans('users.lbl.last-attempt') }}
                        </p>
                        <footer class="blockquote-footer">

                          @if(strtotime($user->throttle->last_attempt_at) > 0)

                            {{
                              trans('users.msg.last-attempt', [
                                'datetime' => FormatterHelper::dateTimeToPtBR($user->throttle->last_attempt_at)
                              ])
                            }}

                          @else

                            {{ trans('users.msg.no-last-attempt') }}

                          @endif

                        </footer>
                      </blockquote>

                    </div>

                  </div>

                  @if($isSuper)

                  <a
                    class="btn btn-warning mb-3 {{ $userIsAuth ? 'disabled' : '' }}"
                    href="#modalRedefinePassword_{{ $user->id }}"
                    data-toggle="modal">
                    {{ trans('application.btn.redefine') }} {{ trans('users.lbl.password') }}
                  </a>

                  @endif

                </div>

              </div>

            </td>

          </tr>

          @endif

          <!-- END - Show only when is not grouping -->

        @endforeach

      </tbody>

    </table>

  </div>

  {{ $elements->links() }}

  @foreach ($elements as $user)

    @if (!$user->userIsAuth($user) && !$user->userMinRoleIsLessOrEqualThanAuthMinRole($user))

      @define $isTrashed = $user->trashed()

      @if(!$isTrashed)

        @include('users/_modal-delete')

      @endif

      @if($isTrashed)

        @include('users/_modal-restore')

      @endif

      @if($isSuper)

        @include('users/_modal-redefine-password')

      @endif

    @endif

  @endforeach

@else

  <div class="alert alert-warning mb-0">{{ trans('application.msg.warn.no-records-found') }}</div>

@endif
