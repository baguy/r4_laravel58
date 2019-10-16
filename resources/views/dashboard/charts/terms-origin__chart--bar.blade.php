<div class="chart">
  <canvas 
    id="Terms_origin__Chart--bar" 
    aria-label="Gráficos Acessíveis - Termos por Origem" 
    role="img" 
    data-url="{{ route('dashboard.charts', ['resource' => 'termos']) }}" 
    data-chart-title="{{ trans('dashboard.chart.terms-by-origin.title') }}" 
    style="height: 650px; min-width: 100%; max-width: 100%;">
  </canvas>

  <progress id="Terms_origin__Animation--progress" class="w-100" max="1" value="0"></progress>
</div>