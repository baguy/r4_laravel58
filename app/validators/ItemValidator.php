<?php

Class ItemValidator {

	private static $attributes = [
    'descricao'       => "Descrição", 
    'especificacao'   => "Especificação", 
    'tipo'            => "Tipo", 
    'categoria_id'    => "Categoria", 
    'subcategoria_id' => "Subcategoria", 
    'unidade_id'      => "Unidade"
  ];

  private static $rules    = [
    'descricao'       => "required|max:255|unique:itens", 
    'especificacao'   => "required", 
    'tipo'            => "required|in:BENS DE CONSUMO,BENS PERMANENTES,SERVIÇOS", 
    'categoria_id'    => "required", 
    'subcategoria_id' => "required", 
    'unidade_id'      => "required"
  ];

  private static $messages = [];
	
	public static function store($input) {

    $validator = Validator::make($input, self::$rules, self::$messages);

    $validator->setAttributeNames(self::$attributes);

		return $validator;
	}

  public static function update($input, $id) {

    self::$rules['descricao'] = "required|max:255|unique:itens,descricao,$id";

    $validator = Validator::make($input, self::$rules, self::$messages);

    $validator->setAttributeNames(self::$attributes);

    return $validator;
  }
}