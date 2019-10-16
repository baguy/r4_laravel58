<?php

Class ModeloValidator {

	private static $attributes = [
    'nome'  => "Nome", 
    'texto' => "Texto"
  ];

  private static $rules    = [
    'nome'  => "required|max:45|unique:modelos",
    'texto' => "required"
  ];

  private static $messages = [];
	
	public static function store($input) {

    $validator = Validator::make($input, self::$rules, self::$messages);

    $validator->setAttributeNames(self::$attributes);

		return $validator;
	}

  public static function update($input, $id) {

    self::$rules['nome'] = "required|max:45|unique:modelos,nome,$id";

    $validator = Validator::make($input, self::$rules, self::$messages);

    $validator->setAttributeNames(self::$attributes);

    return $validator;
  }
}