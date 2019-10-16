$(document).ready(function () {

  // Popover
  $('[data-popover="popover"]').popover();

  // Tooltip
  $('[data-tooltip="tooltip"]').tooltip();

  // Sidebar
  $('.sidebar').slimScroll({
    height: 'calc(100% - 28.5px)'
  });

  // iCheck
  $('.icheck').iCheck({
    checkboxClass: 'icheckbox_square-blue',
    radioClass   : 'iradio_square-blue',
    increaseArea : '20%' // optional
  });

  // Select 2
  $.fn.select2.defaults.set('theme', 'bootstrap4');
  $.fn.select2.defaults.set('width', 'auto');
  $.fn.select2.defaults.set('dropdownAutoWidth', true);
  $.fn.select2.defaults.set('language', 'pt-BR');

  $('.select2').select2({});

  // Removes session flash
  AdminTR.removeSessionFlash();

  // Shows loading icon blocking page til it's ready
  $('.spinner-loading').delay(3000).hide();

  // $.ajaxSetup({

  //   headers: {
      
  //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  //   }
  // });

  // Chosen
  // $('.js-chosen').chosen({
  //   allow_single_deselect: true, 
  //   no_results_text: 'Oops, nenhum registro encontrado!', 
  //   width: '100%'
  // });
    
  /*
  $(".cpf-mask").mask("999.999.999-99");
  $(".cnpj-mask").mask("99.999.999/9999-99");
  $(".hour-mask").mask("99:99");
  $(".date-mask").mask("99/99/9999");
  $(".cep-mask").mask("99999-999");
  $(".since-mask").mask("aaa/9999");
  
  $('.fone-mask').focusout(function(){
      
      var phone, element;
      element = $(this);
      element.unmask();
      phone = element.val().replace(/\D/g, '');
      
      if(phone.length > 10) {
          
          element.mask("(99) 99999-999?9");
          
      } else {
          
          element.mask("(99) 9999-9999?9");
      }
  }).trigger('focusout');
  */
  
  /*
  $('.price-mask').priceFormat({
      prefix: '',
      centsSeparator: ',',
      thousandsSeparator: '.'
  });
  */

  /*
  $('#myTabs a').click(function (e) {
      e.preventDefault();
      $(this).tab('show');
  });
  */

  /*
  //Digita apenas números
  //called when key is pressed in textbox
  $(".only-numbers").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which !== 8 && e.which !== 0 && (e.which < 48 || e.which > 57)) {
        return false;
    }
   });
  */

  /*
  //Digita apenas números e vígula
  //called when key is pressed in textbox
  $(".only-decimals").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which !== 44 && e.which !== 8 && e.which !== 0 && (e.which < 48 || e.which > 57)) {
        return false;
    }
   });
  */
});