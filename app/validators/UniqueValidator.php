<?php

class UniqueValidator {

  private static $rules = [];

  private static $messages = [];
	
	public static function validate($input, $table, $field, $id) {

		self::$rules = [
			"$field" => "unique:$table,$field,$id,id"
		];

		if (count($input) > 1) {

			$parameters = array_filter($input, function($k) use($field) { return $k !== $field; }, ARRAY_FILTER_USE_KEY);

			$extras = implode(',', array_map(function ($v, $k) { 

	    		return sprintf("%s,%s", $k, $v);

	    	}, $parameters, array_keys($parameters)
			));

			self::$rules = [
				"$field" => "unique:$table,$field,$id,id,$extras"
			];
		}

    $validator = Validator::make($input, self::$rules, self::$messages);

		return $validator;
	}
}

?>