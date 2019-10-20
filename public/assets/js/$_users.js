$(document).ready(function () {

  // Roles Checkbox
	
	var rolesCheckbox = $('input:checkbox[name^="roles"]');

  $.each(rolesCheckbox, function (index) {

    var count = index + 2;

    $(`#role_${count}`).on('ifClicked', function() {

      $(this).on('ifChecked', function() {

        for (var i = count; i <= (rolesCheckbox.length + 1); i++) {
        	
          $(`#role_${i}`).iCheck('check');
          $(`#role_${i}`).attr('checked', true).blur(); // Set the focus to Jquery Validation works fine

          $(`#role_${i}`).parents('.form-check-label').next().addClass('not-allowed');
        }
      });

      $(this).on('ifUnchecked', function() {

        for (var i = count; i <= (rolesCheckbox.length + 1); i++) {
        	
          $(`#role_${i}`).iCheck('uncheck');
          $(`#role_${i}`).attr('checked', false).blur(); // Set the focus to Jquery Validation works fine

          $(`#role_${i}`).parents('.form-check-label').next().removeClass('not-allowed');
        }
      });
    });
  });

  // Form Validation - Create

  var baseURL  = $('body').data('url');

  var userForm = $('#userForm');

  var userID   = null;

  var checkboxes = jQuery.map($('input:checkbox[name^="roles"]'), function (n, i) {

    return n.name;

  }).join(' ');

  var groups = {

    checkboxes: checkboxes
  }

  var rules    = {

    name: {

      required  : [ true, 'Nome' ],
      maxlength : 100
    },

    email: {

      required  : [ true, 'Email' ],
      maxlength : 100,
      email     : true,
      remote    : `${baseURL}/unique/users/email/NULL`
    }
  };

  var messages = {};

  // Form Validation - Edit

  if(userForm.data('resource-id')) {

    userID = userForm.data('resource-id');

    // Rule modification for update
    rules.email.remote = `${baseURL}/unique/users/email/${userID}`;

    rules = AdminTR.mergeObjects(rules, {

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
    });

    messages = AdminTR.mergeObjects(messages, {

      actual_password: {

        remote  : 'O campo Senha Atual está incorreto.'
      },

      password: {

        pattern : 'A senha deve conter letras, números e pelo menos um caracter especial!'
      },

      password_confirmation: {

        equalTo : "A confirmação para o campo Nova Senha não coincide."
      }
    });
  }

  // Form Validation

  userForm.validate({

    groups: groups,

    rules: rules,

    messages: messages
  });

  // Add rules to checkbox roles if exists
  $('input:checkbox[name^="roles"]').each(function() {

    $(this).rules('add', {

      at_least_one : [ true, 'Nível(is)' ]
    });
  });

  // Select 2 Tags - Grouped
  
  new AdminTR.select2Builder($('.select2__tags'), 'action-select2-tags', 'tags', false, false, false, true, true);

  $(document).on('click', '.select2-results__group', function() {

    // Find the items with this location
    var unselected = $('.select2-results__options .select2-results__option[role="treeitem"]').not('[aria-selected="true"]');

    if(unselected.length)

      unselected.trigger('mouseup');

    else {

      var selected = $('.select2-results__options .select2-results__option[role="treeitem"]').not('[aria-selected="false"]');

      $.each(selected, function(key, value) {

        $(this).attr('aria-selected', false);
      });

      $('.select2__tags').html('').trigger('change');
    }
  });

  // Unique validator route test

  /*
  $.ajax({
    url: `${baseURL}/unique/users/email/NULL`, 
      type: 'GET', 
      data: { "email" : "blood@email.com" }, // single field - false - exists
      //data: { "email" : "blood@email.com.br" }, // single field - true - not exists
      //data: { "email" : "blood@email.com", "name" : "BLOOD" }, // multiple field - false - exists
      //data: { "email" : "blood@email.com.br", "name" : "BLOOD" }, // multiple field - true - not exists
      success: function (data) {

      console.log(data);
    },
      error: function (jqXHR, exception) {

      console.log(jqXHR);
      console.log(exception);
    },
  });
  */

});