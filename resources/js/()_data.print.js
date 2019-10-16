var AdminTR = AdminTR || {};

AdminTR.DataPrint = (function() {
    
  function DataPrint($_element, $_form = null) {
    
    this.element = $_element;
    this.url     = this.element.attr('href');
    this.form    = ($_form.length > 0) ? jQuery.param($_form) : $_form;
  }
  
  DataPrint.prototype.initialize = function() {

    this.element.off();

    this.element.on('click', _print.bind(this));
  }

  function _print(e) {

    e.preventDefault();

    var action = this.url;

    if (this.form)

      action = `${this.url}?${this.form}`;

    window.open(action, '_blank');
  }
  
  return DataPrint;
    
}());