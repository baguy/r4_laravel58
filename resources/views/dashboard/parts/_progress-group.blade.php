<div class="progress-group mb-3">
  <span class="progress-text">{{ $progress_lbl }}</span>
  <span class="float-right"><b>{{ $progress_partial }}</b>/{{ $progress_total }}</span>
  <div class="progress progress-sm">
    <div class="progress-bar {{ $progress_color }}" style="width: {{ $progress_avg }}"></div>
  </div>
</div>