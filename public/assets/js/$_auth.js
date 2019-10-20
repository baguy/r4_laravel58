$(document).ready(function () {

  $('#email').emailautocomplete({
    suggClass: "text-info",
    domains: ["caraguatatuba.sp.gov.br"]
  });

  $('code').click(function() {

    var $temp = $("<input>");

    $('body').append($temp);

    $temp.val($.trim($(this).text())).select();

    document.execCommand("copy");

    $temp.remove();

    doBounce($(this), 2, '3px', 100);
  });

  function doBounce(element, times, distance, speed) {

    for(i = 0; i < times; i++) {

        element.animate({ marginLeft: '-=' + distance }, speed)
            .animate({ marginLeft: '+=' + distance }, speed);
    }
  }
});