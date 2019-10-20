var AdminTR = AdminTR || {};

AdminTR.DataExport = (function() {
    
  function DataExport($_element, $_form = null) {
    
    this.element = $_element;
    this.url     = this.element.attr('href');
    this.form    = ($_form.length > 0) ? jQuery.param($_form) : $_form;
  }
  
  DataExport.prototype.initialize = function() {

    this.element.off();

    this.element.on('click', _export.bind(this));
  }

  function _export(e) {

    e.preventDefault();

    var action = this.url;

    if (this.form)

      action = `${this.url}?${this.form}`;

    document.location = action;

    // fileDownload(action);

    /*
    $.ajax({
      url: this.url, 
      type: 'GET', 
      data: this.form, 
      success: onSuccess.bind(this),
      error: onError.bind(this),
    });
    */
  }

  function fileDownload(action) {
    
    // $.fileDownload(action);
  }
  
  return DataExport;
    
}());