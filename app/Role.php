<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {

	protected $table     = 'roles';

	public $timestamps   = false;

	protected $guarded   = array();

	public static $rules = array(
		'name'        => 'required|max:45|unique:roles',
		'description' => 'required|max:100'
	);

	public function users() {
    return $this->belongsToMany('User', 'users_roles');
  }
}
