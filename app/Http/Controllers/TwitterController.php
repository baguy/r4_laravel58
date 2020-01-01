<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Services\TwitterService;
use App\TypeEngagement;
use App\TypeProfile;
use App\Profile;
use App\Tweet;
use Twitter;
use File;
use Input;
use DB;


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

  	return view('main.show-result',compact('timeline','friends','media','username','verified'));

  }


  /**
     * Uses Twitter API to query data from informed @username.
     * Returns more info than newQuery()
     * @return view
     */

  public function postQuery()
  {

    $input = Input::all();

    // RETIRAR @ DO USERNAME (se houver)
    $exploded = explode("@", $input['username']);
    if(isset($exploded[1])){
      $username = $exploded[1];
    }else{
      $username = $exploded[0];
    }

    // QUANTIDADE DE TWEETS ANALISADOS
    $quantidade = 50;

    try {
      // REQUISIÇÃO DA TIMELINE DO USUÁRIO PESQUISADO
      $timeline = Twitter::getUserTimeline(['screen_name' => $input['username'], 'count' => $quantidade, 'format' => 'array', 'tweet_mode' => 'extended']);

      // return $timeline;

      if(isset($timeline)){

        // DADOS DO PERFIL
        $contagem = 0; $retweet  = 0; $favoritos  = 0; $media   = [];
        $seguidores = 0; $verified = false; $soma = 0; $vetor_soma = [];
        $perfil = []; $urls = []; $friends_num = 0; $links = 0; $midia = 0;
         $mention = 0; $retweeted = 0; $reply = 0; $caracteristicas = [];
        foreach($timeline as $key => $value){
          $contagem  += 1;
          $retweet   += $value['retweet_count'];
          $favoritos += $value['favorite_count'];

          $soma = $value['retweet_count'] + $value['favorite_count'];
          $vetor_id[$key]         = $value['id_str'];
          $vetor_soma[$key]       = $soma;

          $perfil['screen_name']     = $value['user']['screen_name'];
          $perfil['name']            = $value['user']['name'];
          $perfil['twitter_id']      = $value['user']['id_str'];
          $seguidores                = $value['user']['followers_count'];
          $perfil['followers_count'] = $value['user']['followers_count'];
          $perfil['friends_count']   = $value['user']['friends_count'];

          $friends_num = $value['user']['friends_count'];

          if($value['user']['verified'] == true){
            $verified = true;
          }

          foreach($value['entities']['urls'] as $key_link => $value_link){
            if(isset($value_link['url']) && $value_link['url'] != ""){
              $links += 1;
            }
          }
          foreach($value['entities']['user_mentions'] as $key_mention => $value_mention){
            if(isset($value_link['screen_name']) && $value_link['screen_name'] != ""){
              $mention += 1;
            }
          }
          if(isset($value['extended_entities'])){
            $midia += 1;
          }
          if(isset($value['retweeted_status']) && $value['retweeted_status'] != ""){
            $retweeted += 1;
          }
          if($value['in_reply_to_user_id'] != "" && $value['in_reply_to_user_id'] != null){
            $reply += 1;
          }
        }

        // MÉDIAS
        $media['retweet']   = $retweet / $contagem;
        $media['favoritos'] = $favoritos / $contagem;
        $engagement = $media['retweet'] + $media['favoritos'];

        // VETOR DE IDs ORGANIZADOS POR BADALAÇÃO (retweet + favoritos)
        $vetor = [];
        $vetor = TwitterController::bubbleSort($vetor_soma,$vetor_id);

        $v = [];
        $v = array_slice($vetor[1], 0, 5);

        // TOP 5
        $v0 = $v[0]; $v1 = $v[1]; $v2 = $v[2];
        $v3 = $v[3]; $v4 = $v[4];

        // TIPOS DE PERFIL
        // ~~ Animal político ~~
        $animal_politico = 0;
        $p_reply = ($reply / $quantidade) * 100;
        if( $p_reply >= 30 ){
          $animal_politico = TypeProfile::find(3);
          $caracteristicas[0] = $animal_politico;
        }
        // ~~ Biscoiteiro ~~
        $biscoiteiro = 0;
        $p_midia = ($midia / $quantidade) * 100;
        if( $p_midia >= 40 ){
          $biscoiteiro = TypeProfile::find(5);
          $caracteristicas[1] = $biscoiteiro;
        }
        // ~~ Feirante ~~
        $feirante = 0;
        $p_link = ($links / $quantidade) * 100;
        if( $p_link >= 25 ){
          $feirante = TypeProfile::find(6);
          $caracteristicas[2] = $feirante;
        }
        // Lavoisier
        $lavoisier = 0;
        $p_retweet = ($retweeted / $quantidade) * 100;
        if( $p_retweet >= 25 ){
          $lavoisier = TypeProfile::find(8);
          $caracteristicas[3] = $lavoisier;
        }

        // ENGAJAMENTO
        $types_engagement = TypeEngagement::all(); $nivel_engajamento = TypeEngagement::find(1);
        foreach($types_engagement as $key => $value){
          if(($engagement >= $value['end_value']) && ($engagement <= $value['start_value'])){
            $nivel_engajamento = TypeEngagement::find($value['id']);
          }
        }

        // PEGAR DADOS JÁ SALVOS (se houver) PARA COMPARAR APÓS SALVAR
        $at_pre     = Profile::where('screen_name','=',$username)->first();

        // SALVAR DADOS
        TwitterService::store($timeline,$perfil,$verified,$v0,$username,$engagement);

        // PEGAR DADOS APÓS SEREM SALVOS
        $at_pos     = Profile::where('screen_name','=',$username)->first();
        if($at_pos != ""){
          $badalados = Tweet::where('profile_id','=',$at_pos->id)->where('badalado','=',1)->get();
        }else{
          return back()->with('_error', trans('application.msg.error.at'));
        }

        // COMPARAÇÃO DE SEGUIDORES E ENGAJAMENTO
        $followers_pill_color = 'badge-primary';$followers_comparison = 0;$followers_sign = null;
        $engagement_pill_color = 'badge-primary';$engagement_comparison = 0;$engagement_sign = null;
        if(isset($at_pre) && isset($at_pos)){
          $followers_comparison = $at_pre['followers_count'] - $at_pos['followers_count'];
          if($followers_comparison > 0){
            $followers_pill_color = 'badge-danger';
          }elseif($followers_comparison < 0){
            $followers_pill_color = 'badge-success';
            $followers_comparison = abs($followers_comparison);
          }
          if($followers_pill_color == 'badge-danger'){
            $followers_sign = "<i class='fas fa-minus'></i>";
          }else{
            $followers_sign = "<i class='fas fa-plus'></i>";
          }

          $engagement_comparison = $at_pre['engagement'] - $at_pos['engagement'];
          if($engagement_comparison > 0){
            $engagement_pill_color = 'badge-danger';
          }elseif($engagement_comparison < 0){
            $engagement_pill_color = 'badge-success';
            $engagement_comparison = abs($engagement_comparison);
          }
          if($engagement_pill_color == 'badge-danger'){
            $engagement_sign = "<i class='fas fa-minus'></i>";
          }else{
            $engagement_sign = "<i class='fas fa-plus'></i>";
          }
        }

        // "Friends" VERIFICADOS DO USUÁRIO PESQUISADO
        $friends = Twitter::getFriends([ 'screen_name' => $input['username'], 'format' => 'array' ]);

        $friends_verified = 0;
        if(isset($friends)){
          foreach($friends['users'] as $key_friends => $value_friends){
            if($value_friends['verified'] == true){
              $friends_verified += 1;
            }
          }
        }

        // Rate-limit (Standard API) — 15m — https://developer.twitter.com/en/docs/basics/rate-limits

        return view('main.show_post-result',compact(
                                                'timeline','friends','media','username','engagement',
                                                'verified','v0','v1','v2','v3','v4', 'followers_pill_color',
                                                'quantidade','badalados','at_pre','followers_comparison',
                                                'engagement_comparison','engagement_pill_color','seguidores',
                                                'engagement_sign','followers_sign','friends_num','friends_verified',
                                                'caracteristicas','nivel_engajamento'
                                              ));

      }

    } catch (Exception $e) {

        Session::flash('_old_input', Input::all());

        return back()->with('_error', trans('application.msg.error.something-went-wrong'));
      }

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
