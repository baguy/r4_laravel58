@include('dashboard/parts/_menu-chart-options', [
  'show_download' => true, 
  'images' => [
    [
      'download_id'    => 'Terms_origin__PNG--download', 
      'download_name'  => 'termos-por-origem', 
      'download_label' => trans('dashboard.chart.terms-by-origin.title')
    ], 
    [
      'download_id'    => 'Terms_destiny__PNG--download', 
      'download_name'  => 'termos-por-destino', 
      'download_label' => trans('dashboard.chart.terms-by-destiny.title')
    ]
  ], 
  'show_export' => true, 
  'files' => [
    [
      'export_route' => route('termos.export', ['type' => 'xls']), 
      'export_id'    => 'Terms_origin__XLS--export', 
      'export_label' => trans('dashboard.chart.terms-by-origin.title')
    ], 
    [
      'export_route' => route('termos.export', ['type' => 'xls']), 
      'export_id'    => 'Terms_destiny__XLS--export', 
      'export_label' => trans('dashboard.chart.terms-by-destiny.title')
    ]
  ], 
  'index_route' => route('termos.index'), 
  'index_label' => trans('termos.page.title.index')
])