<?php

Class LaudoValidator {

	private static $attributes = [
    'produto_id'       => "Produto",
    'referencia' 			 => "Referência",
    'tipo_reagente_id' => "Reagente",
    'descricao'  			 => "Descrição",
		'user_id'		 			 => "Responsável",
		'validade'				 => 'Validade'
  ];

  private static $rules = [
    'produto_id'       => "required",
    'referencia'       => "required",
    'tipo_reagente_id' => "required",
		'user_id'					 => "required",
		'validade'				 => "date_format:d/m/Y|after:yesterday"
  ];

  private static $messages = [];

	public static function store($input) {

    $validator = Validator::make($input, self::$rules, self::$messages);

    $validator->setAttributeNames(self::$attributes);

		return $validator;
	}

  public static function update($input, $id) {

    $validator = Validator::make($input, self::$rules, self::$messages);

    $validator->setAttributeNames(self::$attributes);

    return $validator;
  }
}
