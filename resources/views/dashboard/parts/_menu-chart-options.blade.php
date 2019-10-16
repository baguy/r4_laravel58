@if ($show_download)

  <h6 class="dropdown-header text-uppercase text-left">
    {{ trans('application.btn.download', ['lbl' => 'Imagem']) }}
  </h6>

  @foreach ($images as $image)

    <a 
      href="?download" 
      id="{{ $image['download_id'] }}" 
      class="dropdown-item" 
      download="{{ $image['download_name'] }}_{{ date('dmYHis') }}.png">
      <i class="fas fa-download fa-fw"></i> {{ $image['download_label'] }}
    </a>

  @endforeach

  <div class="dropdown-divider"></div>

@endif

@if ($show_export)

  <h6 class="dropdown-header text-uppercase text-left">
    {{ trans('application.btn.export', ['lbl' => 'Excel']) }}
  </h6>

  @foreach ($files as $file)

    <a 
      href="{{ $file['export_route'] }}" 
      id="{{ $file['export_id'] }}" 
      class="dropdown-item">
      <i class="fas fa-table fa-fw"></i> {{ $file['export_label'] }}
    </a>

  @endforeach

  <div class="dropdown-divider"></div>

@endif

<a 
  href="{{ $index_route }}" 
  class="dropdown-item">
  <i class="fas fa-list-ol fa-fw"></i> {{ $index_label }}
</a>