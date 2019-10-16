$(document).ready(function () {
  var cidade = $('#cidade'),
      estado = $('#estado');

  // ALTERAÇÃO DE ESTADO
  $(estado).change(async function () {
    cidade.val("");
    mudaCidade(estado, cidade);
  });

  //ALTERAÇÃO DE CIDADE
  $(document).on('change', '#cidade', function(){
    $(this).parent().find(".bairro-input").val("");
    $(this).parent().find(".bairro-select").val("");
  });

  /**
  * Seleciona as cidades conforme o estado selecionado
  * @param {object} estado elemento do select do estado
  * @param {object} cidade elemento onde será atribuido as cidades
  * @author Rafael Domingues Teixeira
  */
  async function mudaCidade(estado,cidade){
    var options = "<option value='' selected>Selecione</option>";
    if(estado.val() !== "") {
      $.get(main_url + "findCidades/" + estado.val(), function (data) {
        $.each(data, function (index, element) {
          options += "<option value='" + element.id + "'>" + element.nome
           + "</option>";
        });

        cidade.empty(); //ZERA O CAMPO DE CIDADE
        cidade.append(options); //ADICIONA AS CIDADES DE ACORDO COM ESTADO
      });
    }

    cidade.empty();
    cidade.append(options); //ADICIONA AS CIDADES DE ACORDO COM ESTADO
  }


  /**
  * Habilita ou desabilita os bairros de caraguatatuba
  * conforme o estado e cidade selecionada.
  * Bairros habilitados somente quando valores de
  * cidade/estado forem 10500 e 35 respectivamente
  * @param {object} estado elemento do select do estado
  * @param {object} cidade elemento onde será atribuido as cidades
  * @author Rafael Domingues Teixeira
  */

  /**
  * Foi solicitado para deixar campo BAIRRO livre para digitação
  * @author Mayra Dantas Bueno
  */

  // function mudaBairro(estado,cidade){
  //   var divEndereco = estado.parents('div.endereco');
  //   divEndereco.find(".bairro-select").attr('disabled', 'disabled').hide();
  //   divEndereco.find(".bairro-input").removeAttr('disabled').show();
  //
  //   if((cidade.val() !== "")&&(estado.val() == '35')) {
  //     $.post(main_url + "findelements/Cidade/id/" + cidade.val(), function (dataCidade) {
  //       if(dataCidade == '3388'){
  //         divEndereco.find(".bairro-input").attr('disabled', 'disabled').hide();
  //         divEndereco.find(".bairro-select").removeAttr('disabled').show();
  //       }
  //     });
  //   }
  // }


});
