@extends('templates.print')

@section('PAGE_TITLE')
  {{ trans('users.user(s)') }}
@stop

@section('MAIN')

@if ($user)

  @define $key = 0

  @define $C_group = Input::get('C_group')

  @include('users/_print')

@else

  <div class="alert alert-warning session-flash my-5">
    {{ trans('application.msg.warn.no-records-found') }}
  </div>

@endif

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