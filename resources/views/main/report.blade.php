@extends('templates.report')

@section('MAIN')

@if ($itens->count())

  @define $C_group = Input::get('C_group')

  <table class="table-report">

    <thead>

      <tr>

        @if (!$C_group)
          <th>{{ trans('itens.lbl.descricao') }}</th>
          <th>{{ trans('itens.lbl.especificacao') }}</th>
        @endif

        @if (!$C_group || $C_group === 'tipos')
          <th>{{ trans('itens.lbl.tipo') }}</th>
        @endif

        @if (!$C_group || $C_group === 'categorias')
          <th>{{ trans('itens.lbl.categoria') }}</th>
        @endif

        @if (!$C_group || $C_group === 'subcategorias')
          <th>{{ trans('itens.lbl.subcategoria') }}</th>
        @endif

        @if (!$C_group || $C_group === 'unidades')
          <th>{{ trans('itens.lbl.unidade') }}</th>
        @endif

        @if (!$C_group || $C_group === 'status')
          <th>{{ trans('application.lbl.status') }}</th>
        @endif

        @if (!$C_group)
          <th>{{ trans('application.lbl.created-at') }}</th>
          <th>{{ trans('application.lbl.updated-at') }}</th>
          <th>{{ trans('application.lbl.deleted-at') }}</th>
        @endif

        @if ($C_group)
          <th>
            {{ trans('application.lbl.total') }}
          </th>
        @endif

      </tr>

    </thead>

    <tbody>

      @foreach ($itens as $item)

      <tr>

        @if (!$C_group)
          <td>{{ $item->descricao }}</td>
          <td style="wrap-text: true">
            @define $preg_replace   = preg_replace('#<[^>]+>#', ' ', $item->especificacao)
            @define $str_replace    = str_replace('  ', '&nbsp;', $preg_replace)
            @define $especificacoes = explode('&nbsp;', $str_replace)

            @foreach ($especificacoes as $key => $especificacao)

              @if (!empty($especificacao))
                - {{ trim($especificacao) }} <br>
              @endif

            @endforeach
          </td>
        @endif

        @if (!$C_group || $C_group === 'tipos')
          <td>{{ $item->tipo }}</td>
        @endif

        @if (!$C_group || $C_group === 'categorias')
          <td>{{ $item->subcategoria->categoria->nome }}</td>
        @endif

        @if (!$C_group || $C_group === 'subcategorias')
          <td>{{ $item->subcategoria->nome }}</td>
        @endif

        @if (!$C_group || $C_group === 'unidades')
          <td>{{ $item->unidade->tipo }}</td>
        @endif

        @if (!$C_group || $C_group === 'status')
          <td>
            {{ ($item->trashed()) ? trans('application.lbl.inactive') : trans('application.lbl.active') }}
          </td>
        @endif

        @if (!$C_group)
          <td>{{ FormatterHelper::dateTimeToPtBR($item->created_at) }}</td>
          <td>
            @if(strtotime($item->updated_at) > 0)

              {{ FormatterHelper::dateTimeToPtBR($item->updated_at) }}

            @endif
          </td>
          <td>
            @if($item->deleted_at)

              {{ FormatterHelper::dateTimeToPtBR($item->deleted_at) }}

            @endif
          </td>
        @endif

        @if ($C_group)
          <td>
            {{ $item->total    ? $item->total    : null }}
            {{ $item->active   ? $item->active   : null }}
            {{ $item->inactive ? $item->inactive : null }}
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
