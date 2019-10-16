@extends('templates.report')

@section('MAIN')

@if ($users->count())

  @define $C_group = Input::get('C_group')

  <table class="table-report">

    <thead>

      <tr>

        @if (!$C_group)
          <th>{{ trans('users.lbl.name') }}</th>
          <th>{{ trans('users.lbl.email') }}</th>
        @endif

        @if (!$C_group || $C_group === 'status')
          <th>{{ trans('application.lbl.status') }}</th>
        @endif

        @if (!$C_group || $C_group === 'roles')
          <th>{{ trans('users.lbl.roles') }}</th>
        @endif

        @if (!$C_group || $C_group === 'secretarias')
          <th>{{ trans('secretarias.secretaria(s)') }}</th>
        @endif

        @if ($C_group === 'attempts')
          <th>{{ trans('users.lbl.attempts') }}</th>
        @endif

        @if (!$C_group)
          <th>{{ trans('application.lbl.created-at') }}</th>
          <th>{{ trans('application.lbl.updated-at') }}</th>
          <th>{{ trans('application.lbl.deleted-at') }}</th>
          <th>{{ trans('users.lbl.suspended-at') }}</th>
          <th>{{ trans('users.lbl.suspended') }}</th>
          <th>{{ trans('users.ask.default-password-has-been-changed') }}</th>
          <th>{{ trans('users.lbl.last-access') }}</th>
          <th>{{ trans('users.lbl.attempts') }}</th>
          <th>{{ trans('users.lbl.last-attempt') }}</th>
        @endif

        @if ($C_group)
          <th>{{ trans('application.lbl.total') }}</th>
        @endif

      </tr>

    </thead>

    <tbody>

      @foreach ($users as $user)
      
      <tr>

        @if (!$C_group)
          <td>{{ $user->name }}</td>
          <td>{{ $user->email }}</td>
        @endif

        @if (!$C_group || $C_group === 'status')
          <td>
            {{ 
              ($user->trashed()) ? 
                (($user->throttle->suspended) ? 
                  trans('users.lbl.suspended') : 
                  trans('application.lbl.inactive')) : 
              trans('application.lbl.active') 
            }}
            </span>
          </td>
        @endif

        @if (!$C_group || $C_group === 'roles')
          <td>{{ $user->minRole()->name }}</td>
        @endif

        @if (!$C_group || $C_group === 'secretarias')

          @if (!$C_group)

            <td style="wrap-text: true">
              @if ($user->secretarias()->withTrashed()->exists())

                @foreach ($user->secretarias()->withTrashed()->orderBy('nome', 'ASC')->get() as $key => $secretaria)
                  
                  - {{ $secretaria->nome }}; <br>
                  
                @endforeach

              @endif
            </td>

          @else

            <td>{{ $user->secretaria }}</td>

          @endif

        @endif

        @if ($C_group === 'attempts')
          <td>{{ ($user->throttle->attempts > 0) ? trans('application.lbl.yes') : trans('application.lbl.no') }}</td>
        @endif

        @if (!$C_group)
          <td>{{ FormatterHelper::dateTimeToPtBR($user->created_at) }}</td>
          <td>
            @if(strtotime($user->updated_at) > 0)

              {{ FormatterHelper::dateTimeToPtBR($user->updated_at) }}

            @endif
          </td>
          <td>
            @if($user->deleted_at)

              {{ (!$user->throttle->suspended) ? FormatterHelper::dateTimeToPtBR($user->deleted_at) : null }}

            @endif
          </td>
          <td>
            @if($user->deleted_at)

              {{ ($user->throttle->suspended) ? FormatterHelper::dateTimeToPtBR($user->suspended_at) : null }}

            @endif
          </td>
          <td>
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
          <td>
            @if($user->throttle->is_default_password)

              {{ trans('application.lbl.no') }}

            @else

              {{ trans('application.lbl.yes') }}

            @endif
          </td>
          <td>
            @if(strtotime($user->throttle->last_access_at) > 0)
                      
              {{ FormatterHelper::dateTimeToPtBR($user->throttle->last_access_at) }}

            @else

              {{ trans('users.msg.no-access') }}

            @endif
          </td>
          <td>{{ trans('users.msg.attempts', ['attempts' => $user->throttle->attempts]) }}</td>
          <td>
            @if(strtotime($user->throttle->last_attempt_at) > 0)
                      
              {{ FormatterHelper::dateTimeToPtBR($user->throttle->last_attempt_at) }}

            @else

              {{ trans('users.msg.no-last-attempt') }}

            @endif
          </td>
        @endif

        @if ($C_group)
          <td>
            {{ $user->total       ? $user->total       : null }}

            {{ $user->active      ? $user->active      : null }}
            {{ $user->inactive    ? $user->inactive    : null }}

            {{ $user->suspended   ? $user->suspended   : null }}

            {{ $user->attempts    ? $user->attempts    : null }}
            {{ $user->no_attempts ? $user->no_attempts : null }}
          </td>
        @endif

      </tr>

      @endforeach

    </tbody>

  </table>

@else

  <table class="table-report">
    <tbody>
      <tr>
        <td>{{ trans('application.msg.warn.no-records-found') }}</td>
      </tr>
    </tbody>
  </table>

@endif

@stop