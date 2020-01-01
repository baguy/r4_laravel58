<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TypeProfileStatus;

class TypeProfile extends Model {

    public $timestamps  = false;

  	protected $table    = 'types_profile';
    protected $fillable = [
      'name','description','recomendation','requisites'
    ];

    public function typeProfileStatus(){
      return $this->hasOne('App\TypeProfileStatus');
    }

}
