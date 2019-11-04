<?php

namespace App\Http\Controllers;

use App\Logger;
use App\User;
use App\validators\UniqueValidator;
use App\Http\Services\BaseService;
use View;
use Input;

class BaseController extends Controller {

	protected $service;

  public function __construct(BaseService $service) {

    $this->service = $service;

    $notifications = Logger::orderBy('id', 'DESC')->take(5)->get();

    $messages      = User::orderBy('users.id', 'DESC')
	    ->join('throttles as t', 't.user_id', '=', 'users.id')
			->where('t.attempts', '>', 0)
			->orWhereNotNull('users.deleted_at')->take(5)->get();

    $navbar_vars   = [
    	'notifications' => $notifications,
    	'messages'      => $messages
    ];

    View::share('navbar_vars', $navbar_vars);
  }

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout() {

		if (!is_null($this->layout)) {
			$this->layout = view($this->layout);
		}
	}

	public function getElements($resource, $objects = false, $type = null) {

		$object = $this->service->getElements($resource);

		if ($object) {

			$elements = $object['query'];

			$parameters = Input::except('_token', '_method');

			$generals = array();
			$specifcs = array();
			$ordering = array();
			$perPage  = array();
			$grouping = array();

			if ($parameters) {

	      // Model order by parameters

	      if (array_key_exists('C_sort', $parameters))

	      	$ordering = array_only($parameters, array('C_sort', 'C_order'));

	      if (array_key_exists('C_per_page', $parameters))

	      	$perPage  = array_only($parameters, array('C_per_page'));

	      // Model group by parameters

	      if (array_key_exists('C_group', $parameters))

	      	$grouping = array_only($parameters, array('C_group'));

	      $parameters = array_except($parameters, array('page', 'C_sort', 'C_order', 'C_per_page', 'C_group'));

	      // Model specific restrictions
				$specifcs = array_filter($parameters, function($k) { return starts_with($k, 'S_'); }, ARRAY_FILTER_USE_KEY);

				$elements = $elements->getSpecificRestrictions($specifcs);

				// Model general restrictions (explode("|", $field))
	      $generals = array_filter($parameters, function($k) { return !starts_with($k, 'S_'); }, ARRAY_FILTER_USE_KEY);

				foreach ($generals as $key => $parameter) {

					if($parameter) {

						$elements = $elements->getGeneralRestrictions(function($q) use($resource, $key, $parameter) {

							foreach(explode("|", $key) as $attribute) {

								$q = $q->orWhere("$resource.$attribute", 'LIKE', "%{$parameter}%");
							}
						});
					}
				}
			}

			$elements = $elements->getBasicRestrictions($specifcs)->getOrder($ordering)->getGroup($grouping);

			if ($objects) {

				$elements = $elements->getContent($type, $perPage)->build();

				return $elements;
			}

			$elements = $elements->getContent(null, $perPage)->build();

			return view("{$object['folder']}.table", compact('elements'));

		}

		return Response::make('<div class="alert alert-danger">'
														. Lang::get('application.msg.error.resource-not-exists', [ 'resource' => $resource ]) .
													'</div>');
	}

  public function unique($table, $field, $id) {

    $input = Input::all();

    $validator = UniqueValidator::validate($input, $table, $field, $id);

    if($validator->passes())

    	return 'true';

    return 'false';
  }

}
