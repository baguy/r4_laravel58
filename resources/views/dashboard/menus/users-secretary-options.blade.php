@include('dashboard/parts/_menu-chart-options', [
  'show_download' => true, 
  'images' => [
    [
      'download_id'    => 'Users_secretary__PNG--download', 
      'download_name'  => 'usuarios-por-secretaria', 
      'download_label' => trans('dashboard.chart.users-by-secretary.title')
    ], 
    [
      'download_id'    => 'Users_roles__PNG--download', 
      'download_name'  => 'usuarios-por-niveis', 
      'download_label' => trans('dashboard.chart.users-by-roles.title')
    ]
  ], 
  'show_export' => true, 
  'files' => [
    [
      'export_route' => route('users.export', ['type' => 'xls']), 
      'export_id'    => 'Users_secretary__XLS--export', 
      'export_label' => trans('dashboard.chart.users-by-secretary.title')
    ], 
    [
      'export_route' => route('users.export', ['type' => 'xls']), 
      'export_id'    => 'Users_roles__XLS--export', 
      'export_label' => trans('dashboard.chart.users-by-roles.title')
    ]
  ], 
  'index_route' => route('users.index'), 
  'index_label' => trans('users.page.title.index')
])