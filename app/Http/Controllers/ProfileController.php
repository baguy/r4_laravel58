<?php

namespace App\Http\Controllers;

use App\Profile;
use App\Http\Services\ComentarioService;
use App\Http\Controllers\BaseController;
use App\helpers\LoggingHelper;
use Input;
use Redirect;

class ProfileController extends BaseController {

	protected $profile;

	protected $service;

	protected $selects;

	public function __construct(Profile $profile, ProfileService $service) {

		parent::__construct($service);

		$this->profile = $profile;
		$this->service = $service;

		$this->selects = $this->service->selects();

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();

		try {

			ComentarioService::store($input);

			return Redirect::back()
											->with('_status', trans('application.msg.status.resource-created-successfully'));

		} catch (Exception $e) {

			Session::flash('_old_input', Input::all());

			return Redirect::back()->with('_error', trans('application.msg.error.something-went-wrong'));
		}

	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
	    $input = Input::all();

      try {

        $this->service->update($input, $id);

        return Redirect::back()
                        ->with('_status', trans('application.msg.status.resource-updated-successfully'));

      } catch (Exception $e) {

        Session::flash('_old_input', Input::all());

        return Redirect::back()->with('_error', trans('application.msg.error.something-went-wrong'));
      }

	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{

		$comment = $this->comentario->find($id);

		try {

			$comment->delete();

			LoggingHelper::destroy($comment);

			return Redirect::route('main.index')
											->with('_status', trans('application.msg.status.resource-deleted-successfully'));

		} catch (Exception $e) {

			return Redirect::back()->with('_error', trans('application.msg.error.something-went-wrong'));
		}
	}

	public function restore($id) {
		$comment = $this->comentario->withTrashed()->find($id);

		try {

			$comment->restore();

			return Redirect::route('main.index')
											->with('_status', trans('application.msg.status.resource-restored-successfully'));

		} catch (Exception $e) {

			return Redirect::back()->with('_error', trans('application.msg.error.something-went-wrong'));
		}
	}


}
