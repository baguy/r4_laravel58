<?php

namespace App\Http\Controllers;
use App\helpers\LoggerHelper;

class LoggerController extends BaseController {

	public function index() {

		$logs = LoggerHelper::get(Input::get('search'));

		$colors = LoggerHelper::getColors();

		return View::make('logger.index', compact(['logs', 'colors']));
	}

}
