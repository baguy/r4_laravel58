function examePredefinido(objeto){

  var valor = objeto.value;
  var exames = document.getElementsByClassName('exame');
  var amostras = document.getElementsByClassName('amostra');
  console.log(amostras);

  if(objeto.className == 'exame_predefinido_0'){
    exames[0].checked = true;  amostras[0].style.display = 'block';
    exames[1].checked = true;  amostras[1].style.display = 'block';
    exames[6].checked = true;  amostras[6].style.display = 'block';
    exames[8].checked = true;  amostras[8].style.display = 'block';
    exames[9].checked = true;  amostras[9].style.display = 'block';
    exames[16].checked = true; amostras[16].style.display = 'block';
  }
  if(objeto.className == 'exame_predefinido_1'){
    exames[0].checked = true;  amostras[0].style.display = 'block';
    exames[1].checked = true;  amostras[1].style.display = 'block';
    exames[6].checked = true;  amostras[6].style.display = 'block';
    exames[7].checked = true;  amostras[7].style.display = 'block';
  }

}
