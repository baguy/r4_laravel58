var AdminTR = AdminTR || {};

AdminTR.DependentDropdown = (function() {
	
	function DependentDropdown($_parent, $_children, $_childrenSelected, is_filter = false, txtBeforeChange, txtAfterChange, txtNoResult = 'NENHUM REGISTRO ENCONTRADO') {

		this.$_parent           = $_parent;
		this.$_children         = $_children;
		this.$_childrenSelected = $_childrenSelected;

		this.url                = this.$_parent.data('action-dependent-dropdown');
		
		this.ajaxLoader         = $('.js-ajax-loader').children('i');

		this.iconBeforeLoad     = this.ajaxLoader.attr('class');
		this.iconAfterLoad      = 'fas fa-spinner fa-pulse fa-fw';

		this.txtBeforeChange    = txtBeforeChange;
		this.txtAfterChange     = txtAfterChange;
		this.txtNoResult        = txtNoResult;

		this.is_filter          = is_filter;
	}
	
	DependentDropdown.prototype.initialize = function() {
		
		this.$_parent.on('change', onParentChange.bind(this));

		var is_update = this.$_parent.parents('form').data('resource-id');

		populate.call(this, is_update);
	}
	
	function onParentChange() {
		
		populate.call(this);
	}
	
	function populate(is_update = false) {

		var is_filter = this.is_filter;

		if (is_update)

			is_filter = true;

		this.$_children.empty();
		
		var $_parentVal = this.$_parent.val().trim();
		
    if ($_parentVal) {
    	
    	loading.call(this);
    	
      $.get(`${this.url}/${$_parentVal}`, { is_filter: is_filter }, success.bind(this));
    	
    } else {
        
    	this.$_children.append($('<option>').text(this.txtBeforeChange).val('')).trigger('change');
    }
	}
	
	function success(data) {
        
		if (data.valueOf().toString() !== '') {
    	
      $.each(data, appendOptions.bind(this));

      sortOptions.call(this);
			
    	prependOption.call(this);
        
      returnSelectedValue.call(this);
	        
		} else {
			
			this.$_children.append($('<option>').text(this.txtNoResult).val('')).trigger('change');

			loading.call(this);
		}
  }
	
	function appendOptions(index, element) {
		
		this.$_children.append($('<option>').text(element).val(index)).trigger('change');
	}

	function sortOptions() {

		this.$_children.html(this.$_children.find('option').sort(function(x, y) {

    	var t1 = $(x).text().toLowerCase(), t2 = $(y).text().toLowerCase();

	    return (t1).localeCompare(t2);

	  }));
	}

	function prependOption() {

		this.$_children.prepend($('<option>').text(this.txtAfterChange).val(''));

    this.$_children.get(0).selectedIndex = 0;
	}
	
	function returnSelectedValue() {

		if (this.$_childrenSelected) {

			var $_childrenSelectedVal = this.$_childrenSelected.val();
			
			if ($_childrenSelectedVal) {

				this.$_children.val($_childrenSelectedVal).trigger('change');

				this.$_childrenSelected.val('');
			}
		}
		
    loading.call(this);
	}

	function loading(data) {

		if (this.ajaxLoader.attr('class') === this.iconBeforeLoad) {

			this.ajaxLoader.removeClass(this.iconBeforeLoad);

			this.ajaxLoader.addClass(this.iconAfterLoad);

		} else {

			this.ajaxLoader.removeClass(this.iconAfterLoad);

			this.ajaxLoader.addClass(this.iconBeforeLoad);
		}
	}
	
	return DependentDropdown;
	
}());