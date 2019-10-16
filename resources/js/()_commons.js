var AdminTR = AdminTR || {};

// Merge two objects into one
AdminTR.mergeObjects = function(obj1, obj2) {

  for (var attrname in obj2) {

    obj1[attrname] = obj2[attrname];
  }
  
  return obj1; // Returning obj1 is optional and certainly up to your implementation
};

// Remove session flash messages after 3 seconds
AdminTR.removeSessionFlash = function() {

  var sessionFlash = $('.session-flash');

  if (sessionFlash)

    setTimeout(function() {

      sessionFlash.slideUp('normal', function() {

        $(this).parents('section.px-2').remove();

      });

    }, 3000);
};

// Copy instance from namespace
AdminTR.copyInstance = function(original) {

    var copied = Object.assign(Object.create(Object.getPrototypeOf(original)), original);

    return copied;
};

// Generates random hexadecimal color
AdminTR.randomColor = function (type) {

  switch (type) {

    case 'rgba':
      
      const random = (min, max) => Math.floor(Math.random() * (max - min + 1) + min);
      const byte   = ()         => random(0, 255);
      const alfa   = ()         => (random(50, 50) * 0.01).toFixed(2);
      
      return `rgba(${ [byte(), byte(), byte(), alfa()].join(',') })`;

    case 'hexadecimal':
      
      var hexadecimals = '0123456789ABCDEF';
  
      var color = '#';
      
      for (var i = 0; i < 6; i++ )
        
        color += hexadecimals[Math.floor(Math.random() * 16)];
      
      return color;
  }
};

// Gets months
AdminTR.getMonths = function () {
  
  return [
    'Janeiro',
    'Fevereiro',
    'Março',
    'Abril',
    'Maio',
    'Junho',
    'Julho',
    'Agosto',
    'Setembro',
    'Outubro',
    'Novembro',
    'Dezembro'
  ];
};

// Gets Full Date
AdminTR.getFullDate = function (year) {

  var d = new Date();

  if (year && (year < d.getFullYear()))

    return year;
  
  return `${d.getDate()} de ${AdminTR.getMonths()[d.getMonth()]} de ${d.getFullYear()}`;
};

// Datepicker - $(function() { new AdminTR.DatePicker().initialize(); });
AdminTR.DatePicker = (function() {
  
  function DatePicker() {
    
    this.datePicker = $('.js-datepicker');
  }
  
  DatePicker.prototype.initialize = function() {
    
    this.datePicker.datepicker({
      
      format: 'dd/mm/yyyy',
      autoclose: true,
      todayHighlight: true,
      language: "pt-BR"
          
    }).next().on('click', function () {
      
      $(this).prev().focus();
    });
  }
  
  return DatePicker;
  
}());

// Datepicker Year - $(function() { new AdminTR.DatePickerYear().initialize(); });
AdminTR.DatePickerYear = (function() {
  
  function DatePickerYear(orientation = 'ltr') {

    this.orientation    = orientation;
    
    this.datePickerYear = $('.js-datepicker-year');

    this.emitter        = $({});
    this.on             = this.emitter.on.bind(this.emitter);
  }
  
  DatePickerYear.prototype.initialize = function() {

    var $_instance = this.datePickerYear.datepicker({
        
      format: 'yyyy',
      autoclose: true,
      language: 'pt-BR',
      viewMode: 'years', 
      minViewMode: 'years', 
      endDate: '+0d'
          
    }).on('changeDate', function(e) {
      
      this.emitter.trigger('year-selected', e.currentTarget.value);

    }.bind(this));

    if (this.orientation === 'ltr')

      $_instance.prev().on('click', function () {
        
        $(this).next().focus();
      });

    else
    
      $_instance.next().on('click', function () {
        
        $(this).prev().focus();
      });
  }
  
  return DatePickerYear;
  
}());

// DateTimePicker - $(function() { new AdminTR.DateTimePicker().initialize(); });
AdminTR.DateTimePicker = (function(){
  
  function DateTimePicker() {
    
    this.dateTimePickerInput = $('.js-datetimepicker');
  }
  
  DateTimePicker.prototype.initialize = function () {
    
    // Inicializa o DateTimePicker
    this.dateTimePickerInput.datetimepicker({
      format: 'DD/MM/YYYY HH:mm:ss',
      showClear: true,
      showClose: true,
      locale: 'pt-br',
      tooltips: {
          today: 'Hoje',
          clear: 'Limpar',
          close: 'Fechar',
          selectTime: 'Selecione a Hora',
          selectMonth: 'Selecionar M\xEAs',
          prevMonth: 'M\xEAs Anterior',
          nextMonth: 'Pr\xF3ximo M\xEAs',
          selectYear: 'Selecionar Ano',
          prevYear: 'Ano Anterior',
          nextYear: 'Pr\xF3ximo Ano',
          selectDecade: 'Selecionar D\xE9cada',
          prevDecade: 'D\xE9cada Anterior',
          nextDecade: 'Pr\xF3xima D\xE9cada',
          prevCentury: 'S\xE9culo Anterior',
          nextCentury: 'Pr\xF3ximo S\xE9culo',
          pickHour: 'Selecionar Hora',
          incrementHour: 'Aumentar Hora',
          decrementHour: 'Diminuir Hora',
          pickMinute: 'Selecionar Minuto',
          incrementMinute: 'Aumentar Minuto',
          decrementMinute: 'Diminuir Minuto',
          pickSecond: 'Selecionar Segundo',
          incrementSecond: 'Aumentar Segundo',
          decrementSecond: 'Diminuir Segundo',
          togglePeriod: 'Alternar Período'
      }
    })
    //show DateTimePicker when clicking on the icon
    .next().on('click', function () {
      
      $(this).prev().focus();

    });
  }
  
  return DateTimePicker;
  
}());