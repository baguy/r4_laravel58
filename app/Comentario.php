<?php

namespace app;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model {

    use SoftDeletes;

  	protected $table    = 'comments';
    protected $fillable = array('text', 'user_id');

    public function user(){
      return $this->belongsTo('User');
    }

    public function comentarioAtualizacao(){
      return $this->hasMany('ComentarioAtualizacao');
    }

}
