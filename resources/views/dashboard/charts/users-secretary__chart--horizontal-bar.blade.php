<div class="chart">
  <canvas 
    id="Users_secretary__Chart--horizontalBar" 
    aria-label="Gráficos Acessíveis - Usuários por Secretaria" 
    role="img" 
    data-url="{{ route('dashboard.charts', ['resource' => 'users']) }}" 
    data-chart-title="{{ trans('dashboard.chart.users-by-secretary.title') }}" 
    style="height: 650px; min-width: 100%; max-width: 100%;">
  </canvas>

  <progress id="Users_secretary__Animation--progress" class="w-100" max="1" value="0"></progress>
</div>