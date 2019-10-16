<?php

namespace App\Http\Controllers;

class DashboardController extends BaseController {

	protected $service;

  public function __construct(DashboardService $service) {

    parent::__construct($service);

  	$this->service = $service;

  	$this->data   = $this->service->data();

    $this->beforeFilter('role:LAB', array('only' => array(
      'panel'
    )));
  }

  public function panel() {

    return View::make('dashboard.panel')->with('data', $this->data);
  }

  public function charts($resource) {

    LoggingHelper::dashboard();

    $contents = parent::getElements($resource, true, 'get');

    $headers  = ['Content-type'=> 'application/json; charset=utf-8'];

    return Response::json($contents, 200, $headers, JSON_UNESCAPED_UNICODE);
  }
}
