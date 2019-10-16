@define $count = $model->count();

@define $perSlide = 4;

@define $slides = ceil($count / $perSlide);

@define $partition = 0;

@if ($count > 0)

  <div id="{{ $carousel_id }}" class="carousel slide carousel--multi-item" data-ride="carousel">

    <div class="carousel-inner px-4">

      @for ($i = 0; $i < $slides; $i++)

        <div class="carousel-item {{ ($i  === 0) ? 'active' : null }}">

          <!-- Row -->
          <div class="row">

            @for ($j = $partition; $j < ($perSlide * ($i + 1)); $j++)

              @if (isset($model[$j]))

                <!-- Col -->
                <div class="col-12 col-sm-6 col-md-3 col-lg-3">

                  <!-- Description Block -->
                  @include('dashboard/parts/_description-block', [
                    'class'            => ($j < (($perSlide * ($i + 1)) - 1)) ? 'border-right' : '', 
                    'total'            => $model[$j]->total, 
                    'total_sum'        => array_sum(array_column($model->toArray(), 'total')), 
                    'description_text' => $model[$j]->{$description_text}
                  ])
                  <!-- /Description Block -->

                </div>
                <!-- /Col -->

              @endif

            @endfor
          
            @define $partition = $perSlide * ($i + 1)

          </div>
          <!-- /Row -->

        </div>

      @endfor

    </div>

    <a class="carousel-control-prev bg-secondary w-auto border border-dark" href="#{{ $carousel_id }}" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">{{ trans('pagination.previous') }}</span>
    </a>
    <a class="carousel-control-next bg-secondary w-auto border border-dark" href="#{{ $carousel_id }}" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">{{ trans('pagination.next') }}</span>
    </a>

  </div>
  
@else

  <div class="p-3 text-center">
    {{ trans('application.msg.warn.no-records-found') }}
  </div>

@endif