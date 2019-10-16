var AdminTR = AdminTR || {};

AdminTR.QuickRegistration = (function() {
	
	function QuickRegistration($_target, $_addButton, $_modal, rules, messages, child = null, $_nextFocus = null) {

		this.$_target         = $_target;
		this.$_addButton      = $_addButton;
		this.$_modal          = $_modal;
		this.rules            = rules;
		this.messages         = messages;
		this.child            = child; // { '$_addButton' : null, '$_modal' : null, '$_form' : null, '$_field' : null }
		this.$_nextFocus      = $_nextFocus;

		this.$_saveButton     = this.$_modal.find('.js-modal-save-button');
		this.$_form           = this.$_modal.find('form');
		this.$_url            = this.$_form.attr('action');

		this.$_alertSuccess   = this.$_modal.find('.alert-success');
		this.$_alertDanger    = this.$_modal.find('.alert-danger');
		this.$_alertDanger_ul = this.$_alertDanger.find('ul');

		this.validator        = null;
	}
	
	QuickRegistration.prototype.initialize = function() {

		if (this.$_target.parents('form').data('resource-id'))

			onTargetChange.call(this);

		this.$_target.on('change', onTargetChange.bind(this));

		this.$_addButton.on('click', onAddNewButtonClick.bind(this));

		this.$_modal.on('hide.bs.modal', onModalClose.bind(this));

		this.$_saveButton.on('click', onSaveButtonClick.bind(this));

		this.$_form.on('submit', function(event) { event.preventDefault(); });

		this.$_form.on('keyup', onFormKeyup.bind(this));
		
		this.validator = this.$_form.validate({

			onfocusout: false,

			// onkeyup: false,

      rules: this.rules,

      messages: this.messages,

      invalidHandler: invalidHandler.bind(this),

      submitHandler: onSubmitHandler.bind(this)
    });
	}

	function onTargetChange() {

		if (this.child) {

			var $_field = this.child.$_form.find(this.child.$_field);

      $('#quickRegistration__ParentFieldText').remove(); // Remove prepared content if already exists

			if (this.$_target.val() && $.trim(this.$_target.val()).length !== 0) {

        this.child.$_addButton.removeClass('disabled'); // Remove disabled class

      	$_field.val(this.$_target.val()); // Set field value

      	// Prepare content
      	var $_content = $('<div id="quickRegistration__ParentFieldText">')
																							      										.addClass('h4 text-muted font-weight-light')
																							      										.append(this.$_target.find('option:selected').text());

      	// Insert content before hidden field
      	$_content.insertBefore(this.child.$_field);

      } else {

        this.child.$_addButton.addClass('disabled');

        $_field.val(null); // Reset field value
      }
		}
	}
	
	function onAddNewButtonClick(event) {

		if (this.$_addButton.hasClass('disabled'))

      event.stopPropagation();

    else

      this.$_modal.modal('show');
	}
	
	function onModalClose() {

		this.$_saveButton.attr('disabled', false);

		alertDangerReset.call(this);

		this.$_form.trigger('reset');

		removerErrorClasses.call(this);

		this.validator.resetForm();
	}
	
	function onSaveButtonClick() {

		if (this.$_form.valid()) {

			this.$_saveButton.attr('disabled', true);

    	this.validator.resetForm();
    	
    	this.$_form.submit();
		}

	}

	function onFormKeyup() {

		this.$_saveButton.attr('disabled', false);
	}

	// Form Validator

	function invalidHandler(event, validator) {

		var errors = validator.numberOfInvalids();

		if (errors) {

			var message = this.$_form.data('validation-errors');

			alertDangerDisplay.call(this, message);
		}
	}

	function onSubmitHandler(form) {

		$.ajax({
			url: this.$_url,
			method: 'POST',
			contentType: 'application/x-www-form-urlencoded',
			data: $(form).serializeArray(),
			error: onError.bind(this),
			success: onSuccess.bind(this)
		});
	}
	
	function onError(errors) {

		console.log(errors);

		// Error 500 - Internal Server Error
		if (errors.responseJSON.error) {

			var message = this.$_modal.find('.modal-body').data('error');

			alertDangerDisplay.call(this, message);

			console.log(`File    : ${errors.responseJSON.error.file}`);
			console.log(`Line    : ${errors.responseJSON.error.line}`);
			console.log(`Message : ${errors.responseJSON.error.message}`);
			console.log(`Type    : ${errors.responseJSON.error.type}`);
		}

		// Error 400 - Bad Request
		if (errors.responseJSON.content) {

			var message = this.$_form.data('validation-errors');

			alertDangerDisplay.call(this, message);
		
			this.$_form.find('.form-group').removeClass('has-error');
			
			$.each(errors.responseJSON.content, function(index, error) {

				var $_formGroup = $(this.$_form).find(document.getElementsByName(index)).closest('.form-group');

				$_formGroup.addClass('has-error').append(`<div class="invalid-feedback">${ error }</div>`);

				$_formGroup.find('.form-control').addClass('has-error__icon');
				
	    }.bind(this));
		}
	}
	
	function onSuccess(data) {

		removerErrorClasses.call(this);

		alertDangerReset.call(this);

		alertSuccessDisplay.call(this, data);

		targetRebuild.call(this, data);
	}

	// Private Methods

	function targetRebuild(data) {

		this.$_target.append($('<option>').text(data.content.text).val(data.content.value));

		this.$_target.val(data.content.value).trigger('change');

		sortOptions.call(this);
	}

	function sortOptions() {

		// Store empty value option
		var $_select = this.$_target.find('option').filter(function() {

      return !this.value || $.trim(this.value).length === 0;
    });

		// Sort options ignoring empty value
		this.$_target.html(this.$_target.find('option')
			.filter(function() {

        return this.value && $.trim(this.value).length !== 0;
    	})
    	.sort(function(x, y) {

    		var t1 = $(x).text().toLowerCase(), t2 = $(y).text().toLowerCase();

	    	return (t1).localeCompare(t2);
	  	})
	  );

		// Prepend empty value option
	  this.$_target.prepend($_select);
	}

	function removerErrorClasses() {

		this.$_form.find('.form-control').removeClass('has-error__icon');

		this.$_form.find('.form-group').removeClass('has-error');
	}

	function alertDangerReset() {

		this.$_alertDanger_ul.empty();

		this.$_alertDanger.hide();
	}

	function alertDangerDisplay(message) {

		this.$_alertDanger_ul.html(`<li>${ message }</li>`);

		this.$_alertDanger.slideDown();

		setTimeout(function() {

	    this.$_alertDanger.slideUp('normal', function() {

        alertDangerReset.call(this);
        
      }.bind(this));
        	
    }.bind(this), 3000);
	}

	function alertSuccessDisplay(data) {

		this.$_alertSuccess.html(data.message);

		this.$_alertSuccess.slideDown();

		setTimeout(function() {

	    this.$_alertSuccess.slideUp('normal', function() {

        $(this).empty();
        
      });
			
			setTimeout(function() {

				this.$_modal.modal('hide');

				if (this.$_nextFocus)
				
					this.$_nextFocus.prop('disabled', false).focus();

	    }.bind(this), 1500);
        	
    }.bind(this), 1000);
	}
	
	return QuickRegistration;
	
}());