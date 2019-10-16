@extends('templates.application')

@section('PAGE_TITLE')
  {{ trans('logger.page.title.index') }}
@stop

@section('MAIN')

<div class="card">
  <div class="card-header">
    <h3 class="card-title">

      @include('logger/_search')

    </h3>
  </div>
  <div class="card-body">

    @if (count($logs) > 0)

    <div class="table-responsive">

      <table class="table table-hover table-sm table-collapse mb-0">

        <thead>
          <tr>
            <th class="text-center text-primary th-collapse-all">
              <i 
                class="fas fa-expand fa-fw" 
                data-tooltip="tooltip" 
                data-placement="top" 
                data-original-title="{{ trans('application.btn.expand') }}"></i>
              <i 
                class="fas fa-compress fa-fw d-none" 
                data-tooltip="tooltip" 
                data-placement="top" 
                data-original-title="{{ trans('application.btn.compress') }}"></i>
            </th>
            <th>{{ trans('logger.lbl.action') }}</th>
            <th class="d-none d-md-table-cell">{{ trans('logger.lbl.user') }}</th>
            <th class="d-none d-md-table-cell col-roles">{{ trans('users.lbl.roles') }}</th>
            <th class="d-none d-sm-table-cell col-created-at">{{ trans('application.lbl.created-at') }}</th>
          </tr>
        </thead>

        <tbody>

          @foreach($logs as $messages)
            
            @foreach($messages as $key => $message)
            
              @define $parts      = explode(' | ', $message)

              @define $action     = trim($parts[2])
              
              @define $created_at = $parts[0]

              @define $message    = $parts[3]

              @define $user       = explode(':', str_replace('[', '', str_replace(']', '', $parts[1])))
          
              <tr>
                <td class="text-center align-middle">
                  <button 
                    class="btn btn-primary btn-toggle" 
                    type="button" 
                    data-toggle="collapse" 
                    data-target="#collapseLog_{{ $key }}" 
                    aria-expanded="false" 
                    aria-controls="collapseLog_{{ $key }}">
                    <i class="fas fa-plus fa-fw"></i>
                  </button>
                </td>
                <td class="align-middle text-{{ $colors[$action] }}">
                  {{ $action }}
                </td>
                <td class="d-none d-md-table-cell align-middle">
                  {{ $user[0] }}
                </td>
                <td class="d-none d-md-table-cell align-middle col-roles">
                  <span class="badge badge-secondary d-block">{{ $user[1] }}</span>
                </td>
                <td class="d-none d-sm-table-cell align-middle col-created-at">
                  <span class="badge badge-info d-block">
                    {{ FormatterHelper::dateTimeToPtBR($created_at) }}
                  </span>
                </td>
              </tr>
              <tr>
                <td class="description">
                  <div class="collapse" id="collapseLog_{{ $key }}">
                    <div class="p-3">

                      <blockquote class="blockquote d-block">
                        <p class="mb-0">{{ trans('logger.lbl.message') }}</p>
                        <footer class="blockquote-footer">{{ htmlspecialchars($message) }}</footer>
                      </blockquote>

                    </div>
                  </div>
                </td>
              </tr>

            @endforeach

          @endforeach

        </tbody>

      </table>

    </div>

    @else

    <div class="alert alert-warning mb-0">{{ trans('application.msg.warn.no-records-found') }}</div>

    @endif

  </div>

  <div class="card-footer">
    @include('logger/_search')
  </div>

</div>

@stop

@section('SCRIPTS')
  
  <!-- Table Description -->
  <script src="{{ asset('assets/js/()_table.description.js') }}"></script>

  <script type="text/javascript">
    
    // Table Description Initialize
    var tableDescription = new AdminTR.TableDescription();
  
    tableDescription.initialize();

  </script>

@stop