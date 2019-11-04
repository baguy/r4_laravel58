<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TypeProfile;
use App\Profile;

class TypeProfileStatus extends Model {

  	protected $table    = 'type_profile_status';
    protected $fillable = [
      'profile_id','type_profile_id'
    ];

    public function typeProfile(){
      return $this->belongsTo('App\TypeProfile');
    }

    public function profile(){
      return $this->belongsTo('App\Profile')
    }

}
