$(document).ready(function(){
// Máscara para datas
  $('.datas').mask('00/00/0000')

  /**
  * Adicionar máscara de ddd e telefones em divs clonadas
  * @author Rodrigo Borges
  */
  $(document).on('click', 'button.addCloned', function(){
    newElement = addCloned($(this),$(this).data('limit'))

    var SPMaskBehavior = function (val) {
      return val.replace(/\D/g, '').length === 11 ? '(00)00000-0000' : '(00)0000-00009';
    },
    spOptions = {
      onKeyPress: function(val, e, field, options) {
        field.mask(SPMaskBehavior.apply({}, arguments), options);
      }
    };
    newElement.find(".telefone_mask").mask(SPMaskBehavior, spOptions)
    newElement.find(".ddd_mask").mask("00")
    newElement.find(".datas").mask("00/00/0000")
  })


/**
* Habilitar campo input Data de casamento quando
* selecionado id Estado Civil específico (6, 7 e 8)
* @author Mayra Dantas Bueno
*/
  var estado_civil   = $('#tipo_estado_civil');
  var data_casamento = $('#data_casamento');

  $(estado_civil).change(async function () {
    mudaData(estado_civil.val());
  });

  async function mudaData(estado_civil){
    if(estado_civil >= 6){
      $('#data_casamento').removeAttr('disabled');
    }else{
      $('#data_casamento').attr('disabled', true);
    }
  }


  /**
  * Calcular idade da pessoa sendo cadastrada
  * e exibir no campo idade
  * @author Mayra Dantas Bueno
  */
  var niver = $('#data_nascimento');

  getAgeEdit(niver.val());

  $(niver).change(async function () {
    getAge(niver.val());
    console.log(niver.val());
  });

  async function getAge(data) {
      var today = new Date();
      var dia = data.substr(0, 2);
      var mes = data.substr(3, 2);
      var ano = data.substr(6, 7);
      var dateString = mes.concat("-",dia,"-", ano);
      birthDate = new Date(dateString);
      var age = today.getFullYear() - birthDate.getFullYear();
      var m = today.getMonth() - birthDate.getMonth();
      if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
          age--;
      }
      document.getElementById('idade').value=(age);
  }

  /**
  * Verificar se CPF é único
  * @author Mayra Dantas Bueno
  */
  var cpf = $('#cpf');

  $(cpf).change(async function () {
    var value = jQuery.trim($(cpf).val());
    value = value.replace(/[^\d]+/g,'');
    procuraCPF(cpf,value);
  });

  async function procuraCPF(cpf,value) {
    var retorno = false;
    console.log(cpf);
    if(value !== "") {
      $.get(main_url + "findCPF/" + value, function (data) {
        if(data.length){
                alert ( "CPF já cadastrado" );
                document.getElementById('cpf').value=(''); //ZERA O CAMPO CPF
              }
      });
    }
  };

}); //$(documento).ready

/**
* Método para CLONAR divs
* @author Mayra Dantas Bueno
*/
function addCloned(element, limit = null) {
  var clonedParent = element.parents('div.cloned-main');
  clonedParent.find('div.alert').remove()
  if(clonedParent.find('div.cloned-div').length == limit){
    clonedParent.find('div.cloned-div').last().after('<div class="time-close alert alert-danger"> <button type="button" class="close" data-dismiss="alert">x</button>Limite Máximo de telefones atingido!</div>');
    return false;
  }
  var cloned = clonedParent.find('div.cloned-div').first();
  cloned.clone().insertAfter(clonedParent.find('div.cloned-div').last()).find("input").val("")

  recontar(clonedParent.find('div.cloned-div'))
  return clonedParent.find('div.cloned-div').last()
}

function clonar(clone, target){
  //Atribuição value nulo p/ todos os campos
  clone.find('input:not([type=radio],[type=checkbox]), select').val("");
  clone.find("input:checkbox, input:radio").prop('checked',false);
  //remoção de erros existentes
  clone.find('label.error').remove();
  clone.find('*').removeClass('error');
  //inserção do elemento
  clone.insertAfter(target);
}

/**
* Método para deletar div clonada
* @author Mayra Dantas Bueno
*/
$(document).on('click', 'button.delCloned', function(){
  var clonedParent = $(this).parents('div.cloned-main')

  if(clonedParent.find('div.cloned-div').length != 1)
  $(this).parents('div.cloned-div').remove();
  recontar($('div.cloned-div'))
});

function recontar(divs, callback){
  count = 0;
  $.each(divs, function(i) {
    var campos = $(this).find('input, select');
    var label = $(this).find('label');
    var titulo = $(this).find('h4.titulo');

    titulo.text(titulo.text().replace(/\d+/, (count+1)));

    $.each(campos,function(){
      $(this).attr('name', $(this).attr('name').replace(/\d+/, count));
    })
    // CALLBACK PARA USO DE DIVS ESPECÍFICAS
    if(jQuery.isFunction(callback))
    callback(i,$(this));
    count++;
  })
}

/**
* Calcular idade a partir de data de nascimento já cadastrada
* no formulário editar
* @author Mayra Dantas Bueno
*/
function getAgeEdit(data) {
    var today = new Date();
    var dia = data.substr(0, 2);
    var mes = data.substr(3, 2);
    var ano = data.substr(6, 7);
    var dateString = mes.concat("-",dia,"-", ano);
    birthDate = new Date(dateString);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    document.getElementById('idade').value=(age);
}
