<?php

namespace App\helpers;

class FormatterHelper {

  public static function filter($inputs, $fields = array(), $case = 'strtoupper', $replace = true) {

    foreach ($fields as $key => $field){

      if (array_key_exists($field, $inputs)) {

        $replaced = $inputs[$field];

        if ($replace)

          $replaced = str_replace(
            array("à", "á", "â", "ã", "ä", "è", "é", "ê", "ë", "ì", "í", "î", "ï", "ò", "ó", "ô", "õ", "ö", "ù", "ú", "û", "ü", "À", "Á", "Â", "Ã", "Ä", "È", "É", "Ê", "Ë", "Ì", "Í", "Î", "Ï", "Ò", "Ó", "Ô", "Õ", "Ö", "Ù", "Ú", "Û", "Ü", "ç", "Ç", "ñ", "Ñ", "`", "´", "^", "~", "¨"),
            array("a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "c", "C", "n", "N", "", "", "", "", ""),
            $replaced
          );

        switch ($case) {

          case 'strtoupper':
            $inputs[$field] = mb_strtoupper($replaced, 'UTF-8');
            break;

          case 'strtolower':
            $inputs[$field] = mb_strtolower($replaced, 'UTF-8');
            break;

          default:
            $inputs[$field] = $replaced;
            break;
        }
      }
    }

    return $inputs;
  }

  public static function dateToPtBR($date) {

    $result = new DateTime($date);

    return $result->format("d/m/Y");
  }

  public static function dateTimeToPtBR($datetime) {

    $result = new DateTime($datetime);

    return $result->format("d/m/Y H:i:s");
  }

  public static function dateToMySQL($date) {

    $result = explode("/", $date);

    return "{$result[2]}-{$result[1]}-{$result[0]}";
  }

  public static function dateToWeekday($date) {

    $result = explode("/", $date);

    //                                         $mes,       $dia,       $ano
    $dia_da_semana = date("w", mktime(0, 0, 0, $result[1], $result[0], $result[2]));

    switch ($dia_da_semana) {

      case"0": $dia_da_semana = "DOM";
          break;
      case"1": $dia_da_semana = "SEG";
          break;
      case"2": $dia_da_semana = "TER";
          break;
      case"3": $dia_da_semana = "QUA";
          break;
      case"4": $dia_da_semana = "QUI";
          break;
      case"5": $dia_da_semana = "SEX";
          break;
      case"6": $dia_da_semana = "SAB";
          break;
    }

    return $dia_da_semana;
  }

  public static function dateInFull() {

    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

    date_default_timezone_set('America/Sao_Paulo');

    return strftime('%d de %B de %Y', strtotime('today')); // strftime('%A, %d de %B de %Y', strtotime('today'));
  }

  public static function mask($mask, $str) {

    $str = str_replace(" ", "", $str);

    for($i = 0; $i < strlen($str); $i++) {

      $mask[strpos($mask, "#")] = $str[$i];
    }

    return $mask;
  }

  public static function somenteNumeros($data) {
    return preg_replace("/[^0-9]+/", "", $data);
  }


  public static function somenteAssinatura($data) {
    $data = strtolower($data);
    return preg_replace("/[^a-z0-9]+/", "", $data);
  }
}
