@extends('templates.application')

@section('PAGE_TITLE')
  {{ trans('produtos.page.title.show') }}
@stop

@section('STYLES')

  <!-- &_Itens -->
  <link rel="stylesheet" href="{{ asset('assets/css/&_itens.css') }}">

@stop

@section('MAIN')

  @define $isAdmin   = Auth::user()->hasRole('ADMIN')

  @define $isTrashed = $produto->trashed()

  <div class="row">

    <div class="col-12">

      <!-- Nav Tabs Custom -->
      <div class="card">

        <div class="card-header p-2">

          <ul class="nav nav-pills" id="pills-tab" role="tablist">

            <li class="nav-produto mr-2">
              <a
                id="produto-tab"
                class="nav-link active"
                href="#produto-tabPanel"
                data-toggle="pill" role="tab" aria-controls="produto" aria-selected="true">
                {{ trans('produtos.produto') }}</a>
            </li>

            <!-- SHOW - Options - Buttons  -->
            @include('templates/parts/_show__options-buttons', [
              'has_min_permission' => Auth::user()->hasRole('USER'),
              'has_max_permission' => $isAdmin,
              'is_trashed'         => $isTrashed,
              'modal_id'           => $produto->id,
              'route_edit'         => route('produtos.edit', [ $produto->id ]),
              'is_printable'       => false,
              'route_print_one'    => route('produtos.print-one', [ $produto->id ])
            ])

          </ul>

        </div>

        <!-- Card Body -->
        <div class="card-body">

          <!-- Tab Content -->
          <div class="tab-content" id="pills-tabContent">

            <!-- Tab Pane -->
            <div class="tab-pane fade show active" id="produto-tabPanel" role="tabpanel" aria-labelledby="pills-produto-tab">

              <div class="row">

                <div class="col-6">

                  <blockquote class="blockquote d-block">
                    <p class="mb-0">
                      <i class="fas fa-font fa-fw mr-1"></i> {{ trans('produtos.lbl.nome') }}
                    </p>
                    <footer class="blockquote-footer">
                      {{ $produto->nome }}
                    </footer>
                  </blockquote>

                  <blockquote id="especificacoes" class="blockquote d-block">
                    <p class="mb-0">
                      <i class="fas fa-tag fa-fw mr-1"></i> {{ trans('produtos.lbl.lote') }}
                    </p>
                    <footer class="small text-secondary">
                      {{ $produto->lote }}
                    </footer>
                  </blockquote>

                  <blockquote class="blockquote d-block">
                    <p class="mb-0">
                      <i class="fas fa-calendar-times fa-fw mr-1"></i> {{ trans('produtos.lbl.validade') }}
                    </p>
                    <footer class="blockquote-footer">
                      {{ $produto->validade }}
                    </footer>
                  </blockquote>

                </div>

                <div class="col-6">

                  <blockquote class="blockquote d-block">
                    <p class="mb-0">
                      <i class="fas fa-toggle-on fa-fw mr-1"></i> {{ trans('application.lbl.status') }}
                    </p>
                    <footer class="blockquote-footer">
                      <span class="badge {{ ($isTrashed) ? 'badge-danger' : 'badge-success' }} badge-pill text-uppercase">
                        {{ ($isTrashed) ? trans('application.lbl.inactive') : trans('application.lbl.active') }}
                      </span>
                    </footer>
                  </blockquote>

                  <blockquote class="blockquote d-block">
                    <p class="mb-0">
                      <i class="fas fa-calendar-alt fa-fw mr-1"></i> {{ trans('application.lbl.created-at') }}
                    </p>
                    <footer class="blockquote-footer">
                      {{ FormatterHelper::dateTimeToPtBR($produto->created_at) }}
                    </footer>
                  </blockquote>

                  @if(strtotime($produto->updated_at) > 0)

                    <blockquote class="blockquote d-block">
                      <p class="mb-0">
                        <i class="fas fa-calendar-alt fa-fw mr-1"></i> {{ trans('application.lbl.updated-at') }}
                      </p>
                      <footer class="blockquote-footer">
                        {{ FormatterHelper::dateTimeToPtBR($produto->updated_at) }}
                      </footer>
                    </blockquote>

                  @endif

                  @if(strtotime($produto->deleted_at) > 0)

                    <blockquote class="blockquote d-block">
                      <p class="mb-0">
                        <i class="fas fa-calendar-alt fa-fw mr-1"></i> {{ trans('application.lbl.deleted-at') }}
                      </p>
                      <footer class="blockquote-footer">
                        {{ FormatterHelper::dateTimeToPtBR($produto->deleted_at) }}
                      </footer>
                    </blockquote>

                  @endif

                </div>

              </div>

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

    @include('produtos/_modal-delete')

  @endif

  @if($isTrashed)

    @include('produtos/_modal-restore')

  @endif

@stop
