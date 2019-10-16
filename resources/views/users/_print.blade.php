@define $index = 1

@if ($key === 0)

  <div class="row my-2 d-print-none">
    <div class="col text-right">
      <button type="button" class="btn btn-warning" onclick="window.print();">
        <i class="fas fa-print fa-fw"></i> 
        {{ trans('application.btn.print') }}
      </button>
    </div>
  </div>

  @if (isset($users) && $users->count())

    {{ $users->appends(Input::get())->links() }}

    <div class="text-center text-secondary pt-0 pb-3 d-print-none">
      {{ 
        trans('pagination.table.caption', [
          'total' => $users->getTotal(), 
          'currentPage' => $users->getCurrentPage(), 
          'lastPage' => $users->getLastPage(), 
          'perPage' => $users->getPerPage()
        ]) 
      }}
    </div>

  @endif

@endif

@if ($C_group)

  <div class="row page-header {{ ($key > 0) ? ($key%12 === 0) ? 'page-break__before' : 'mt-0' : '' }}">

    <div class="col">

      @if ($key === 0)
            
      <!-- ### HEADER ### -->
        
      <h4 class="bg-dark p-2">
        <i class="fas fa-file-alt"></i> 
        {{ trans('users.user(s)') }} 
        <span class="badge badge-light float-right">

          @define $attribute = $C_group

          @if ($C_group === 'attempts')

            @define $attribute = trans('users.lbl.attempts')

          @endif

          @if ($C_group === 'roles')

            @define $attribute = trans('users.lbl.roles')

          @endif

          {{ trans('application.lbl.grouped-by', ['attribute' => ucfirst($attribute)]) }}
        </span>
      </h4>

      @endif

      <!-- ### QUADRO ### -->
        
      <table class="table table-bordered table-printable border-0 mb-2">
        <tbody>
          <tr>
            <td class="py-1 text-center align-middle font-weight-bold bg-gray w-50px" rowspan="2">
              {{ ++$key }}
            </td>
            <td>
              <label class="mb-0 font-italic">
                {{ ($C_group === 'roles')       ? trans('users.lbl.roles').':'           : '' }}
                {{ ($C_group === 'secretarias') ? trans('secretarias.secretaria').':'    : '' }}
                {{ ($C_group === 'status')      ? trans('application.lbl.status').':'    : '' }}
                {{ ($C_group === 'attempts')    ? trans('users.lbl.attempts').':'        : '' }}
              </label> 

              {{ ($C_group === 'roles')       ? $user->minRole()->name : '' }}
              {{ ($C_group === 'secretarias') ? $user->secretaria      : '' }}
              {{ ($C_group === 'attempts')    ? ($user->throttle->attempts > 0) ? trans('application.lbl.yes') : trans('application.lbl.no') : '' }}
              
              @if ($C_group === 'status')
                <span class="{{ ($user->trashed()) ? (($user->throttle->suspended) ? 'text-warning' : 'text-danger') : 'text-success' }} text-uppercase mb-0">
                  {{ 
                    ($user->trashed()) ? 
                      (($user->throttle->suspended) ? 
                        trans('users.lbl.suspended') : 
                        trans('application.lbl.inactive')) : 
                    trans('application.lbl.active') 
                  }}
                </span>
              @endif
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <label class="mb-0 font-italic">{{ trans('application.lbl.total') }}:</label> 
              {{ $user->total    ? $user->total    : null }}

              {{ $user->active   ? $user->active   : null }}
              {{ $user->inactive ? $user->inactive : null }}

              {{ $user->suspended   ? $user->suspended   : null }}

              {{ $user->attempts    ? $user->attempts    : null }}
              {{ $user->no_attempts ? $user->no_attempts : null }}
            </td>
          </tr>
        </tbody>
      </table>

    </div>

  </div>

