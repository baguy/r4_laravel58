<?php

namespace App\Http\Controllers;

use App\Main;
use App\User;
use App\Http\Controllers\MainService;

class MainController extends BaseController {

  protected $user;

  protected $service;

  protected $selects;

  public function __construct(Main $user, MainService $service) {

    parent::__construct($service);

    $this->user    = $user;
    $this->service = $service;

    $this->selects = $this->service->selects();

  }

  public function index() {

    $data = [
        'usuarios' => User::all()
    ];

    return view('main.index', compact('data'))->with('selects', $this->service->selects(true));
  }

  public function create() {

  }

  public function store() {

  }

  public function show($id) {

  }

  public function edit($id) {

  }

  public function update($id) {

  }

  public function destroy($id) {

  }

  public function restore($id) {

  }

}
