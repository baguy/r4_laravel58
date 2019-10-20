<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Comentario;

class ComentarioAtualizacao extends Model {

  use SoftDeletes;

  	protected $table    = 'comments_updates';
    protected $fillable = array('comment_id','text');

    public function comentario(){
      return $this->belongsTo('App\Comentario','comment_id','id');
    }

}
