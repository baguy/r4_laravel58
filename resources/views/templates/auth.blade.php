<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ trans('application.config.name') }}{{ trans('application.config.nickname') }} - @yield('PAGE_TITLE')</title>

    <!-- Font Awesome 5 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">

    <!-- iCheck 1.0.1 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/iCheck/square/blue.css') }}">

    <!-- AdminLTE 3.0.0 Alpha -->
    <link rel="stylesheet" href="{{ asset('assets/_dist/css/adminlte.min.css') }}">

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <!-- Style: Folha de estilo personalizada -->
    <link rel="stylesheet" href="{{ asset('assets/css/_styles.css') }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}"/>

    @if(!Request::is('errors/js'))
    <noscript><meta http-equiv="Refresh" content="1; url={{ url('/errors/js') }}"></noscript>
    @endif

    <style type="text/css">
      .login-card-body > section.px-2 {
        padding: 0!important;
      }

      .login-card-body > section.px-2 > .container-fluid {
        padding: 0!important;
      }
    </style>
  </head>

  <body id="body" class="hold-transition login-page" data-url="{{ url('/') }}">

    @yield('MAIN')

    <!-- ### BASIC SCRIPTS ### -->
    
    <!-- JQuery 3.3.1 -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>

    <!-- Bootstrap 4.1.3 -->
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- iCheck 1.0.1 -->
    <script src="{{ asset('assets/plugins/iCheck/icheck.min.js') }}"></script>

    <!-- AdminLTE 3.0.0 Alpha -->
    <script src="{{ asset('assets/_dist/js/adminlte.min.js') }}"></script>

    <!-- JQuery Email Auto Complete -->
    <script src="{{ asset('assets/plugins/email-autocomplete/jquery.email-autocomplete.min.js') }}"></script>

    <!-- $_Auth -->
    <script src="{{ asset('assets/js/$_auth.js') }}"></script>

    <script>
      $(function () {

        $('[data-tooltip="tooltip"]').tooltip();

        $('.icheck').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass   : 'iradio_square-blue',
          increaseArea : '20%' // optional
        });

      })
    </script>

  </body>

</html>