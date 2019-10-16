<a 
  href="?action=group_by" 
  class="text-secondary d-flex float-right mt-1 mr-2" 
  data-group="{{ $group }}" 
  data-groupable="true">
  <i 
    class="fas fa-object-group" 
    data-tooltip="tooltip" 
    data-placement="top" 
    data-original-title="{{ trans('application.btn.group') }}"
    data-replacement-title="{{ trans('application.btn.ungroup') }}"></i>
</a>