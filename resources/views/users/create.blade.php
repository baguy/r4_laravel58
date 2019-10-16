@extends('templates.application')

@section('PAGE_TITLE')
  {{ trans('users.page.title.create') }}
@stop

@section('STYLES')

  

@stop

@section('MAIN')

	@include('users/_form')

@stop

@section('SCRIPTS')

	<!-- JQuery Email Auto Complete -->
  <script src="{{ asset('assets/plugins/email-autocomplete/jquery.email-autocomplete.min.js') }}"></script>

  <!-- JQuery Validation -->
  <script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>

  <!-- JQuery Validation - Additional Methods -->
  <script src="{{ asset('assets/plugins/jquery-validation/additional-methods.min.js') }}"></script>

  <!-- JQuery Validation - Localization pt_BR -->
  <script src="{{ asset('assets/plugins/jquery-validation/localization/messages_pt_BR.min.js') }}"></script>

  <!-- JQuery Form Validator -->
  <script src="{{ asset('assets/js/jQuery.form.validator.js') }}"></script>

  <!-- ()_Select2Builder -->
  <script src="{{ asset('assets/js/()_select2.builder.js') }}"></script>

  <!-- $_Auth -->
  <script src="{{ asset('assets/js/$_auth.js') }}"></script>

  <!-- $_Users -->
  <script src="{{ asset('assets/js/$_users.js') }}"></script>
  
@stop