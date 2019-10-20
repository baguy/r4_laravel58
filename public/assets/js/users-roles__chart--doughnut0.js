var AdminTR = AdminTR || {};

AdminTR.Users_roles__Chart_doughnut = (function() {
  
  function Users_roles__Chart_doughnut() {

    this.$_canvas = $('#Users_roles__Chart--doughnut');

    this.params = {
      C_group : 'roles', 
      C_sort  : 'roles.name', 
      C_order : 'ASC'
    }

    this.custom = {

      type: 'doughnut', 

      datasets: [{

        label: ''
      }], 

      options: {

        legend: {

          position: 'right'
        }, 

        title: {

          display: true, 

          fontSize: 15, 

          fontColor: '#000', 

          padding: 15, 

          text: `${ this.$_canvas.data('chart-title') } - ${ AdminTR.getFullDate() }`
        }
      }
    }
  }

  Users_roles__Chart_doughnut.prototype.initialize = function() {

    var chartBuilder = new AdminTR.ChartBuilder(
      'Users_roles__Chart--doughnut', 
      'Users_roles__Animation--progress', 
      this.params, 
      'role_', 
      this.custom, 
      'Users_roles__PNG--download'
    );

    chartBuilder.initialize();

    // Data Export - Usuários por níveis

    var $_form = $('<form>');

    $.each(this.params, function(index, value) {
      
      $('<input>').attr({
        type: 'hidden',
        name: index,
        value: value
      }).appendTo($_form);
    });

    new AdminTR.DataExport($(document.getElementById('Users_roles__XLS--export')), $_form.serializeArray()).initialize();
  }
  
  return Users_roles__Chart_doughnut;
  
}());

var $_element = $('#Users_roles__Chart--doughnut');

var object    = new AdminTR.Users_roles__Chart_doughnut();

AdminTR.LazyLoader($_element, object);