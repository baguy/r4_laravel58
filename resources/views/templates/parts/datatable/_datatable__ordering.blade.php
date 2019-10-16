<th 
  class="order-by {{ isset($classes) ? $classes : '' }}" 
  data-sort="{{ $sort }}" 
  data-order="{{ isset($order) ? $order : 'ASC' }}" 
  data-sortable="true">

  {{ $label }} <i class="fas {{ isset($icon) ? $icon : 'fa-sort text-muted' }}"></i>

  @if (isset($group))

  	@include('templates/parts/datatable/_datatable__grouping', array('group' => $group))

  @endif

</th>