@extends('templates.auth')

@section('PAGE_TITLE')
  {{ trans('application.error.js.title') }}
@stop

@section('MAIN')


<div class="container" style="margin: 11% auto;">
      
  <div class="error-page">
    
    <h2 class="headline text-warning">JS</h2>

    <div class="error-content">

      <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! {{ trans('application.error.js.msg') }}.</h3>

      <p>{{ trans('application.error.js.msg.advice') }}.</p>
      <p>
        <a href="{{ url('/') }}"><i class="fas fa-arrow-left"></i> {{ trans('application.lbl.home-page') }}</a>
      </p>
      <p>
        <a href="{{ URL::previous() }}">
          <i class="fas fa-arrow-left"></i> {{ trans('application.lbl.page') }} {{ trans('pagination.previous') }}
        </a>
      </p>
      <p class="text-secondary">{{ trans('application.error.js.msg.tip') }}:</p>
      <ul class="list-unstyled">
        <li>
          <a target="_blank" href="https://www.google.com/search?q=google+chrome">
            <i class="fab fa-chrome fa-fw"></i> Chrome
          </a>
        </li>
        <li>
          <a target="_blank" href="https://www.google.com/search?q=microsoft+edge">
            <i class="fab fa-edge fa-fw"></i> Edge
          </a>
        </li>
        <li>
          <a target="_blank" href="https://www.google.com/search?q=mozilla+firefox">
            <i class="fab fa-firefox fa-fw"></i> Firefox
          </a>
        </li>
        <li>
          <a target="_blank" href="https://www.google.com/search?q=internet+explorer">
            <i class="fab fa-internet-explorer fa-fw"></i> Internet Explorer
          </a>
        </li>
        <li>
          <a target="_blank" href="https://www.google.com/search?q=opera+navegador">
            <i class="fab fa-opera fa-fw"></i> Opera
          </a>
        </li>
        <li>
          <a target="_blank" href="https://www.google.com/search?q=apple+safari">
            <i class="fab fa-safari fa-fw"></i> Safari
          </a>
        </li>
      </ul>
    </div>

  </div>

</div>

@stop