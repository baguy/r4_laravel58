var AdminTR = AdminTR || {};

AdminTR.Items_category__Chart_radar = (function() {
  
  function Items_category__Chart_radar() {

    this.$_canvas = $('#Items_category__Chart--radar');

    this.params = {
      C_group : 'categorias', 
      C_sort  : 'categorias.nome', 
      C_order : 'ASC'
    }

    this.custom = {

      type: 'radar', 

      datasets: [{

        label: 'Itens'
      }], 

      options: {

        legend: {

          position: 'bottom'
        }, 

        scales: {

          display: false
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

  Items_category__Chart_radar.prototype.initialize = function() {

    var chartBuilder = new AdminTR.ChartBuilder(
      'Items_category__Chart--radar', 
      'Items_category__Animation--progress', 
      this.params, 
      'categoria_', 
      this.custom, 
      'Items_category__PNG--download', 
      'green'
    );

    chartBuilder.initialize();

    // Data Export - Itens por categoria

    var $_form = $('<form>');

    $.each(this.params, function(index, value) {
      
      $('<input>').attr({
        type: 'hidden',
        name: index,
        value: value
      }).appendTo($_form);
    });

    new AdminTR.DataExport($(document.getElementById('Items_category__XLS--export')), $_form.serializeArray()).initialize();

  }
  
  return Items_category__Chart_radar;
  
}());

var $_element = $('#Items_category__Chart--radar');

var object    = new AdminTR.Items_category__Chart_radar();

AdminTR.LazyLoader($_element, object);