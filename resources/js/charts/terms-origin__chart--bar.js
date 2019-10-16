var AdminTR = AdminTR || {};

AdminTR.Terms_origin__Chart_bar = (function() {
  
  function Terms_origin__Chart_bar(datePickerYear) {

    this.datePickerYear = datePickerYear;

    this.$_canvas = $('#Terms_origin__Chart--bar');

    this.chartBuilder = {};

    this.params = {
      C_group : 'origens', 
      C_sort  : 'origens.nome', 
      C_order : 'ASC'
    }

    this.custom = {

      type: 'bar', 

      datasets: [{

        label: 'Termos'
      }], 

      options: {

        legend: {

          position: 'bottom'
        }, 

        scales: {

          xAxes: [{

            afterFit: function(scaleInstance) {

              scaleInstance.width = 190; // sets the width to 190px
            }, 

            barPercentage: 0.7, 

            categoryPercentage: 0.7, 

            barThickness: 'flex', 

            ticks: {

              autoSkip: false, 

              maxRotation: 45, 

              minRotation: 45, 
              
              callback: function(value, index, values) {

                const truncate = (value.length > 25) ? `${ value.substring(0, 25) }...` : value;

                return truncate;
              }
            }
          }], 

          yAxes: [{

            scaleLabel: {

              display: true,

              labelString: 'SECRETARIAS',
            }, 

            ticks: {

              beginAtZero: true, 

              stepSize: 100
            }
          }]
        }, 

        title: {

          display: true, 

          fontSize: 15, 

          fontColor: '#000', 

          padding: 15
        }, 

        tooltips: {

          callbacks: {

            title: function(tooltipItem, data) {

              return data.labels[tooltipItem[0].index];
            }
          }
        }
      }
    }
  }

  Terms_origin__Chart_bar.prototype.initialize = function() {

    onYearSelected.call(this);

    this.datePickerYear.on('year-selected', onYearSelected.bind(this));
  }

  function onYearSelected(event, value) {

    $('.js-datepicker-year').attr('disabled', false);

    this.params.S_year = this.datePickerYear.datePickerYear[0].value;

    if (event && event.type === 'year-selected' && value)
      
      this.params.S_year = value;

    this.custom.options.title.text = `${ this.$_canvas.data('chart-title') } - ${ AdminTR.getFullDate(this.params.S_year) }`;

    if (!event)

      this.chartBuilder = new AdminTR.ChartBuilder(
        'Terms_origin__Chart--bar', 
        'Terms_origin__Animation--progress', 
        this.params, 
        'secretaria_', 
        this.custom, 
        'Terms_origin__PNG--download', 
        'blue'
      );

    this.chartBuilder.initialize();

    // Data Export - Subcategorias por categoria

    var $_form = $('<form>');

    $.each(this.params, function(index, value) {
      
      $('<input>').attr({
        type: 'hidden',
        name: index,
        value: value
      }).appendTo($_form);
    });

    new AdminTR.DataExport($(document.getElementById('Terms_origin__XLS--export')), $_form.serializeArray()).initialize();
  }
  
  return Terms_origin__Chart_bar;
  
}());