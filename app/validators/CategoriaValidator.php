<?php

Class CategoriaValidator {

	private static $attributes = [
    'nome' => "Nome"
  ];

  private static $rules    = [];

  private static $messages = [];
	
	public static function store($input) {

		self::$rules = [
      'nome' => "required|max:100|unique:categorias"
		];

    $validator = Validator::make($input, self::$rules, self::$messages);

    $validator->setAttributeNames(self::$attributes);

		return $validator;
	}

  public static function update($input, $id) {

    self::$rules = [
      'nome' => "required|max:100|unique:categorias,nome,$id"
    ];

    $validator = Validator::make($input, self::$rules, self::$messages);

    $validator->setAttributeNames(self::$attributes);

    return $validator;
  }
}