$(document).ready(function () {

  var baseURL  = $('body').data('url');

  var changePasswordForm = $('#changePasswordForm');

  var userID   = null;

  var rules    = {

    actual_password: {

      required  : [ true, 'Senha Atual' ],
      remote    : `${baseURL}/password/verify`
    }, 

    password: {

      minlength : 10,
      maxlength : 60,
      pattern   : '^(?=(?:.*[a-zA-z]{1,}))(?=(?:.*[0-9]){1,})(?=(?:.*[!@#$%&*]){1,})(.{10,})$'
    },

    password_confirmation: {

      equalTo   : 'input[name="password"]'
    }
  };

  var messages = {

    actual_password: {

      remote  : 'O campo Senha Atual está incorreto.'
    },

    password: {

      pattern : 'A senha deve conter letras, números e pelo menos um caracter especial!'
    },

    password_confirmation: {

      equalTo : "A confirmação para o campo Nova Senha não coincide."
    }
  };

  // Form Validation

  changePasswordForm.validate({

    rules: rules,

    messages: messages
  });

});