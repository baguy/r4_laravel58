@if ($elements->count())

  <?php if(Auth::guest()){
    $isAdmin = false;
  }else{
    $isAdmin = Auth::user()->hasRole('ADMIN');
  }
  ?>

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

  <div class="table-responsive">

    <table class="table table-hover table-sm table-collapse datatable">

      <caption class="text-center border-top">
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
              'classes' => 'w-auto',
              'sort'    => 'created_at',
              'order'   => $C_sort && !$C_group ? 'ASC' : 'DESC',
              'label'   => trans('home.tab.comentarios'),
              'icon'    => $C_sort && !$C_group ? 'fa-sort text-muted' : 'fa-sort-down'
            ])

          @endif

          <!-- END - Show only when is not grouping -->

          <!-- BEGIN - Show only when is not grouping OR when is the specific group -->

          @if (!$C_group || $C_group === 'status')

            @include('templates/parts/datatable/_datatable__ordering', [
              'classes' => !$C_group ? 'd-none d-sm-table-cell col-status' : '',
              'sort'    => 'status',
              'label'   => trans('home.tab.autor'),
              'group'   => 'status'
            ])

          @endif

          <!-- END - Show only when is not grouping OR when is the specific group -->

          <!-- BEGIN - Show whenever is grouping -->

          @if ($C_group)

            <!-- DATATABLE - table > th - Total  -->
            @include('templates/parts/datatable/_datatable__total--th')

          @endif

          <!-- END - Show whenever is grouping -->

          <!-- BEGIN - Show only when is not grouping -->

          @if (!$C_group)

            <th class="col-options-3">

              <!-- DATATABLE - Options - List  -->
              @include('templates/parts/datatable/_datatable__options--list', array(
                'show_tools'   => false,
                'show_print'   => false,
                'show_export'  => false,
                'is_groupable' => false,
                'groupables'   => [
                  [
                    'group' => 'status',
                    'label' => trans('application.lbl.status')
                  ]
                ]
              ))

            </th>

          @endif

          <!-- END - Show only when is not grouping -->

        </tr>

      </thead>

      <tbody>

        @foreach ($elements as $comment)

          @define $isTrashed = $comment->trashed()

          <tr class="{{ ($isTrashed) ? 'table-danger' : '' }}">

            <!-- BEGIN - Show only when is not grouping -->

            @if (!$C_group)

              <!-- DATATABLE - table > td - Collapse One  -->
              @include('templates/parts/datatable/_datatable__collapse--one', [
                'collapse_id' => "collapseUnidade_$comment->id"
              ])

              <td class="align-middle w-auto">
                <span class="ellipsis">{{ $comment->text }}</span>
              </td>

            @endif

            <!-- END - Show only when is not grouping -->

            <td class="align-middle w-auto">
              @if(is_null($comment->user->avatar))
                <i class="fas fa-user-circle fa-2x text-muted"></i>
              @else
                <img src="{{ asset('assets/_dist/img/avatar/'.$comment->user->avatar) }}"
                     alt="{{ $comment->user->name }}"
                     class="brand-image img-circle elevation-3"
                     style="opacity: .8">
              @endif
              <span class="ellipsis">{{ $comment->user->name }}</span>
            </td>


            <!-- BEGIN - Show whenever is grouping -->

            @if ($C_group)

              <!-- DATATABLE - table > td - Total  -->
              @include('templates/parts/datatable/_datatable__total--td', [ 'model' => $comment ])

            @endif

            <!-- END - Show whenever is grouping -->

            <!-- BEGIN - Show only when is not grouping -->

            @if (!$C_group)

              <td class="align-middle col-options-3">

                @if(Auth::user())
                  @if(Auth::user()->id == $comment->user_id || Auth::user()->hasRole('ADMIN'))

                    <!-- DATATABLE - Options - Buttons  -->
                    @include('templates/parts/datatable/_datatable__options--buttons-main', [
                      'is_trashed'      => $isTrashed,
                      'has_permission'  => true,
                      'modal_id'        => $comment->id,
                      'is_printable'    => false
                    ])

                  @endif
                @endif

              </td>

            @endif

            <!-- END - Show only when is not grouping -->

          </tr>

          <!-- BEGIN - Show only when is not grouping -->

          @if (!$C_group)

          <tr>

            <td class="description">

              <div class="collapse" id="collapseUnidade_{{ $comment->id }}">

                <div class="pt-3 px-3 pb-0">

                  <div class="row">

                    <div class="col-12">

                      <blockquote class="blockquote d-block d-sm-none">
                        <p class="mb-0">
                          <i class="fas fa-signal fa-fw mr-1"></i> {{ trans('application.lbl.status') }}
                        </p>
                        <footer class="blockquote-footer">
                          <span class="badge {{ ($isTrashed) ? 'badge-danger' : 'badge-success' }} badge-pill text-uppercase">
                            {{ ($isTrashed) ? trans('application.lbl.inactive') : trans('application.lbl.active') }}
                          </span>
                        </footer>
                      </blockquote>

                      <blockquote class="blockquote d-block">
                        <small class="mb-0">
                          <i class="fas fa-calendar-alt fa-fw mr-1"></i> {{ trans('application.lbl.created-at') }}
                        </small>
                        <footer class="blockquote-footer">
                          {{ FormatterHelper::dateTimeToPtBR($comment->created_at) }}
                        </footer>
                        <small class="mb-0">
                          <i class="fas fa-calendar-alt fa-fw mr-1"></i> {{ trans('application.lbl.updated-at') }}
                        </small>
                        <footer class="blockquote-footer">
                          {{ FormatterHelper::dateTimeToPtBR($comment->updated_at) }}
                        </footer>
                      </blockquote>

                      @if(strtotime($comment->deleted_at) > 0)
                      <blockquote class="blockquote d-block">
                        <p class="mb-0">
                          <i class="fas fa-calendar-alt fa-fw mr-1"></i> {{ trans('application.lbl.deleted-at') }}
                        </p>
                        <footer class="blockquote-footer text-danger">
                          {{ FormatterHelper::dateTimeToPtBR($comment->deleted_at) }}
                        </footer>
                      </blockquote>
                      @endif

                    </div>

                  </div>

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


    @foreach ($elements as $comment)

      @define $isTrashed = $comment->trashed()

      @if(!$isTrashed)

        @include('main/_modal-delete')

        @include('main/_modal-edit')

      @endif

      @if($isTrashed)

        @include('main/_modal-restore')

      @endif

    @endforeach


@else

  <div class="alert alert-warning mb-0">{{ trans('application.msg.warn.no-records-found') }}</div>

@endif
