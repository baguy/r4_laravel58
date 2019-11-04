<?php

namespace App\Http\Services;

use App\helpers\LoggerHelper;
use App\helpers\MainHelper;
use App\builders\MainBuilder;
use App\builders\ComentarioBuilder;
use App\builders\UserBuilder;

class BaseService {

	public function hasChanges($model, $guarded = array()) {

		foreach ($model->getDirty() as $attribute => $value) {

			if (!in_array($attribute, $guarded)) {

				$original = $model->getOriginal($attribute);

				LoggerHelper::log('EDIT', Lang::get('logs.msg.edit.field', [
					'resource'  => MainHelper::getTable($model),
					'attribute' => $attribute,
					'original'  => $this->normalize($original),
					'value'     => $this->normalize($value),
					'id'        => $model->id
				]));
			}
		}
	}

	public function getElements($resource) {

		$builder = $this->getBuilder($resource);

		if ($builder) {

			$objects = [

				$resource => [
					'model'  => $builder->getModel(),
					'query'  => $builder->getQuery(),
					'folder' => $resource,
				]
			];

			if(isset($objects[$resource])) {

				return $objects[$resource];
			}

		}

		return null;
	}

  public function quickRegistration($service, $validator, $input, $field) {

    $headers = ['Content-type'=> 'application/json; charset=utf-8'];

    if($validator->fails())

      return Response::json([
        'response' => FALSE,
        'message'  => Lang::get('application.msg.error.something-went-wrong'),
        'content'  => $validator->errors()->toArray()
      ], 400, $headers, JSON_UNESCAPED_UNICODE);

    $resource = $service->store($input);

    $content  = [
      'text'  => $resource->{$field},
      'value' => $resource->id
    ];

    return Response::json([
      'response' => TRUE,
      'message'  => Lang::get('application.msg.status.resource-created-successfully'),
      'content'  => $content
    ], 200, $headers, JSON_UNESCAPED_UNICODE);
  }

	public function abort() {

		App::abort(404, Lang::get('application.error.404.msg'));
	}

	private function getBuilder($resource) {

		switch ($resource) {

			case 'users':

				return new UserBuilder();

			case 'comentarios':

				return new ComentarioBuilder();

			case 'main':

				return new MainBuilder();

			default:

				return null;
		}
	}

	private function normalize($content) {

		return mb_strimwidth(str_replace('|', '', preg_replace('#<[^>]+>#', ' ', $content)), 0, 80, '...');
	}
}
