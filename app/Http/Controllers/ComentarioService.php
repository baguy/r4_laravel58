<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseService;
use App\User;
use App\Comentario;
use App\Http\AuthController;
use App\helpers\MainHelper;

class ComentarioService extends BaseService {

	protected $comentario;

  public function __construct(Comentario $comentario) {

    $this->comentario = $comentario;
  }

  public function selects($is_filter = false) {

  }

  public static function store($input) {

  	DB::beginTransaction();

    try {

      $comment = new Comentario($input);

      $comment->user()->associate(Auth::user())->save();

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

      $comentario = $this->comentario->find($id);

			$old_comment = new ComentarioAtualizacao();

			$old_comment->text = $comentario->text;

			$old_comment->comentario()->associate($comentario)->save();

      $comentario->fill($input);

      $comentario->update();

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
