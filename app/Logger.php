<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logger extends Model {

  protected $table    = 'loggers';

  protected $fillable = array('action', 'message', 'user_id', 'created_at');

  public $timestamps  = false;

  public function user() {
    return $this->belongsTo('User')->withTrashed();
  }

}
