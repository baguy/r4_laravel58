@include('dashboard/parts/_menu-chart-options', [
  'show_download' => true, 
  'images' => [
    [
      'download_id'    => 'Items_category__PNG--download', 
      'download_name'  => 'itens-por-categoria', 
      'download_label' => trans('dashboard.chart.items-by-category.title')
    ]
  ], 
  'show_export' => true, 
  'files' => [
    [
      'export_route' => route('itens.export', ['type' => 'xls']), 
      'export_id'    => 'Items_category__XLS--export', 
      'export_label' => trans('dashboard.chart.items-by-category.title')
    ]
  ], 
  'index_route' => route('itens.index'), 
  'index_label' => trans('itens.page.title.index')
])