<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ trans('application.config.name') }} @yield('PAGE_TITLE')</title>

    <!-- Font Awesome 5 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">

    <!-- iCheck 1.0.1 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/iCheck/square/blue.css') }}">

    <!-- Bootstrap Toggle 2.2.0 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-toggle/css/bootstrap-toggle.min.css') }}">

    <!-- AdminLTE 3.0.0 Alpha -->
    <link rel="stylesheet" href="{{ asset('assets/_dist/css/adminlte.min.css') }}">

    <!-- Select 2 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">

    <!-- Select 2 - Bootstrap 4 Theme -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2-bootstrap4.min.css') }}">

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <!-- Style: Folha de estilo personalizada -->
    <link rel="stylesheet" href="{{ asset('assets/css/_styles.css') }}">

    @yield('STYLES')

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}"/>
  </head>

  <body id="body" class="hold-transition" data-url="{{ url('/') }}">

    <!-- Spinner Loading -->
    @include('templates/parts/_spinner-loading')


        @yield('MAIN')


      <!-- Footer -->
      @include('templates/parts/_footer')


    <!-- ### BASIC SCRIPTS ### -->
    <script type="text/javascript">const main_url = '{{url('/')}}/';</script>

    <!-- JQuery 3.3.1 -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>

    <!-- Bootstrap 4.1.3 -->
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- SlimScroll 1.3.3 -->
    <script src="{{ asset('assets/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>

    <!-- iCheck 1.0.1 -->
    <script src="{{ asset('assets/plugins/iCheck/icheck.min.js') }}"></script>

    <!-- Bootstrap Toggle 2.2.0 -->
    <script src="{{ asset('assets/plugins/bootstrap-toggle/js/bootstrap-toggle.min.js') }}"></script>

    <!-- AdminLTE 3.0.0 Alpha -->
    <script src="{{ asset('assets/_dist/js/adminlte.min.js') }}"></script>

    <!-- Select 2 -->
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>

    <!-- Select 2 - Translation -->
    <script src="{{ asset('assets/plugins/select2/js/i18n/pt-BR.js') }}"></script>

    <!-- ()_Commons -->
    <script src="{{ asset('assets/js/()_commons.js') }}"></script>

    <!-- _Scripts -->
    <script src="{{ asset('assets/js/_scripts.js') }}"></script>

    @yield('SCRIPTS')

  </body>

</html>
