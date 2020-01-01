<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeEngagement extends Model {

    public $timestamps  = false;

  	protected $table    = 'types_engagement';
    protected $fillable = [
      'description','start_value','end_value'
    ];

}
