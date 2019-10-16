<div class="chart">
  <canvas 
    id="Subcategories_category__Chart--horizontalBar" 
    aria-label="Gráficos Acessíveis - Subcategorias por Categoria" 
    role="img" 
    data-url="{{ route('dashboard.charts', ['resource' => 'subcategorias']) }}" 
    data-chart-title="{{ trans('dashboard.chart.subcategories-by-category.title') }}" 
    style="height: 650px; min-width: 100%; max-width: 100%;">
  </canvas>

  <progress id="Subcategories_category__Animation--progress" class="w-100" max="1" value="0"></progress>
</div>