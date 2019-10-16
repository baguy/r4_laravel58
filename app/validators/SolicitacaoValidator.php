<?php

Class SolicitacaoValidator {

	private static $attributes = [
    'nome'        => "Nome",
    'data_coleta' => "Data coleta",
    'medico'      => "Nome médico",
    'sus'         => "Cartão sus",
    'contato1'    => "Telefone primário",
    'logradouro'  => "logradouro",
    'numero'      => "Numero",
		'unidade_id'  => "Unidade",
    'data_nascimento' => "Data de nascimento",
		'num_solicitacao'	=> 'Número da solicitação'
  ];

  private static $rules    = [];

	public static function store($input) {

		self::$rules = [
			'nome'            => "required|max:255",
	    'data_coleta'     => "required|date_format:d/m/Y",
	    'medico'          => "required|max:255",
	    'contato1'        => "required",
	    'logradouro'      => "required",
	    'unidade_id'      => "required",
	    'numero'          => 'required',
	    'data_nascimento' => "required|date_format:d/m/Y|before:today",
			'num_solicitacao'	=> 'required|integer|unique:solicitacoes,numero'
		];

		$validator = Validator::make($input, self::$rules, self::$messages);

		$validator->setAttributeNames(self::$attributes);

		return $validator;
	}

	public static function update($input,$id) {

		self::$rules = [
			'nome'            => "required|max:255",
			'data_coleta'     => "required|date_format:d/m/Y",
			'medico'          => "required|max:255",
			'contato1'        => "required",
			'logradouro'      => "required",
			'unidade_id'      => "required",
			'numero'          => 'required',
			'data_nascimento' => "required|date_format:d/m/Y|before:today",
			'num_solicitacao'	=> "required|integer|unique:solicitacoes,numero,$id"
		];

		$validator = Validator::make($input, self::$rules, self::$messages);

		$validator->setAttributeNames(self::$attributes);

		return $validator;
	}

  private static $messages = ['num_solicitacao.unique' => 'Número de solicitação já cadastrado'];

}
