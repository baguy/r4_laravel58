var AdminTR = AdminTR || {};

AdminTR.Users_secretary__Chart_horizontalBar = (function() {
  
  function Users_secretary__Chart_horizontalBar() {

    this.$_canvas = $('#Users_secretary__Chart--horizontalBar');

    this.params = {
      C_group : 'secretarias', 
      C_sort  : 'secretarias.nome', 
      C_order : 'ASC'
    }

    this.custom = {

      type: 'horizontalBar', 

      datasets: [{

        label: 'Usuários'
      }], 

      options: {

        legend: {

          position: 'bottom'
        }, 

        scales: {

          xAxes: [{

            ticks: {

              beginAtZero: true, 

              stepSize: 100
            }
          }], 

          yAxes: [{

            afterFit: function(scaleInstance) {

              scaleInstance.width = 250; // sets the width to 190px
            }, 

            scaleLabel: {

              display: true,

              labelString: 'SECRETARIAS',
            }, 

            barPercentage: 0.7, 

            categoryPercentage: 0.7, 

            barThickness: 'flex', 

            ticks: {
              
              callback: function(value, index, values) {

                const truncate = (value.length > 35) ? `${ value.substring(0, 35) }...` : value;

                return truncate;
              }
            }
          }]
        }, 

        title: {

          display: true, 

          fontSize: 15, 

          fontColor: '#000', 

          padding: 15, 

          text: `${ this.$_canvas.data('chart-title') } - ${ AdminTR.getFullDate() }`
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

  Users_secretary__Chart_horizontalBar.prototype.initialize = function() {

    var chartBuilder = new AdminTR.ChartBuilder(
      'Users_secretary__Chart--horizontalBar', 
      'Users_secretary__Animation--progress', 
      this.params, 
      'secretaria_', 
      this.custom, 
      'Users_secretary__PNG--download', 
      'orange'
    );

    chartBuilder.initialize();

    // Data Export - Usuários por secretaria

    var $_form = $('<form>');

    $.each(this.params, function(index, value) {
      
      $('<input>').attr({
        type: 'hidden',
        name: index,
        value: value
      }).appendTo($_form);
    });

    new AdminTR.DataExport($(document.getElementById('Users_secretary__XLS--export')), $_form.serializeArray()).initialize();
  }
  
  return Users_secretary__Chart_horizontalBar;
  
}());

var $_element = $('#Users_secretary__Chart--horizontalBar');

var object    = new AdminTR.Users_secretary__Chart_horizontalBar();

AdminTR.LazyLoader($_element, object);