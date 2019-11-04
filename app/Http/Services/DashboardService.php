<?php

namespace App\Http\Services;

use App\Http\Controllers\BaseService;
use App\User;
use App\Http\AuthController;

class DashboardService extends BaseService {

  public function __construct() {

  }

  public function data() {

    $datas = [

      'users'         => $this->getUsers(),

    ];

    if (!Auth::user()->hasRole('ROOT')) {

    $datas['users']          = $datas['users']->first();

    return $datas;
  }

  private function getUsers() {

    return User::withTrashed()->select(

            DB::raw('COUNT(*) AS total'),

            DB::raw('SUM(deleted_at IS NULL) AS active'),
            DB::raw('CONCAT(FORMAT((SUM(deleted_at IS NULL)/COUNT(*)) * 100, 2), "%") AS active_avg'),

            DB::raw('(COUNT(deleted_at) - SUM(t.suspended IS TRUE)) AS inactive'),
            DB::raw(
              'CONCAT(
                FORMAT(
                  ((COUNT(deleted_at) - SUM(t.suspended IS TRUE)) / COUNT(*)) * 100, 2), "%") AS inactive_avg'
            ),

            DB::raw('SUM(t.suspended IS TRUE) AS suspended'),
            DB::raw('CONCAT(FORMAT((SUM(t.suspended IS TRUE)/COUNT(*)) * 100, 2), "%") AS suspended_avg'),

            DB::raw('SUM(t.attempts > 0) AS attempts'),
            DB::raw('CONCAT(FORMAT((SUM(t.attempts > 0)/COUNT(*)) * 100, 2), "%") AS attempts_avg')

          )->join('throttles as t', 't.user_id', '=', 'users.id');
  }

}
