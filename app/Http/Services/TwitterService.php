<?php

namespace App\Http\Services;

use DB;
use Auth;
use App\User;
use App\Tweet;
use App\Profile;
use App\Hashtag;
use App\profileAtualizacao;
use App\Http\AuthController;
use App\helpers\MainHelper;
use App\Http\Services\BaseService;

class TwitterService extends BaseService {

	protected $profile;

  public function __construct(Tweet $tweet) {

    $this->tweet = $tweet;
  }

  public function selects($is_filter = false) {

  }

  public static function store($timeline,$perfil,$verified,$v0,$username,$engajamento) {

  	DB::beginTransaction();

    try {

			$profile        = Profile::where('screen_name','=',$username)->first();

			if(!isset($profile)){

				$profile 							= new Profile($perfil);

				$profile->screen_name 		= $perfil['screen_name'];
				$profile->name 						= $perfil['name'];
				$profile->verified 				= ($verified==true)?1:0;
				$profile->twitter_id 			= $perfil['twitter_id'];
				$profile->followers_count = $perfil['followers_count'];
				$profile->friends_count   = $perfil['friends_count'];
				$profile->engagement			= $engajamento;

				$profile->user()->associate(Auth::user())->save();

			}else{
				$profile->verified 				= ($verified==true)?1:0;
				$profile->followers_count = $perfil['followers_count'];
				$profile->friends_count   = $perfil['friends_count'];
				$profile->engagement			= $engajamento;

				$profile->update();
			}

			foreach($timeline as $key => $value){

				$t =	Tweet::where('id_str','=',$value['id_str'])->first();

				if(!isset($t['id_str'])){

	      	$tweet = new Tweet($value);

					$tweet->text 						= $value['full_text'];
					$tweet->followers_count = $value['user']['followers_count'];
					$tweet->friends_count 	= $value['user']['friends_count'];
					$tweet->favorite_count  = $value['favorite_count'];
					$tweet->retweet_count 	= $value['retweet_count'];
					$tweet->reply					  = $value['in_reply_to_user_id_str'];
					$tweet->posted_at				= $value['created_at'];
					$tweet->retweet_status  = isset($value['retweeted_status'])?1:0;
					$tweet->id_str					= $value['id_str'];
					$tweet->url 						= "https://twitter.com/".$username."/status"."/".$value['id_str'];

					if($value['id_str'] == $v0){
						$tweet->badalado = 1;
					}

	      	$tweet->profile()->associate($profile)->save();

					if(!empty($value['entities']['hashtags'])){

						foreach($value['entities']['hashtags'] as $v){

								$hashtag = new Hashtag();

								$hashtag->hashtag  = $v['text'];
								$hashtag->tweet_id = $tweet->id;

								$hashtag->profile()->associate($profile)->save();

						}

					}

				}else{

					$t->followers_count = $value['user']['followers_count'];
					$t->friends_count 	= $value['user']['friends_count'];
					$t->favorite_count  = $value['favorite_count'];
					$t->retweet_count 	= $value['retweet_count'];

					$t->update();

				} // .if isset

			} //.foreach

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
