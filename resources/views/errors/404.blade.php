@extends('templates.application')

@section('PAGE_TITLE')
  {{ trans('application.error.404.title') }}
@stop

@section('MAIN')

<div class="error-page">

  <h2 class="headline text-warning">404</h2>

  <div class="error-content">

    <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! {{ trans('application.error.404.msg') }}.</h3>

    <p>
      {{ trans('application.msg.warn.page-not-found') }}
    </p>
    <p>
      <a href="{{ url('/') }}"><i class="fas fa-arrow-left"></i> {{ trans('application.lbl.home-page') }}</a>
    </p>
    <p>
      <a href="{{ URL::previous() }}">
        <i class="fas fa-arrow-left"></i> {{ trans('application.lbl.page') }} {{ trans('pagination.previous') }}
      </a>
    </p>
  </div>

</div>

@stop