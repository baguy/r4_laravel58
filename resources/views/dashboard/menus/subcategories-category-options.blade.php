@include('dashboard/parts/_menu-chart-options', [
  'show_download' => true, 
  'images' => [
    [
      'download_id'    => 'Subcategories_category__PNG--download', 
      'download_name'  => 'subcategorias-por-categoria', 
      'download_label' => trans('dashboard.chart.subcategories-by-category.title')
    ]
  ], 
  'show_export' => false, 
  'index_route' => route('subcategorias.index'), 
  'index_label' => trans('subcategorias.page.title.index')
])