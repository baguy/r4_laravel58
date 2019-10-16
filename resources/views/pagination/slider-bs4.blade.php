<?php

$presenter = new Illuminate\Pagination\BootstrapPresenter($paginator);

?>

<?php if ($paginator->getLastPage() > 1): ?>

<?php

  $link_limit = 8; // Maximum number of links (Just even numbers).

  $half_total_links = floor($link_limit / 2);

  $diff = $half_total_links + 1;

  $from = $paginator->getCurrentPage() - ($half_total_links + 1) + 1;
  $to = $paginator->getCurrentPage() + ($half_total_links + 1);

  if ($paginator->getCurrentPage() > $half_total_links) $to -= 1;

  if ($paginator->getCurrentPage() < $half_total_links) $to += $half_total_links - $paginator->getCurrentPage();

  if ($paginator->getLastPage() - $paginator->getCurrentPage() < $half_total_links) {

    $diff -= 1;
    
    $from -= $half_total_links - ($paginator->getCurrentPage() - $paginator->getCurrentPage()) - $diff;
  }

  if ($to > $paginator->getLastPage()) {

    $to = $paginator->getLastPage();

    $from = ($to - $link_limit);
  }

?>

  <nav aria-label="Page navigation" class="d-print-none">

    <ul class="pagination justify-content-center" data-last-page="{{ $paginator->getLastPage() }}">

      <li class="{{ ($paginator->getCurrentPage() === 1) ? 'page-item disabled' : 'page-item' }}">
        <a 
          href="{{ $paginator->getUrl(1) }}" 
          id="first" 
          class="page-link" 
          data-page="1" 
          data-tooltip="tooltip" data-placement="top" title="{{ trans('pagination.first') }}">
          <i class="fas fa-angle-double-left"></i>
        </a>
      </li>

      <li class="{{ ($paginator->getCurrentPage() === 1) ? 'page-item disabled' : 'page-item' }}">
        <a 
          href="{{ ($paginator->getCurrentPage() > 1) ? ($paginator->getUrl($paginator->getCurrentPage() - 1)) : '' }}" 
          id="previous" 
          class="page-link" 
          data-page="{{ $paginator->getCurrentPage() - 1 }}" 
          data-tooltip="tooltip" data-placement="top" title="{{ trans('pagination.previous') }}">
          <i class="fas fa-angle-left"></i>
        </a>
      </li>

      @if ($from > 1)
        <li class="page-item disabled"><a class="page-link" href="">...</a></li>
      @endif

      @for ($i = 1; $i <= $paginator->getLastPage(); $i++)

        @if ($from <= $i && $i <= $to)
          <li class="{{ ($paginator->getCurrentPage() === $i) ? ' page-item active' : 'page-item' }}">
            <a href="{{ $paginator->getUrl($i) }}" id="page[{{ $i }}]" class="page-link" data-page="{{ $i }}">
              {{ $i }} {{ ($paginator->getCurrentPage() === $i) ? '<span class="sr-only">(current)</span>' : '' }}
            </a>
          </li>
        @endif

      @endfor

      @if ($to < $paginator->getLastPage())
        <li class="page-item disabled"><a class="page-link" href="">...</a></li>
      @endif

      <li class="{{ ($paginator->getCurrentPage() === $paginator->getLastPage()) ? 'page-item disabled' : 'page-item' }}">
        <a 
          href="{{ $paginator->getUrl($paginator->getCurrentPage() + 1) }}" 
          id="next" 
          class="page-link" 
          data-page="{{ $paginator->getCurrentPage() + 1 }}" 
          data-tooltip="tooltip" data-placement="top" title="{{ trans('pagination.next') }}">
          <i class="fas fa-angle-right"></i>
        </a>
      </li>

      <li class="{{ ($paginator->getCurrentPage() === $paginator->getLastPage()) ? 'page-item disabled' : 'page-item' }}">
        <a 
          href="{{ $paginator->getUrl($paginator->getLastPage()) }}" 
          id="last" 
          class="page-link" 
          data-page="{{ $paginator->getLastPage() }}" 
          data-tooltip="tooltip" data-placement="top" title="{{ trans('pagination.last') }}">
          <i class="fas fa-angle-double-right"></i>
        </a>
      </li>

    </ul>

  </nav>

<?php endif; ?>