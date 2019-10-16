<div class="chart">
  <canvas 
    id="Users_roles__Chart--doughnut" 
    aria-label="Gráficos Acessíveis - Usuários por Níveis" 
    role="img" 
    data-url="{{ route('dashboard.charts', ['resource' => 'users']) }}" 
    data-chart-title="{{ trans('dashboard.chart.users-by-roles.title') }}" 
    style="height: 250px; min-width: 100%; max-width: 100%;">
  </canvas>

  <progress id="Users_roles__Animation--progress" class="w-100" max="1" value="0"></progress>
</div>