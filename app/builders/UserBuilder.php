<?php

namespace App\builders;

use App\User;

	class UserBuilder {

		private $instance;

		public function __construct() {

			$this->instance = new User();
		}

		public function getModel() {

			return $this->instance;
		}

		public function getQuery() {

			$this->instance = $this->instance;

			return $this;
		}

		public function getSpecificRestrictions($parameters = array()) {

			// Status
			if (array_key_exists('S_status', $parameters)) {

				if ($parameters['S_status'] === '1') { // Active

					$this->instance = $this->instance->where('users.deleted_at', null);

				} elseif ($parameters['S_status'] === '2') { // Inactive

					// $this->instance = $this->instance->withTrashed()
					// 																->whereNotNull('users.deleted_at')
					// 																->whereHas('throttle', function ($q) {
					//
					// 																	$q->where('suspended', false);
					// 													      });
					$this->instance = $this->instance->withTrashed()->whereNotNull('deleted_at');

				} elseif ($parameters['S_status'] === '3') { // Suspended

					$this->instance = $this->instance->withTrashed()
																					->whereNotNull('users.deleted_at')
																					->whereHas('throttle', function ($q) {

																						$q->where('suspended', true);
																		      });
				}
			}

			// Attempts
			if (array_key_exists('S_attempts', $parameters)) {

				if ($parameters['S_attempts'] === '0') // 0 attempts

					$this->instance = $this->instance->whereHas('throttle', function ($q) {

																						$q->where('attempts', '=', 0);
																		      });

				elseif ($parameters['S_attempts'] === '1') // >= 1 attempts

					$this->instance = $this->instance->whereHas('throttle', function ($q) {

																						$q->where('attempts', '>=', 1);
																		      });
			}

			// Is Default Password
			if (array_key_exists('S_is_default_password', $parameters)) {

				if ($parameters['S_is_default_password'] === '1') // Default

					$this->instance = $this->instance->whereHas('throttle', function ($q) {

																						$q->where('is_default_password', true);
																		      });

				elseif ($parameters['S_is_default_password'] === '0') // Changed

					$this->instance = $this->instance->whereHas('throttle', function ($q) {

																						$q->where('is_default_password', false);
																		      });
			}


			return $this;
		}

		public function getGeneralRestrictions($restrictions = null) {

			if ($restrictions)

				$this->instance = $this->instance->where($restrictions);

			return $this;
		}

		public function getBasicRestrictions($parameters = array()) {

			// Caso não seja o usuário ROOT carrega apenas os usuários que pertencem à sua(s) secretaria(s)

			if (!Auth::user()->hasRole('ROOT')) {

				// $origens = Auth::user()->secretarias()->select('secretarias.*')->withTrashed()->lists('id');
				//
				// $this->instance = $this->instance
				// 																->whereHas('secretarias', function ($q) use ($origens) {
				//
				// 																	foreach($origens as $origem) {
				//
				// 																		$q = $q
				// 																					->where('secretarias.id', '=', $origem)
				// 																					->orWhereNotNull('secretarias.deleted_at');
				// 																	}
				// 													      });
			}

			// Roles
			$this->instance = $this->instance->whereHas('roles', function ($q) use ($parameters) {

																					if (array_key_exists('S_roles', $parameters) && !empty($parameters['S_roles'])) {

																						$q->havingRaw('MIN(roles.id) = ?', [ $parameters['S_roles'] ]);

																	      	} else {

																		        $q->havingRaw('MIN(roles.id) >= ?', [ Auth::user()->minRole()->id ]);
																		      }
																	      });

			return $this;
		}

		public function getOrder($parameters = array()) {

			$sort  = 'name';

			$order = 'ASC';

			if (array_key_exists('C_sort', $parameters))

				$sort = empty($parameters['C_sort']) ? $sort : $parameters['C_sort'];

			if (array_key_exists('C_order', $parameters))

				$order = empty($parameters['C_order']) ? $order : $parameters['C_order'];

			if ($sort === 'status')

				$this->instance = $this->instance
																	->join('throttles as t2', 't2.user_id', '=', 'users.id')
																	->orderBy('t2.suspended', $order)
																	->orderBy('users.deleted_at', $order);

			elseif ($sort === 'roles.name')

				$this->instance = $this->instance
																	->select('users.*')
																	->join(
																			DB::raw(

																				"(SELECT user_id, MIN(role_id) MIN_role_id FROM users_roles GROUP BY user_id) AS ur2"

																			), 'users.id', '=', 'ur2.user_id'
																		)
                                	->join('roles as r2', 'r2.id', '=', 'ur2.MIN_role_id')
																	->orderBy('r2.id', $order);

			// BEGIN - EXTRA COLUMNS

			elseif ($sort === 'attempts')

				$this->instance = $this->instance->orderBy('users.deleted_at', $order);

			// END - EXTRA COLUMNS

			else

				$this->instance = $this->instance->orderBy($sort, $order);

			return $this;
		}

		public function getGroup($parameters = array()) {

			$group = null;

			if (array_key_exists('C_group', $parameters))

				$group = empty($parameters['C_group']) ? $group : $parameters['C_group'];

			if ($group === 'status')

				$this->instance = $this->instance
																	->select(
																		'users.*',
																		DB::raw('IF(users.deleted_at IS NULL, NULL, 1) AS status'),
																		DB::raw('IF(t3.suspended IS FALSE, COUNT(users.deleted_at), NULL) AS inactive'),
																		DB::raw('SUM(users.deleted_at IS NULL) AS active'),
																		DB::raw('SUM(t3.suspended IS TRUE) AS suspended')
																	)
																	->join('throttles as t3', 't3.user_id', '=', 'users.id')
																	->groupBy(['status', 't3.suspended']);

			if ($group === 'roles')

				$this->instance = $this->instance->select(
																		'users.*',
																		'r3.name as role_',
																		DB::raw('COUNT(*) AS total')
																	)
																	->join(
																			DB::raw(

																				"(SELECT user_id, MIN(role_id) MIN_role_id FROM users_roles GROUP BY user_id) AS ur3"

																			), 'users.id', '=', 'ur3.user_id'
																		)
                                	->join('roles as r3', 'r3.id', '=', 'ur3.MIN_role_id')
																	->groupBy('r3.id');

			if ($group === 'attempts')

				$this->instance = $this->instance
																	->select(
																		'users.*',
																		DB::raw('SUM(t3.attempts > 0) AS attempts'),
																		DB::raw('SUM(t3.attempts < 1) AS no_attempts')
																	)
																	->join('throttles as t3', 't3.user_id', '=', 'users.id')
																	->groupBy('t3.attempts');

			// END - EXTRA COLUMNS

			return $this;
		}

		public function getContent($type = null, $parameters = array()) {

			switch ($type) {

				case 'get':

					$this->instance = $this->instance->get();

					break;

				default:

					$perPage = 10;

					if (array_key_exists('C_per_page', $parameters))

						$perPage = empty($parameters['C_per_page']) ? $perPage : $parameters['C_per_page'];

					$this->instance = $this->instance->paginate($perPage);

					break;
			}

			return $this;
		}

		public function build() {

			return $this->getModel();
		}
	}

?>
