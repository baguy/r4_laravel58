<div class="chart">
  <canvas 
    id="Terms_destiny__Chart--polarArea" 
    aria-label="Gráficos Acessíveis - Termos por Destino" 
    role="img" 
    data-url="{{ route('dashboard.charts', ['resource' => 'termos']) }}" 
    data-chart-title="{{ trans('dashboard.chart.terms-by-destiny.title') }}" 
    style="height: 650px; min-width: 100%; max-width: 100%;">
  </canvas>

  <progress id="Terms_destiny__Animation--progress" class="w-100" max="1" value="0"></progress>
</div>