<?php

namespace App;

use App\User;
use App\Profile;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model {

  use SoftDeletes;

  	protected $table    = 'tweets';
    protected $fillable = [
      'profile_id','text','followers_count','url',
      'friends_count','favourites_count','id_str',
      'retweet_count','retweet_status','posted_at','reply'
    ];

    public function profile(){
      return $this->belongsTo('App\Profile');
    }

    public function user(){
      return $this->belongsTo('App\User');
    }

}
