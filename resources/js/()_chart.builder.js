var AdminTR = AdminTR || {};

AdminTR.chartColors = {
  red    : 'rgb(255, 99, 132)',
  orange : 'rgb(255, 159, 64)',
  yellow : 'rgb(255, 205, 86)',
  green  : 'rgb(75, 192, 192)',
  blue   : 'rgb(54, 162, 235)',
  purple : 'rgb(153, 102, 255)',
  grey   : 'rgb(201, 203, 207)',
  white  : 'rgb(255, 255, 255)'
};

AdminTR.ChartBuilder = (function() {
	
	function ChartBuilder(element, progress = null, params = {}, field, custom = {}, download, color = null) {

		this.element  = document.getElementById(element);

		this.progress = document.getElementById(progress);

		this.ctx      = this.element.getContext('2d');

		this.params   = params;

		this.field    = field;

		this.color    = color;

		this.custom   = custom;

    this.chart    = {};

		this.$_btn_download = $(document.getElementById(download));

		this.filePath = null;
	}
	
	ChartBuilder.prototype.initialize = function() {
		
		$.ajax({
			url: $(this.element).data('url'), 
			method: 'GET', 
			data: this.params, 
			success: onSuccess.bind(this)
		});
	}
	
	function onSuccess(data) {

    // console.log('data: ', data);
		
		var labels          = [];
    var values          = [];
    var backgroundColor = [];

    data.forEach(function(element) {

      var label = element[this.field];

      if (this.field === 'secretaria_')

      	label = label.replace(/Secretaria Municipal de|Secretaria Municipal dos/gi, function (x) {
	        return '';
	      });

      labels.push(label);

      values.push(element.total);

      var color = AdminTR.randomColor('rgba');
      
      backgroundColor.push(color);

    }.bind(this));

    var sorted = [];

    for (var j = 0; j < labels.length; j++)

      sorted.push({'label': labels[j], 'value': values[j]});

    sorted.sort(function(a, b) {

      var s1 = a.label.toLowerCase(), s2 = b.label.toLowerCase();

      return (s1).localeCompare(s2);
    });

    for (var k = 0; k < sorted.length; k++) {

      labels[k] = sorted[k].label;

      values[k] = sorted[k].value;
    }

    // Color treatments

    var chartHelpersColor = Chart.helpers.color;

    var borderColor       = AdminTR.chartColors.white;

    if (this.color) {
      
      borderColor     = getColor(this.color);

      backgroundColor = chartHelpersColor(borderColor).alpha(0.5).rgbString();
    }

    // Chart - Config

    var config = {

      // The type of chart we want to create
      type: this.custom.type,

      // The data for our dataset
      data: {

        labels: labels, 

        datasets: [{
          label           : this.custom.datasets[0].label, 
          backgroundColor : backgroundColor, 
          borderColor     : borderColor, 
          borderWidth     : 2, 
          data            : values
        }]
      }
    }

    // Chart - Config : Data : Datasets

    if (config.type === 'radar') {

      config.data.datasets[0].pointBackgroundColor      = chartHelpersColor(borderColor).rgbString();
      config.data.datasets[0].pointBorderColor          = AdminTR.chartColors.white;
      config.data.datasets[0].pointHoverBackgroundColor = AdminTR.chartColors.white;
      config.data.datasets[0].pointHoverBorderColor     = chartHelpersColor(borderColor).rgbString();
    }

    // Chart - Options

    var options = {

      animation: {

        duration   : 2000, 

        onComplete : onComplete.bind(this), 

        onProgress : onProgress.bind(this)
      }, 

      responsive: true
    }

    // Chart - Options - Custom

    if (this.custom.options.legend)

    	options.legend = this.custom.options.legend;

    if (this.custom.options.scales)

    	options.scales = this.custom.options.scales;

    if (this.custom.options.title)

    	options.title = this.custom.options.title;

    if (this.custom.options.tooltips)

      options.tooltips = this.custom.options.tooltips;

    // Chart - Config - Options

    config.options = options

  	// Chart - Instance

    if (!jQuery.isEmptyObject(this.chart)) {

      this.chart.config = config;

      this.chart.options.title.text = this.custom.options.title.text;

      this.chart.update();
    }

    else {

      this.chart = new Chart(this.ctx, config);
    }

		function onComplete() {

	    this.filePath = this.chart.toBase64Image();

      this.$_btn_download.off();

			this.$_btn_download.on('click', _download.bind(this));

      if (this.progress)

  	    window.setTimeout(function() {

  	      this.progress.value = 0;

  	      $(this.progress).remove();

  	    }.call(this), 2000);
	  }

	  function onProgress(animation) {

      if (this.progress)
	     
       this.progress.value = animation.animationObject.currentStep / animation.animationObject.numSteps;
	  }
	}

	function _download(e) {

    e.preventDefault();

    e.stopPropagation();

    var $_target = $(e.currentTarget);

    download(this.filePath, $_target.attr('download'), 'image/png');

    // var _window = window.open();

    // // _window.document.write('<iframe src="' + this.filePath  + '" frameborder="0" style="border:0; top:0px; left:0px; bottom:0px; right:0px; width:100%; height:100%;" allowfullscreen></iframe>');

    // _window.document.body.innerHTML = '<img src="' + this.filePath  + '">';
    
    // _window.document.close();
	}

  function getColor(color) {

    switch (color) {

      case 'red':
        
        return AdminTR.chartColors.red;

      case 'orange':
        
        return AdminTR.chartColors.orange;

      case 'yellow':
        
        return AdminTR.chartColors.yellow;

      case 'green':
        
        return AdminTR.chartColors.green;

      case 'blue':
        
        return AdminTR.chartColors.blue;

      case 'purple':
        
        return AdminTR.chartColors.purple;

      case 'grey':
        
        return AdminTR.chartColors.grey;
    }
  }
	
	return ChartBuilder;
	
}());