<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Services\TwitterService;
use Twitter;
use File;
use Input;


class TwitterController extends Controller

{

  /**
     * Uses Twitter API to query data from informed @username.
     *
     * @return view
     */

  public function newQuery()
  {

    $input = Input::all();
    $username = $input['username'];

    $timeline = Twitter::getUserTimeline(['screen_name' => $input['username'], 'count' => 10, 'format' => 'array']);
    $friends = Twitter::getFriends([ 'screen_name' => $input['username'], 'format' => 'array' ]);

    $contagem = 0; $retweet = 0; $favoritos = 0; $media = []; $verified = false;
    foreach($timeline as $key => $value){
      $contagem  += 1;
      $retweet   += $value['retweet_count'];
      $favoritos += $value['favorite_count'];
      if($value['user']['verified'] == true){
        $verified = true;
      }
    }

    $media['retweet']   = $value['retweet_count'] / $contagem;
    $media['favoritos'] = $value['favorite_count'] / $contagem;

    // Rate-limit (Standard API) — 15m — https://developer.twitter.com/en/docs/basics/rate-limits

  	return view('main.show_post-result',compact('timeline','friends','media','username','verified'));

  }


  /**
     * Uses Twitter API to query data from informed @username.
     * Returns more info than newQuery()
     * @return view
     */

  public function postQuery()
  {

    $input = Input::all();
    $username = $input['username'];

    $quantidade = 20;

    $timeline = Twitter::getUserTimeline(['screen_name' => $input['username'], 'count' => $quantidade, 'format' => 'array']);
    $friends = Twitter::getFriends([ 'screen_name' => $input['username'], 'format' => 'array' ]);

    $contagem = 0; $retweet = 0; $favoritos = 0; $media = [];
    $verified = false; $soma = 0; $vetor_soma = [];
    foreach($timeline as $key => $value){
      $contagem  += 1;
      $retweet   += $value['retweet_count'];
      $favoritos += $value['favorite_count'];

      $soma = $value['retweet_count'] + $value['favorite_count'];
      $vetor_id[$key]         = $value['id_str'];
      $vetor_soma[$key]       = $soma;

      if($value['user']['verified'] == true){
        $verified = true;
      }
    }

    $media['retweet']   = $value['retweet_count'] / $contagem;
    $media['favoritos'] = $value['favorite_count'] / $contagem;

    $vetor = [];
    $vetor = TwitterController::bubbleSort($vetor_soma,$vetor_id);

    $v = [];
    $v = array_slice($vetor[1], 0, 5);

    $v0 = $v[0]; $v1 = $v[1]; $v2 = $v[2];
    $v3 = $v[3]; $v4 = $v[4];

    TwitterService::store($timeline,$v0);

    // Rate-limit (Standard API) — 15m — https://developer.twitter.com/en/docs/basics/rate-limits

    return view('main.show_post-result',compact(
                                            'timeline','friends','media','username',
                                            'verified','v0','v1','v2','v3','v4',
                                            'quantidade'
                                          ));

  }


  function bubbleSort($array1,$array2)
  {
    for($i = 0; $i < count($array1); $i++)
    {
       for($j = 0; $j < count($array1) - 1; $j++)
       {
         if($array1[$j] < $array1[$j + 1])
         {
           $aux = $array1[$j];
           $array1[$j] = $array1[$j + 1];
           $array1[$j + 1] = $aux;

           $aux2 = $array2[$j];
           $array2[$j] = $array2[$j + 1];
           $array2[$j + 1] = $aux2;
         }
       }
    }
    $array = [];
    // $array[0] = $array1;
    $array[1] = $array2;
    return $array;
  }


	/**

     * Create a new controller instance.

     *

     * @return void

     */

    public function twitterUserTimeLine()

    {

    	$data = Twitter::getUserTimeline(['count' => 10, 'format' => 'array']);

    	return view('twitter',compact('data'));

    }


    /**

     * Create a new controller instance.

     *

     * @return void

     */

    public function tweet(Request $request)

    {

    	$this->validate($request, [

        		'tweet' => 'required'

        	]);


    	$newTwitte = ['status' => $request->tweet];




    	if(!empty($request->images)){

    		foreach ($request->images as $key => $value) {

    			$uploaded_media = Twitter::uploadMedia(['media' => File::get($value->getRealPath())]);

    			if(!empty($uploaded_media)){

                    $newTwitte['media_ids'][$uploaded_media->media_id_string] = $uploaded_media->media_id_string;

                }

    		}

    	}


    	$twitter = Twitter::postTweet($newTwitte);




    	return back();

    }

}
