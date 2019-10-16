<?php

namespace App\helpers;

class MainHelper {

	public static function fixArray($field, $originals) {

		$prepend = array('' => mb_strtoupper(Lang::get('application.form.select.empty', [ 'field' => $field ]), 'UTF-8'));

		return $prepend + $originals;
	}

	public static function getTable($model) {

		return mb_strtoupper(str_replace('_', ' ', $model->getTable()), 'UTF-8');
	}

	public static function printLog($exception) {

		Log::warning('Exception:', [ 'context' => Route::currentRouteName(), 'message' => $exception->getMessage() ]);
	}

	/**
	* Função estática - Trata array de dados da tabela p/ exibição em selects
	* @param array $array - array c/ valores da tabela
	* @param string $value - Valor do option do select
	* @param string $descri - Texto do option
	* @return array $newArray - Array c/ valores atribuidos
	* @author Rafael Domingues Teixeira
	*/
	public static function fixArray2($array,$value,$descri,$firstopt='Selecione',$descri2=null) {
		$newArray = array(''=>$firstopt);

		foreach ($array as $array) {
			if ($descri2!=null) {
				$newArray[$array[$value]] = "nome: " . $array[$descri]. ", {$descri2}: " . $array[$descri2];
			} else {
				$newArray[$array[$value]] = $array[$descri];
			}
		}
		return $newArray;
	}

	/**
	* Função estática - Busca valores de ENUM no banco de dados
	* @param table tabela do bd
	* @param column coluna configurada com valores ENUM
	* @return array valores ENUM de coluna no banco de dados
	* @author Ajay Gupta / Mayra Dantas Bueno
	*/
	public static function getEnumValues($table, $column) {
		$type = DB::select(DB::raw("SHOW COLUMNS FROM $table WHERE Field = '{$column}'"))[0]->Type ;
		preg_match('/^enum\((.*)\)$/', $type, $matches);
		$enum = array();
		foreach( explode(',', $matches[1]) as $value )
		{
			$v = trim( $value, "'" );
			$enum = array_add($enum, $v, $v);
		}
		return $enum;
	}

	/**
	* Função estática - Simula o 'LIKE' do MySql em php
	* @param string
	* @param string
	* @return boolean
	* @author Mayra Dantas Bueno
	*/
	function like($needle, $haystack)
	{
    $regex = '/' . str_replace('%', '.*?', $needle) . '/';

    return preg_match($regex, $haystack) > 0;
	}

}

?>
