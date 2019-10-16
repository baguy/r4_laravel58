<div class="description-block {{ $class }}">
  <span class="description-percentage {{ ($total > 0) ? 'text-success' : 'text-warning' }}">
    <i class="fa {{ ($total > 0) ? 'fa-caret-up' : 'fa-caret-left' }}"></i> {{ number_format( ( $total / $total_sum ) * 100, 2) . '%' }}
  </span>
  <h5 class="description-header">{{ $total }}</h5>
  <span class="description-text d-block px-2 ellipsis">{{ $description_text }}</span>
</div>