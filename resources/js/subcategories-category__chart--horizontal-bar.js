var AdminTR = AdminTR || {};

AdminTR.Subcategories_category__Chart_horizontalBar = (function() {
  
  function Subcategories_category__Chart_horizontalBar() {

    this.$_canvas = $('#Subcategories_category__Chart--horizontalBar');

    this.params   = {

      C_group : 'categorias', 

      C_sort  : 'categorias.nome', 

      C_order : 'ASC'
    }

    this.custom   = {

      type: 'horizontalBar', 

      datasets: [{

        label: 'Subcategorias'
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

              scaleInstance.width = 190; // sets the width to 190px
            }, 

            scaleLabel: {

              display: true,

              labelString: 'CATEGORIAS',
            }, 

            barPercentage: 0.7, 

            categoryPercentage: 0.7, 

            barThickness: 'flex', 

            ticks: {
              
              callback: function(value, index, values) {

                const truncate = (value.length > 25) ? `${ value.substring(0, 25) }...` : value;

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
  
  Subcategories_category__Chart_horizontalBar.prototype.initialize = function() {

    var chartBuilder = new AdminTR.ChartBuilder(
      'Subcategories_category__Chart--horizontalBar', 
      'Subcategories_category__Animation--progress', 
      this.params, 
      'categoria_', 
      this.custom, 
      'Subcategories_category__PNG--download', 
      'purple'
    );

    chartBuilder.initialize();

    // Data Export - Subcategorias por categoria

    var $_form = $('<form>');

    $.each(this.params, function(index, value) {
      
      $('<input>').attr({
        type: 'hidden',
        name: index,
        value: value
      }).appendTo($_form);
    });

    new AdminTR.DataExport($(document.getElementById('Subcategories_category__XLS--export')), $_form.serializeArray()).initialize();
  }
  
  return Subcategories_category__Chart_horizontalBar;
  
}());

var $_element = $('#Subcategories_category__Chart--horizontalBar');

var object    = new AdminTR.Subcategories_category__Chart_horizontalBar();

AdminTR.LazyLoader($_element, object);