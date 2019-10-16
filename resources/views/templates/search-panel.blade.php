<div id="searchPanel" class="search-panel d-print-none">

	<h3 id="searchHeader" class="mb-3">

    <i class="fas fa-search"></i> {{ trans('application.btn.search') }} 

    <span 
      id="searchChevronDown" 
      class="badge badge-secondary float-right" 
      data-tooltip="tooltip" 
      data-placement="left" 
      title="{{ trans('application.lbl.show') }}">
      <i class="fas fa-chevron-down"></i>
    </span>

    <span 
      id="searchChevronUp" 
      class="badge badge-secondary float-right d-none" 
      data-tooltip="tooltip" 
      data-placement="left" 
      title="{{ trans('application.lbl.hide') }}">
      <i class="fas fa-chevron-up"></i>
    </span>
  </h3>

  <div id="searchBox">

    @yield('FORM')
		
	</div>
	
</div>