templates.application')

@section('PAGE_TITLE')
  {{ trans('users.page.title.edit') }}
@stop

@section('STYLES')



@stop

@section('MAIN')

  @include('users/_form')

@stop

@section('SCRIPTS')

  <!-- JQuery Email Auto Complete -->
  <script src="assets/plugins/email-autocomplete/jquery.email-autocomplete.min.js"></script>

  <!-- JQuery Validation -->
  <script src="assets/plugins/jquery-validation/jquery.validate.min.js"></script>

  <!-- JQuery Validation - Additional Methods -->
  <script src="assets/plugins/jquery-validation/additional-methods.min.js"></script>

  <!-- JQuery Validation - Localization pt_BR -->
  <script src="assets/plugins/jquery-validation/localization/messages_pt_BR.min.js"></script>

  <!-- JQuery Form Validator -->
  <script src="assets/js/jQuery.form.validator.js"></script>

  <!-- ()_Select2Builder -->
  <script src="assets/js/()_select2.builder.js"></script>

  <!-- $_Auth -->
  <script src="assets/js/$_auth.js"></script>

  <!-- $_Users -->
  <script src="assets/js/$_users.js"></script>

@stop
