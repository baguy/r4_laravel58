<?php

namespace App\Http\Services;

use App\Http\Services\BaseService;
use App\User;
use App\Tweet;
use App\profileAtualizacao;
use App\Http\AuthController;
use App\helpers\MainHelper;
use DB;
use Auth;

class ProfileService extends BaseService {

	protected $profile;

  public function __construct(Tweet $tweet) {

    $this->tweet = $tweet;
  }

  public function selects($is_filter = false) {

  }

  public static function store($t,$v0) {

  	DB::beginTransaction();

    try {

			$profile 							= new Profile($t[0]);

			$profile->screen_name = $t[0]['user']->screen_name;
			$profile->name 				= $t[0]['user']->name;
			$profile->verified 		= ($t[0]['user']['verified']->verified==true)?1:0;
			$profile->twitter_id 	= $t[0]['user']->id_str;

			$profile->user()->associate(Auth::user())->save();

			foreach($timeline as $key => $value){
      	$tweet = new Tweet($value);

				$tweet->profile_id = $profile->id;
				$tweet->text = $value['text'];
				$tweet->followers_count = $value['user']->followers_count;
				$tweet->friends_count = $value['user']->friends_count;
				$tweet->favorites_count = $value->favorite_count;
				$tweet->retweet_count = $value->retweet_count;
				$tweet->retweet_status = isset($value->retweeted_status)?1:0;

				if($value->id_str == $v0){
					$tweet->badalado = 1;
				}

      	$tweet->user()->associate(Auth::user())->save();
			}

      DB::commit();

    } catch (Exception $e) {

      MainHelper::printLog($e);

      DB::rollback();

      throw $e;
    }
  }

  public function update($input, $id) {

  	DB::beginTransaction();

    try {

      $profile = $this->profile->find($id);

			$old_comment = new profileAtualizacao();

			$old_comment->text = $profile->text;

			$old_comment->profile()->associate($profile)->save();

      $profile->fill($input);

      $profile->update();

      DB::commit();

    } catch (Exception $e) {

      MainHelper::printLog($e);

      DB::rollback();

      throw $e;
    }
  }

  public function destroy($id) {

    DB::beginTransaction();

    try {

      DB::commit();

    } catch (Exception $e) {

      MainHelper::printLog($e);

      DB::rollback();

      throw $e;
    }
  }

  public function restore($id) {

    DB::beginTransaction();

    try {

      DB::commit();

    } catch (Exception $e) {

      MainHelper::printLog($e);

      DB::rollback();

      throw $e;
    }
  }

}
