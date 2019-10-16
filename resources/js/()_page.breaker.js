var AdminTR = AdminTR || {};

AdminTR.PageBreaker = (function() {
    
  function PageBreaker(BREAK_POINT) {

    this.BREAK_POINT = BREAK_POINT;
      
    this.limit       = 0;

    this.$_elements  = $('.container').find('.js-print-block');
  }
  
  PageBreaker.prototype.initialize = function() {
      
    this.$_elements.each(elementsEach.bind(this));
  }
  
  function elementsEach(index, element) {

    var $_actual = $(element);

    var $_prev   = $_actual.prev('.js-print-block');

    var $_next   = $_actual.next('.js-print-block');

    this.limit  += $_actual.height();

    if (this.limit > this.BREAK_POINT) {

      this.limit = $_actual.height();

      if ($_actual.hasClass('mt-3'))

        $_actual.removeClass('mt-3');
      
      $_actual.addClass('page-header');

      if ($_prev)

        $_prev.addClass('page-break__after');

      if ($_next)

        $_next.addClass('mt-3');

    } else {

      if (!$_actual.hasClass('mt-3'))

        $_actual.addClass('page-header');

      if ($_next)

        $_next.addClass('mt-3');
    }
  }
  
  return PageBreaker;
    
}());