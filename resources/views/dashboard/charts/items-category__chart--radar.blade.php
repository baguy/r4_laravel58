<div class="chart">
  <canvas 
    id="Items_category__Chart--radar" 
    aria-label="Gráficos Acessíveis - Itens por Categoria" 
    role="img" 
    data-url="{{ route('dashboard.charts', ['resource' => 'itens']) }}" 
    data-chart-title="{{ trans('dashboard.chart.items-by-category.title') }}" 
    style="height: 650px; min-width: 100%; max-width: 100%;">
  </canvas>

  <progress id="Items_category__Animation--progress" class="w-100" max="1" value="0"></progress>
</div>