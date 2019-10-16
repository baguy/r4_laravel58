@if (
  Request::is($resource.'/*') && 
  !Request::is($resource.'/create') && 
  !Request::is($resource.'/*/edit') && 
  !Request::is($resource.'/*/change-password')
)
                  
  <span class="right right--resource-marker badge badge-dark py-2 mr-4">
    <i class="fas fa-folder-open fa-fw fa-lg d-block text-secondary"></i>
  </span>

@endif

@if (Request::is($resource))
  
  <span class="right right--resource-marker badge badge-dark py-2 mr-4">
    <i class="fas fa-list-ol fa-fw fa-lg d-block text-secondary"></i>
  </span>

@endif

@if (Request::is($resource.'/create'))
  
  <span class="right right--resource-marker badge badge-dark py-2 mr-4">
    <i class="fas fa-save fa-fw fa-lg d-block text-secondary"></i>
  </span>

@endif

@if (Request::is($resource.'/*/edit'))
  
  <span class="right right--resource-marker badge badge-dark py-2 mr-4">
    <i class="fas fa-pen fa-fw fa-lg d-block text-secondary"></i>
  </span>

@endif

@if (Request::is($resource.'/*/change-password'))
  
  <span class="right right--resource-marker badge badge-dark py-2 mr-4">
    <i class="fas fa-lock fa-fw fa-lg d-block text-secondary"></i>
  </span>

@endif