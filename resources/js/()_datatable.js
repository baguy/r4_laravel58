var AdminTR = AdminTR || {};

AdminTR.DataTable = (function() {

  function DataTable(resource, $_container, is_printable = true, is_exportable = true, $_form = []) {

    const ICON_TYPE    = 'fa-sync-alt';
    const ICON_SIZE    = 'fa-5x';
    const ICON_COLOR   = 'text-info';

    this.resource      = resource;
    this.container     = $_container;

    this.loading       = $('<div class="text-center">')
                              .append(
                                $(`<i class="fas ${ICON_TYPE} fa-spin ${ICON_SIZE} ${ICON_COLOR}">`)
                              );

    this.form          = ($_form.length > 0) ? $_form.serializeArray() : $_form;

    this.error         = this.container.data('datatable-error');
    this.pagelink      = null;
    this.appurl        = $('body').data('url');
    this.url           = `${this.appurl}/list/${this.resource}`;

    this.ordering      = null;
    this.perPage       = null;
    this.grouping      = null;

    this.is_printable  = is_printable;
    this.is_exportable = is_exportable;
  }

  DataTable.prototype.initialize = function() {

    getContent.call(this, this.url);
  }

  function getContent(url) {

    $.ajax({
      url: url,
      type: 'GET',
      data: (this.form.length > 0) ? jQuery.param(this.form) : this.form,
      beforeSend: loading.call(this),
      success: success.bind(this),
      error: error.bind(this),
      complete: complete.bind(this)
    });
  }

  function success(data) {

    this.container.html(data);

    this.pagelink = $('ul.pagination').children('li.page-item').children('a.page-link');

    this.pagelink.on('click', navigate.bind(this));

    // Tooltip Reinitialization
    $('[data-tooltip="tooltip"]').tooltip({ boundary: 'window' });

    // If exists in AdminTR namespace - Table Description Initialize
    if (AdminTR.TableDescription) {

      var tableDescription = new AdminTR.TableDescription();

      tableDescription.initialize();
    }
  }

  function error(jqXHR, exception) {

    this.container
              .html(`<div class="alert alert-danger">${this.error}</div>`);
  }

  function complete() {

    // Data Export

    if (this.is_exportable)

      new AdminTR.DataExport($('.js-export-xls'), this.form).initialize();

    // Data Print

    if (this.is_printable)

      new AdminTR.DataPrint($('.js-print-all'), this.form).initialize();

    // Per Page Element and Events

    this.perPage = $('select[name="DT_per_page"]');

    this.form.forEach(restorePerPageAttributes.bind(this));

    this.perPage.on('change', resetPagination.bind(this));

    // Find elements and Bind events on them

    this.ordering = this.container.find('.datatable').find('th[data-sortable="true"]');

    this.ordering.each(orderBy.bind(this));

    this.grouping = this.container.find('.datatable').find('a[data-groupable="true"]');

    this.grouping.each(groupBy.bind(this));

    // Update th sortable elements
    updateSortables.call(this);

    // Update groupable elements
    updateGroupables.call(this);
  }

  function navigate(e) {

    e.preventDefault();

    getContent.call(this, $(e.currentTarget).attr('href'));
  }

  function loading() {

    this.container.html(this.loading);
  }

  function updateFilterForm(field, index) {

    if (field.name === 'C_sort')

      $('input[name="C_sort"]').val(field.value);

    if (field.name === 'C_order')

      $('input[name="C_order"]').val(field.value);

    if (field.name === 'C_group')

      $('input[name="C_group"]').val(field.value);
  }

  // PER PAGE OPERATIONS

  function restorePerPageAttributes(field, index) {

    if (field.name === 'C_per_page') {

      this.perPage.find(`option[value="${field.value}"]`).prop('selected', 'selected');

      $('input[name="C_per_page"]').val(field.value);
    }
  }

  function resetPagination(e) {

    // Remove per page attributes from this.form array
    this.form = this.form.filter(function(obj) {

      return (obj.name !== 'C_per_page');
    });

    // Push per page attributes from this.form array
    this.form.push({name: 'C_per_page', value: $(e.target).val()});

    getContent.call(this, this.url);
  }

  // ORDER BY OPERATIONS

  function orderBy(index, element) {

    // Bind click event on sortable columns
    $(element).on('click', getOrder.bind(this));
  }

  function getOrder(e) {

    var $_currentTarget = $(e.currentTarget);

    // Set order by options in thi.form;
    setForm__order.call(this, $_currentTarget);

    // Get Content
    getContent.call(this, this.url);
  }

  function setForm__order($_currentTarget) {

    // Remove order attributes from this.form array
    this.form = this.form.filter(function(obj) {

      return (obj.name !== 'C_sort') && (obj.name !== 'C_order');
    });

    // Push order attributes from this.form array

    this.form.push({name: 'C_sort', value: $_currentTarget.data('sort')});

    this.form.push({name: 'C_order', value: $_currentTarget.data('order')});

    // Update filter form inputs C_sort, C_order

    this.form.forEach(updateFilterForm);
  }

  function updateSortables() {

    var C_sort_value  = null;

    var C_order_value = null;

    this.form.forEach(function(field, index) {

      // Get C_sort value
      if (field.name === 'C_sort')

        C_sort_value = field.value;

      // Get C_order value
      if (field.name === 'C_order')

        C_order_value = field.value;
    });

    var target = this.container
                            .find('.datatable')
                            .find(`th[data-sort="${ C_sort_value }"]`);

    // Reset current target data attributes
    resetCurrentTargetDataAttributes.call(this, C_order_value, target);

    // Set current target sort icon
    setCurrentOrderingIcon.call(this, target, C_order_value);

    // Reset current target siblings data-order attribute and sort icon
    resetSiblings.call(this, target);
  }

  function resetCurrentTargetDataAttributes(order, target) {

    if (order === 'ASC')

      target.attr('data-order', 'DESC');

    else if (order === 'DESC')

      target.attr('data-order', 'ASC');
  }

  function setCurrentOrderingIcon(target, order) {

    switch(order) {

      case 'ASC':

        $(target).find('i').first().attr({class : 'fas fa-sort-down'});

        break;

      case 'DESC':

        $(target).find('i').first().attr({class : 'fas fa-sort-up'});

        break;
    }
  }

  function resetSiblings(target) {

    $(target).siblings('[data-sortable]').each(function(index, element) {

      $(element).attr('data-order', function(k, v) {

        return 'ASC';
      });

      $(element).find('i').first().attr({class : 'fas fa-sort text-muted'});
    });
  }

  // GROUP BY OPERATIONS

  function groupBy(index, element) {

    // Bind click event on sortable columns
    $(element).on('click', getGroup.bind(this));
  }

  function getGroup(e) {

    $('[data-tooltip="tooltip"]').tooltip('hide');

    e.preventDefault();

    e.stopPropagation();

    var $_currentTarget = $(e.currentTarget);

    // Update icon color from options list
    $_currentTarget.closest('a').toggleClass('text-secondary text-primary');

    // Set order by options in thi.form;
    setForm__group.call(this, $_currentTarget);

    // Get Content
    getContent.call(this, this.url);
  }

  function setForm__group($_currentTarget) {

    // Verify if "C_group" exists in this.form array
    var is_grouped = this.form.filter(function(obj) {

      return (obj.name === 'C_group');
    });

    // Remove order attributes from this.form array
    this.form = this.form.filter(function(obj) {

      return (obj.name !== 'C_group');
    });

    // If is grouped and it's the same on the current target
    if (is_grouped.length > 0 && is_grouped[0].value === $_currentTarget.closest('a').data('group')) {

      $('input[name="C_group"]').val('');

      return false;
    }

    // Push order attributes from this.form array

    this.form.push({name: 'C_group', value: $_currentTarget.closest('a').data('group')});

    // Update filter form input C_group

    this.form.forEach(updateFilterForm);
  }

  function updateGroupables() {

    var C_group_value = null;

    this.form.forEach(function(field, index) {

      // Get C_group value
      if (field.name === 'C_group')

        C_group_value = field.value;
    });

    var target = this.container
                            .find('.datatable')
                            .find(`a[data-group="${ C_group_value }"]`);

    // Set current target text color
    setCurrentGroupingColor.call(this, target);
  }

  function setCurrentGroupingColor(target) {

    var replacementTitle = $(target).children('i').data('replacement-title');

    $(target).children('i').attr('data-original-title', replacementTitle);

    $(target).toggleClass('text-secondary text-primary');
  }

  return DataTable;

}());
