var AdminTR = AdminTR || {};

AdminTR.FilterForm = (function() {
    
  function FilterForm(resource, $_container, $_form, $_submit, $_clean) {

    this.resource      = resource;
    this.container     = $_container;

    this.form          = $_form;
    this.submit        = $_submit
    this.clean         = $_clean;

    this.fields        = this.form.find(':input');

    this.C_sort        = $('input[name="C_sort"]');
    this.C_order       = $('input[name="C_order"]');
    this.C_per_page    = $('input[name="C_per_page"]');
    this.C_group       = $('input[name="C_group"]');

    this.is_printable  = false;
    this.is_exportable = false;
  }
  
  FilterForm.prototype.initialize = function() {
    
    this.form.on('change keyup', disableButtons.bind(this));

    this.form.on('submit', filterDataTable.bind(this));

    this.clean.on('click', resetDataTable.bind(this));

    if (AdminTR.DataPrint)
      this.is_printable  = true;

    if (AdminTR.DataExport)
      this.is_exportable = true;
  }

  function disableButtons() {

    this.fields.each(action.bind(this));
  }

  function action(i, field) { // Each field

    if (field.type !== 'hidden' && field.type !== 'submit') { // Verify if it is hidden or subimt

      if (field.type === 'checkbox' || field.type === 'radio') { // Verify if it is checkbox or radio

        if ($(field).is(':not(:checked)')) { // Verify if it is not checked
          
          this.submit.attr('disabled', true);

          this.clean.addClass('disabled');
        }

        if ($(field).is(':checked')) { // Verify if it is checked

          this.submit.attr('disabled', false);

          this.clean.removeClass('disabled');

          return false;
        }

      } else if (field.type === 'select-multiple') { // Verify if it is select-multiple, ignoring select-one

        if($(field).is('[class*="select2"]')) { // Verify if it has select2 class variation

          if ($(field).find(':selected').length === 0) { // Verify if it is not selected

            this.submit.attr('disabled', true);

            this.clean.addClass('disabled');

          } else { // Verify if it is selected

            this.submit.attr('disabled', false);

            this.clean.removeClass('disabled');

            return false;
          }
        }

      } else { // If it is not hidden or subimt
    
        if ($(field).val().length === 0) { // Verify if it value is empty

          this.submit.attr('disabled', true);

          this.clean.addClass('disabled');
        }

        if ($(field).val()) { // Verify if it value is not empty
          
          this.submit.attr('disabled', false);

          this.clean.removeClass('disabled');

          return false;
        }
      }
    }
  }

  function filterDataTable(e) {

    e.preventDefault();
    
    new AdminTR.DataTable(this.resource, this.container, this.is_printable, this.is_exportable, this.form).initialize();
  }

  function resetDataTable(e) {

    e.preventDefault();
    
    resetFormElements.call(this);
    
    new AdminTR.DataTable(this.resource, this.container, this.is_printable, this.is_exportable).initialize();
  }

  function resetFormElements() {

    this.C_sort.val('');
    this.C_order.val('');
    this.C_per_page.val('');
    this.C_group.val('');

    this.form.trigger('reset');

    this.submit.attr('disabled', true);
    
    this.clean.addClass('disabled');
  }
  
  return FilterForm;
    
}());