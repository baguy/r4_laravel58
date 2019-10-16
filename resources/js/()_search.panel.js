var AdminTR = AdminTR || {};

AdminTR.SearchPanel = (function(){
	
	function SearchPanel(name) {
		
		this.name              = name;
		this.searchChevron     = $('#searchChevronDown').add('#searchChevronUp');
		this.searchChevronDown = $('#searchChevronDown');
		this.searchChevronUp   = $('#searchChevronUp');
		this.searchBox         = $('#searchBox');
	}
	
	SearchPanel.prototype.initialize = function() {
		
		this.searchChevron.on('click', searchChevronOnClick.bind(this));
		
		setInitialParameters.call(this);
	}
	
	function searchChevronOnClick() {
		
		this.searchBox.slideToggle('slow', searchBoxSlideToggle.call(this));
        
		this.searchChevron.toggleClass('d-none');
	}
	
	function searchBoxSlideToggle() {
    
    if (localStorage.getItem(this.name) === 'TRUE')
        
      localStorage.setItem(this.name, 'FALSE');
        
    else
        
      localStorage.setItem(this.name, 'TRUE');
    
  }
	
	function setInitialParameters() {
		
    if (localStorage.getItem(this.name) === 'TRUE') {

    	this.searchChevronDown.addClass('d-none');
    	this.searchChevronUp.removeClass('d-none');
    	this.searchBox.show();

    } else {

    	this.searchChevronUp.addClass('d-none');
      this.searchChevronDown.removeClass('d-none');
      this.searchBox.hide();
    }
	}
	
	return SearchPanel;
	
}());