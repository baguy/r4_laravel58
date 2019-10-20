// jQuery Validation - Messages
jQuery.extend(jQuery.validator.messages, {

  required : "O campo {1} é obrigatório.", 
  remote   : "O valor informado {0} já está em uso."
});

// jQuery Validation - Default Properties
jQuery.validator.setDefaults({

  debug: false, 

  ignore: [":hidden:not(.chosen-select)"], 

  errorClass: "invalid-feedback", 

  errorElement: "div", 

  errorPlacement: function (error, element) {

    element.parents('.form-group').append(error);
  },

  highlight: function(element, errorClass, validClass) {

    $(element).parents('.form-group').addClass('has-error');

    if (element.type !== 'checkbox' && element.type !== 'radio')
      $(element).addClass('has-error__icon');
  },

  unhighlight: function(element, errorClass, validClass) {

    if ($.trim(element.value)) {

      $(element).parents('.form-group').removeClass('has-error');

      if (element.type !== 'checkbox' && element.type !== 'radio')
        $(element).removeClass('has-error__icon');
    }
  },

  success: function(label) {
    
  },

  onfocusout: function(element) {

    this.element(element);
  },

  invalidHandler: function(event, validator) {
    
    var errors     = validator.numberOfInvalids();

    var message    = $(this).data('validation-errors');

    var alert      = $('<div>').addClass('alert alert-danger session-flash').html(message);

    var $container = $('<div class="container-fluid">').append(alert);
    
    var $section   = $('<section>').addClass('px-2').append($container);

    if (errors) {

      $section.insertAfter('section.content-header');

      AdminTR.removeSessionFlash();
    }
  },

  submitHandler: function(form) {

    $(form).find(':submit').prop('disabled', true);

    form.submit();
  }
});

// jQuery Validation - Custom Methods

// At least one option must be checked, selected or filled - Set "groups: {}" attribute on "form.validate({})" to show only one message

$.validator.addMethod('at_least_one', function(value, element, params) {

  var name = $(element).attr('name').replace(new RegExp('\\[.*?\\]','g'), '');

  var type = $(element).attr('type');

  if (type === 'checkbox')
  
    return $(`input:${type}[name^="${name}"]`).is(':checked');

  if (type === 'hidden')
  
    return $(`input:${type}[name^="${name}"]`).val() !== '';

}, jQuery.validator.format("O campo {1} é obrigatório!"));