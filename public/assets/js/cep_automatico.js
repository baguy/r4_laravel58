/**
* Funções para preencher endereço automaticamente a partir do cep —
* @author Mayra Dantas Bueno / VIACEP
*/

function meu_callback(conteudo) {
;    if (!("erro" in conteudo)) {
        //Atualiza os campos com os valores.
        document.getElementById('estado').value=(conteudo.uf);
        document.getElementById('logradouro').value=(conteudo.logradouro);
        document.getElementById('cidade').value=(conteudo.localidade).toUpperCase();
        document.getElementById('bairro').value=(conteudo.bairro).toUpperCase();
        setTimeout(function(){
          $('#cidade option:contains('+(conteudo.localidade).toUpperCase()+')').prop('selected', 'true')
        }, 1000);
    }
}

function sleep(milliseconds) {
    var start = new Date().getTime();
    for (var i = 0; i < 1e7; i++) {
        if ((new Date().getTime() - start) > milliseconds){
            break;
        }
    }
}

function pesquisacep(valor) {

    //Nova variável "cep" somente com dígitos.
    var cep = valor.replace(/\D/g, '');

    //Verifica se campo cep possui valor informado.
    if (cep != "") {

        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;

        //Valida o formato do CEP.
        if(validacep.test(cep)) {

            //Preenche os campos com "..." enquanto consulta webservice.
            document.getElementById('logradouro').value="...";
            document.getElementById('bairro').value="...";
            document.getElementById('cidade').value="...";
            document.getElementById('estado').value="...";

            //Cria um elemento javascript.
            var script = document.createElement('script');

            //Sincroniza com o callback — VIACEP
            script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

            //Insere script no documento e carrega o conteúdo.
            document.body.appendChild(script);

        } //end if.
    }

};
