AdminTR.LazyLoader = function($_element, object) {

  var $_element = $_element;

  var object    = object;

  $(document).ready(function() {

    $(window).scroll(function() {

      var windowTop     = $(window).scrollTop();
      var windowBottom  = windowTop + $(window).height();

      var elementTop    = $_element.offset().top;
      var elementBottom = elementTop + $_element.height();
  
      if (windowBottom >= elementTop && windowTop <= elementBottom) {

        if(!$_element.attr('loaded')) {

          // console.log('LAZY LOAD MOTHER FUCKER!!!');

          $_element.attr('loaded', true);

          object.initialize();
        }
      }

    });

  });

};