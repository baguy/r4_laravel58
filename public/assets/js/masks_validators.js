/**
* Máscaras para campos do formulário de indivíduos
* @author Mayra Dantas Bueno
*/

$(document).ready(function(){
  $("#nis").mask("999.99999.99-9");
  $("#sus").mask("000 0000 0000 0000");
  $(".data").mask("99/99/9999");
  $("#cpf").mask("999.999.999-99");
  $("#cep").mask("99999-999");
  $("#ramal").mask("0000");
  $(".ddd").mask("00");
  $('.renda_familiar').mask('000.000.000.000.000,00', {reverse: true});
  $('.datas').mask('00/00/0000');

  /**
  * Máscara de telefone caso número tenha 8 ou 9 dígitos
  * @author Mayra Dantas Bueno / Rodrigo Borges
  */

  var SPMaskBehavior = function (val) {
    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
  },
  spOptions = {
    onKeyPress: function(val, e, field, options) {
      field.mask(SPMaskBehavior.apply({}, arguments), options);
    }
  };
  $('.telefones').mask(SPMaskBehavior, spOptions);


  var idIndividuo = null;
  var idIndividuoEdit = null;

  if($('#IndividuoForm').attr('data-individuo_id')){
    idMunicipe = $('#IndividuoForm').attr('data-individuo_id');
  }
  if($('#IndividuoFormEdit').attr('data-individuoedit_id')){
    idIndividuoEdit = $('#IndividuoFormEdit').attr('data-individuoedit_id');
  }

  /**
  * Mensagens de validação
  * @author Mayra Dantas Bueno
  */

  jQuery.extend(jQuery.validator.messages, {
    required: "Esse campo é obrigatório",
    email: "Digite um email válido",
    validaDataBR: "Digite uma data válida",
    digits: "Digite apenas números",
    minlength: "Este campo deve ter no mínimo {0} caracteres",
    maxlength: "Este campo não deve ultrapassar {0} caracteres",
    number: "Digite apenas números",
    letras: "Este campo não aceita números nem caracteres especiais",
  });

  /**
  * Requisitos de validação front-end
  * alguns métodos adicionais se encontram em validate-methods.js
  * @author Mayra Dantas Bueno
  */

  $.each($("form"), function(i){
    $(this).validate({
      ignore: ":hidden:not(.do-not-ignore)",
      rules: {
      //====================== VIEWS WITH SEARCH INPUTS====================//
      buscar: {
        required:true,
        maxlength:70,
        letras:true,
      },
      // ===================== MUNÍCIPES ===================== //
      nome: {
        required: true,
        maxlength: 100,
        minlength: 3,
        letras: true,
      },
      medico: {
        required: true,
        maxlength: 100,
        minlength: 3,
        letras: true,
      },
      tipo_sexo_id: {
        required: true
      },
      email:{
        email: true,
      },
      data_nascimento: {
        required: true,
        validaDataBR: true,
      },
      data_coleta: {
        required: true,
        validaDataBR: true,
      },
      unidade: {
        required: true,
      },
      estado:{
        required: true,
      },
      cidade:{
        required: true,
      },
      logradouro:{
        required: true,
        maxlength: 100,
        minlength: 3,
      },
      numero:{
        number: true,
      },
      bairro:{
        required: true,
      },

      // ===================== DOCUMENTO ===================== //

      cpf: {
        regex: "^[0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2}$",
        verificaCPF: true,
      },
      sus:{
        required: true,
      },
      nis: {
        regex: "^[0-9]{3}.[0-9]{5}.[0-9]{2}-[0-9]{1}$",
      },
    },

      // ===================== MAPA ===================== //

    messages:{
      longitude: {
        required: "É obrigatória a marcação no mapa"
      }
    },

    /**
    * Inserir mensagem de validação após o elemento
    * @author Mayra Dantas Bueno
    */

    errorPlacement: function (error, element) {
      error.insertAfter(element.parent());
    },

  });

})

})
