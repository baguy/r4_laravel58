<?php

namespace app;

use App\User;
use App\Tweet;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model {

    use SoftDeletes;

  	protected $table    = 'profiles';
    protected $fillable = [
      'screen_name', 'user_id', 'name',
      'verified', 'twitter_id'
    ];

    public function user(){
      return $this->belongsTo('App\User');
    }

    public function tweets(){
      return $this->hasMany('App\Tweet');
    }

}
