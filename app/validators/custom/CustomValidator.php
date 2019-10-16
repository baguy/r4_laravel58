<?php

class CustomValidator extends Illuminate\Validation\Validator {

  public function validateAlphaSpaces($attribute, $value, $parameters) {
    
    return preg_match('/^[\pL\s]+$/u', $value);
  }

  public function validateArrayFull($attribute, $value, $parameters) {

    $is_full = (in_array('', $value)) ? false : true;
      
    return $is_full;
  }

  public function validateArrayUnique($attribute, $value, $parameters) {
    
    return count($value) == count(array_unique($value));
  }

  public function validateArrayNumeric($attribute, $value, $parameters) {
    
    $numeric_values = array_filter($value, create_function('$item', 'return (is_numeric($item));'));
      
    return count($numeric_values) == count($value);
  }

  public function validatePasswordVerify($attribute, $value, $parameters) {
    
    return Hash::check($value, Auth::user()->getAuthPassword());
  }

  public function validateDatePtBr($attribute, $value, $parameters) {
    
    $data = explode("/", $value);
    $d = $data[0];
    $m = $data[1];
    $y = $data[2];
    
    if($y < (date("Y") - 100))
        
      return false;

    // verifica se a data é válida!
    $res = checkdate($m, $d, $y);
    
    // 1 = true (válida)
    if ($res == 1)
        
      return true;
        
    // 0 = false (inválida)    
    else

      return false;
  }

  public function validateCpf($attribute, $value, $parameters) {
    
    // Filtra o CPF (apenas numeros), isso permite receber o CPF em diferentes formatos
    // Ex.: "000.000.000-00", "00000000000", "000 000 000 00"
    $cpf = preg_replace('/\D/', '', $value);
    
    // Cria um array com os valores
    $num = array();
    
    for ($i = 0; $i < (strlen($cpf)); $i++)

      $num[] = $cpf[$i];


    
    if (count($num) !== 11)
        
      return false;
        
    else
        
      // Limpando combinações como 00000000000, 11111111111, ...
      for ($i = 0; $i < 10; $i++)

        if (
          $num[0] == $i && $num[1] == $i && $num[2] == $i && $num[3] == $i && $num[4] == $i && 
          $num[5] == $i && $num[6] == $i && $num[7] == $i && $num[8] == $i && $num[9] == $i && $num[10] == $i
        )

          return false;


    
    // Calcula e compara o primeiro dígito verificador
    $j = 10;
    
    for ($i = 0; $i < 9; $i++) {
        
      $multiplica[$i] = $num[$i] * $j;

      $j--;
    }
    
    $soma_01 = array_sum($multiplica);
    
    $resto_01 = $soma_01 % 11;

    
    
    if ($resto_01 < 2)
        
      $dg = 0;
        
    else
        
      $dg = 11 - $resto_01;


    
    if ($dg != $num[9])
        
      return false;
    
    // Calcula e compara o segundo dígito verificador
    $z = 11;
    
    for ($i = 0; $i < 10; $i++) {
        
      $multiplica[$i] = $num[$i] * $z;

      $z--;
    }
    
    $soma_02 = array_sum($multiplica);
    
    $resto_02 = $soma_02 % 11;


    
    if ($resto_02 < 2)
        
      $dg = 0;
        
    else
        
      $dg = 11 - $resto_02;


    
    if ($dg != $num[10])
        
      return false;
        
    else
        
      return true;
  }
}