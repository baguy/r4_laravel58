<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Profile;

class Tweet extends Model {

  use SoftDeletes;

  	protected $table    = 'tweets';
    protected $fillable = [
      'profile_id','text','followers_count',
      'friends_count','favourites_count',
      'retweet_count','retweet_status'
    ];

    public function profile(){
      return $this->belongsTo('App\Profile');
    }

}
