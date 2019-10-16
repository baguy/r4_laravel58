<?php

Class UnidadeValidator {

	private static $attributes = [
    'nome' => "Nome",
		'email' => "Email"
  ];

  private static $rules    = [];

  private static $messages = [];

	public static function store($input) {

		self::$rules = [
      'nome' => "required|min:3",
			'email' => "email"
		];

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
