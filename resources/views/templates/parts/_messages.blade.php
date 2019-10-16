@if (Session::has('_error') || Session::has('_status') || Session::has('_info') || Session::has('_warn'))
	
	<section class="px-2">

    <div class="container-fluid">

			@if (Session::has('_error'))
			<div class="alert alert-danger session-flash" role="alert">
			  {{ Session::get('_error') }}
			</div>
			@endif

			@if (Session::has('_status'))
			<div class="alert alert-success session-flash" role="alert">
			  {{ Session::get('_status') }}
			</div>
			@endif

			@if (Session::has('_info'))
			<div class="alert alert-info session-flash" role="alert">
			  {{ Session::get('_info') }}
			</div>
			@endif

			@if (Session::has('_warn'))
			<div class="alert alert-warning session-flash" role="alert">
			  {{ Session::get('_warn') }}
			</div>
			@endif

		</div>

  </section>

@endif