@else

  <div class="row js-print-block mx-0 page-break__inside--avoid">

    <div class="col">
        
      <!-- ### HEADER ### -->
        
      <h4 class="bg-dark p-2">
        <i class="fas fa-file-alt"></i> 
        {{ trans('users.user') }} 
        <span class="badge badge-light float-right">{{ trans('application.lbl.code') }} {{ $user->id }}</span>
      </h4>
        
      <!-- ### INFORMAÇÕES GERAIS ### -->
      
      <table class="table table-bordered table-printable border-0 mb-2">
        <tbody>
          <tr>
            <td class="py-1 text-center align-middle font-weight-bold bg-gray w-50px">
              {{ $index++ }}
            </td>
            <td class="p-1 text-center text-uppercase">
              <strong><i>{{ trans('application.print.board.info') }}</i></strong>
            </td>
          </tr>
        </tbody>
      </table>
        
      <!-- ### QUADRO 1 ### -->
        
      <table class="table table-bordered table-printable border-0 mb-2">
        <tbody>
          <tr>
            <td class="py-1 text-center align-middle font-weight-bold bg-gray w-50px" rowspan="4">
              <i class="fas fa-info"></i>
            </td>
            <td colspan="2">
              <label class="mb-0 font-italic">{{ trans('users.lbl.name') }}:</label> {{ $user->name }}
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <label class="mb-0 font-italic">{{ trans('users.lbl.email') }}:</label> {{ $user->email }}
            </td>
          </tr>
          <tr>
            <td>
              <label class="mb-0 font-italic">{{ trans('users.lbl.roles') }}:</label> {{ $user->minRole()->name }}
            </td>
            <td>
              <label class="mb-0 font-italic">{{ trans('application.lbl.status') }}:</label> 
              <span class="{{ ($user->trashed()) ? (($user->throttle->suspended) ? 'text-warning' : 'text-danger') : 'text-success' }} text-uppercase mb-0">
                {{ 
                  ($user->trashed()) ? 
                    (($user->throttle->suspended) ? 
                      trans('users.lbl.suspended') : 
                      trans('application.lbl.inactive')) : 
                  trans('application.lbl.active') 
                }}
              </span>
            </td>
          </tr>

          <!-- BEGIN - Secretarias -->

          <tr>
            <td colspan="2">

              <label class="mb-0 font-italic">{{ trans('secretarias.secretaria(s)') }}:</label> 

              @if ($user->secretarias()->withTrashed()->exists())

                @define $secretarias = $user->secretarias()->withTrashed()->select('secretarias.id', 'secretarias.nome')->orderBy('nome', 'ASC')->get()

                <ul class="list-unstyled pl-3" style="list-style: circle;">

                  @foreach ($secretarias as $secretaria)
                
                    <li class="text-secondary">
                      {{
                        strtr($secretaria->nome, [
                          'Secretaria Municipal de ' => '', 
                          'Secretaria Municipal dos ' => ''
                          ]
                        )
                      }}
                    </li>

                  @endforeach

                </ul>

              @else

                {{ trans('application.msg.warn.no-records-found') }}

              @endif

            </td>
          </tr>

          <!-- END - Secretarias -->

        </tbody>
      </table>
        
      <!-- ### ATIVIDADES ### -->
      
      <table class="table table-bordered table-printable border-0 mb-2">
        <tbody>
          <tr>
            <td class="py-1 text-center align-middle font-weight-bold bg-gray w-50px">
              {{ $index++ }}
            </td>
            <td class="p-1 text-center text-uppercase">
              <strong><i>{{ trans('application.print.board.last-activity') }}</i></strong>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- ### QUADRO 2 ### -->
        
      <table class="table table-bordered table-printable border-0 mb-2">
        <tbody>
          <tr>
            <td class="py-1 text-center align-middle font-weight-bold bg-gray w-50px" rowspan="6">
              <i class="fas fa-info"></i>
            </td>
            <td>
              <label class="mb-0 font-italic">{{ trans('users.lbl.last-access') }}:</label>
              @if(strtotime($user->throttle->last_access_at) > 0)
                        
                {{ FormatterHelper::dateTimeToPtBR($user->throttle->last_access_at) }}

              @else

                {{ trans('users.msg.no-access') }}

              @endif
            </td>
            <td>
              <label class="mb-0 font-italic">{{ trans('users.ask.default-password-has-been-changed') }}</label>
              @if($user->throttle->is_default_password)

                {{ trans('application.lbl.no') }}

              @else

                {{ trans('application.lbl.yes') }}

              @endif
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <label class="mb-0 font-italic">{{ trans('application.lbl.created-at') }}:</label> 
              {{ FormatterHelper::dateTimeToPtBR($user->created_at) }}
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <label class="mb-0 font-italic">{{ trans('application.lbl.updated-at') }}:</label> 
              @if(strtotime($user->updated_at) > 0)
                {{ FormatterHelper::dateTimeToPtBR($user->updated_at) }}
              @endif
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <label class="mb-0 font-italic">{{ trans('application.lbl.deleted-at') }}:</label> 
              @if($user->deleted_at && !$user->throttle->suspended)

                {{ FormatterHelper::dateTimeToPtBR($user->deleted_at) }}

              @else

                 00/00/0000 00:00:00

              @endif
            </td>
          </tr>
          <tr>
            <td>
              <label class="mb-0 font-italic">{{ trans('users.lbl.suspended-at') }}:</label> 
              @if($user->deleted_at && $user->throttle->suspended)

                {{ FormatterHelper::dateTimeToPtBR($user->deleted_at) }}

              @else

                00/00/0000 00:00:00

              @endif
            </td>
            <td>
              <label class="mb-0 font-italic">{{ trans('users.lbl.suspended') }}:</label> 
              @define $minutes = 0

              @if ($user->throttle->suspended)

                @define $time    = strtotime($user->throttle->last_attempt_at . User::SUSPENSION_TIME) - strtotime('now')

                @define $minutes = round(((($time % 604800) % 86400) % 3600) / 60)

              @endif

              @if ($minutes > 0)

                {{ trans('users.msg.suspended', ['minutes' => $minutes]) }}

              @else

                @if ($user->throttle->suspended)

                  {{ trans('users.msg.suspension-time-ended') }}

                @else

                  {{ trans('users.msg.not-suspended') }}

                @endif

              @endif
            </td>
          </tr>
          <tr>
            <td>
              <label class="mb-0 font-italic">{{ trans('users.lbl.last-attempt') }}:</label> 
              @if(strtotime($user->throttle->last_attempt_at) > 0)
                        
                {{ FormatterHelper::dateTimeToPtBR($user->throttle->last_attempt_at) }}

              @else

                {{ trans('users.msg.no-last-attempt') }}

              @endif
            </td>
            <td>
              <label class="mb-0 font-italic">{{ trans('users.lbl.attempts') }}:</label> 
              {{ trans('users.msg.attempts', ['attempts' => $user->throttle->attempts]) }}
            </td>
          </tr>
        </tbody>
      </table>
        
    </div>

  </div>

@endif