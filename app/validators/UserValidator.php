<?php

Class UserValidator {

	private static $attributes = [
    'name'                  => "Usuário",
    'email'                 => "E-mail",
    'password'              => "Senha",
    'password_confirmation' => "Confirmar Senha",
    'actual_password'       => "Senha Atual",
    'roles'                 => "Nível"
  ];

  private static $rules = [];

  private static $messages = [
    'password.regex' => "A senha deve conter letras, números e pelo menos um caracter especial!"
  ];

	public static function store($input) {

		self::$rules = [
			'name'  => "required|max:100",
			'email' => "required|max:100|email|unique:users",
			'password'
				=> "min:10|max:60|confirmed|regex:/^(?=(?:.*[a-zA-z]{1,}))(?=(?:.*[0-9]){1,})(?=(?:.*[!@#$%&*]){1,})(.{10,})$/",
		];

    $validator = Validator::make($input, self::$rules, self::$messages);

    $validator->setAttributeNames(self::$attributes);

		return $validator;
	}

  public static function update($input, $id) {

    self::$rules = [

    ];

    $validator = Validator::make($input, self::$rules, self::$messages);

    $validator->setAttributeNames(self::$attributes);

    return $validator;
  }

  public static function alterPassword($input, $id) {

    self::$rules = [
      'password'
        => "required|min:10|max:60|confirmed|regex:/^(?=(?:.*[a-zA-z]{1,}))(?=(?:.*[0-9]){1,})(?=(?:.*[!@#$%&*]){1,})(.{10,})$/",

      'password_confirmation'
        => "min:10|max:60|required_with:password",

      'actual_password'
        => "required|password_verify"
    ];

    self::$messages['actual_password.password_verify'] = "O campo :attribute está incorreto.";

    $validator = Validator::make($input, self::$rules, self::$messages);

    $validator->setAttributeNames(self::$attributes);

    return $validator;
  }
}
