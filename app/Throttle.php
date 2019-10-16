<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Throttle extends Model {

	protected $table    = 'throttles';

	protected $hidden   = array();

  protected $fillable = array(
  	'ip_address',
  	'is_default_password',
  	'last_access_at',
  	'attempts',
  	'last_attempt_at',
  	'suspended',
  	'user_id'
  );

  protected $guarded  = array();

  public $timestamps  = false;

  public function user() {
    return $this->belongsTo('User');
  }
}
