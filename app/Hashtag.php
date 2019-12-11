<?php

namespace App;

use App\User;
use App\Profile;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Hashtag extends Model {

  use SoftDeletes;

  	protected $table    = 'hashtags';
    protected $fillable = [
      'profile_id','tweet_id','hashtag'
    ];

    public function profile(){
      return $this->belongsTo('App\Profile');
    }

    public function tweet(){
      return $this->belongsTo('App\Tweet');
    }

}
