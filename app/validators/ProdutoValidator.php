<?php

Class ProdutoValidator {

	private static $attributes = [
    'nome'     => "Nome",
    'lote'     => "Lote",
    'validade' => "Validade"
  ];

  private static $rules    = [
    'nome'     => "required",
    'lote'     => "required",
    'validade' => "required|date_format:d/m/Y|after:today"
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
