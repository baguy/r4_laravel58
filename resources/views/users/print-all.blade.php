@extends('templates.print')

@section('PAGE_TITLE')
  {{ trans('users.user(s)') }}
@stop

@section('MAIN')

  @define $C_group = Input::get('C_group')

	@foreach ($users as $key => $user)

		@include('users/_print')

	@endforeach

	<div class="text-center text-secondary pt-2 pb-3 d-print-none">
	  {{ 
	    trans('pagination.table.caption', [
	      'total' => $users->getTotal(), 
	      'currentPage' => $users->getCurrentPage(), 
	      'lastPage' => $users->getLastPage(), 
	      'perPage' => $users->getPerPage()
	    ]) 
	  }}
	</div>

	{{ $users->appends(Input::get())->links() }}

@stop

@section('SCRIPTS')

	<!-- ()_PageBreaker -->
  <script src="{{ asset('assets/js/()_page.breaker.js') }}"></script>

	<script type="text/javascript">

		$(function() {

      // Verify if elements are not crossing the edge of printing page
      var pageBreaker = new AdminTR.PageBreaker(1360);
      
      pageBreaker.initialize();
    });

	</script>
  
@stop