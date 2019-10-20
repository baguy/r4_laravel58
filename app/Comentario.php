<?php

namespace app;

use App\User;
use App\ComentarioAtualizacao;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model {

    use SoftDeletes;

  	protected $table    = 'comments';
    protected $fillable = array('text', 'user_id');

    public function user(){
      return $this->belongsTo('App\User');
    }

    public function comentarioAtualizacao(){
      return $this->hasMany('App\ComentarioAtualizacao');
    }

}
