<td class="align-middle px-2 text-uppercase col-status {{ !$is_grouped ? 'd-none d-sm-table-cell' : '' }}">
  <span class="badge {{ ($is_trashed) ? 'badge-danger' : 'badge-success' }} badge-pill d-block">
    {{ ($is_trashed) ? trans('application.lbl.inactive') : trans('application.lbl.active') }}
  </span>
</td>