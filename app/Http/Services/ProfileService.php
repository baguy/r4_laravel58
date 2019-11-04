<?php

namespace App\Http\Services;

use App\Http\Services\BaseService;
use App\User;
use App\Profile;
use App\profileAtualizacao;
use App\Http\AuthController;
use App\helpers\MainHelper;
use DB;
use Auth;

class ProfileService extends BaseService {

	protected $profile;

  public function __construct(Profile $profile) {

    $this->profile = $profile;
  }

  public function selects($is_filter = false) {

  }

  public static function store($input) {

  	DB::beginTransaction();

    try {

      $comment = new Profile($input);

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
