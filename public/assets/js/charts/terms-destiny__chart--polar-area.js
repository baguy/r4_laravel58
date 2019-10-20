var AdminTR = AdminTR || {};

AdminTR.Terms_destiny__Chart_polarArea = (function() {
  
  function Terms_destiny__Chart_polarArea(datePickerYear) {

    this.datePickerYear = datePickerYear;

    this.$_canvas = $('#Terms_destiny__Chart--polarArea');

    this.chartBuilder = {};

    this.params = {
      C_group : 'destinos', 
      C_sort  : 'destinos.nome', 
      C_order : 'ASC'
    }

    this.custom = {

      type: 'polarArea', 

      datasets: [{

        label: ''
      }], 

      options: {

        legend: {

          position: 'bottom'
        }, 

        title: {

          display: true, 

          fontSize: 15, 

          fontColor: '#000', 

          padding: 15
        }
      }
    }
  }

  Terms_destiny__Chart_polarArea.prototype.initialize = function() {

    onYearSelected.call(this);

    this.datePickerYear.on('year-selected', onYearSelected.bind(this));
  }

  function onYearSelected(event, value) {

    $('.js-datepicker-year').attr('disabled', false);

    this.params.S_year = this.datePickerYear.datePickerYear[0].value;

    if (event === 'year-selected' && value)
      
      this.params.S_year = value;

    this.custom.options.title.text = `${ this.$_canvas.data('chart-title') } - ${ AdminTR.getFullDate(this.params.S_year) }`;

    if (!event)
      
      this.chartBuilder = new AdminTR.ChartBuilder(
        'Terms_destiny__Chart--polarArea', 
        'Terms_destiny__Animation--progress', 
        this.params, 
        'secretaria_', 
        this.custom, 
        'Terms_destiny__PNG--download'
      );

    this.chartBuilder.initialize();

    // Data Export - Termos por Secretarias - Destino

    var $_form = $('<form>');

    $.each(this.params, function(index, value) {
      
      $('<input>').attr({
        type: 'hidden',
        name: index,
        value: value
      }).appendTo($_form);
    });

    new AdminTR.DataExport($(document.getElementById('Terms_destiny__XLS--export')), $_form.serializeArray()).initialize();
  }
  
  return Terms_destiny__Chart_polarArea;
  
}());