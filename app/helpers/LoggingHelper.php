<?php

namespace App\helpers;

class LoggingHelper {

  // Logs the create operation
  public static function create($model) {

    LoggerHelper::log('CREATE', Lang::get('logs.msg.create', [
      'resource' => MainHelper::getTable($model),
      'id' => $model->id
    ]));
  }

  public static function create_nome($model) {

    LoggerHelper::log('CREATE', Lang::get('logs.msg.create.nome', [
      'resource' => MainHelper::getTable($model),
      'nome'     => $model->nome,
      'id'       => $model->id
    ]));
  }

  public static function create_laudo($model, $nome, $numero) {

    LoggerHelper::log('UPDATE', Lang::get('logs.msg.create.laudo', [
      'resource' => MainHelper::getTable($model),
      'nome'     => $nome,
      'numero'    => $numero,
      'id' => $model->id
    ]));

  }

  // Logs the show operation
  public static function show($model) {

    LoggerHelper::log('SHOW', Lang::get('logs.msg.show', [
      'resource' => MainHelper::getTable($model),
      'id'       => $model->id
    ]));
  }

  // Logs the update operation
  public static function update($model) {

    LoggerHelper::log('UPDATE', Lang::get('logs.msg.update', [
      'resource' => MainHelper::getTable($model),
      'id' => $model->id
    ]));

  }

  // Logs the update operation
  public static function update_nome($model) {

    LoggerHelper::log('UPDATE', Lang::get('logs.msg.update.nome', [
      'resource' => MainHelper::getTable($model),
      'nome'     => $model->nome,
      'id' => $model->id
    ]));

  }

  // Logs the update operation
  public static function update_exame($model, $numero) {

    LoggerHelper::log('UPDATE', Lang::get('logs.msg.update.exame', [
      'resource' => MainHelper::getTable($model),
      'numero'   => $numero,
      'id' => $model->id
    ]));

  }

  // Logs the update operation
  public static function update_laudo($model, $nome, $numero) {

    LoggerHelper::log('UPDATE', Lang::get('logs.msg.update.laudo', [
      'resource' => MainHelper::getTable($model),
      'nome'     => $nome,
      'numero'    => $numero,
      'id' => $model->id
    ]));

  }

  // Logs the delete operation
  public static function delete($model) {

    LoggerHelper::log('DELETE', Lang::get('logs.msg.delete.forced', [
      'resource' => MainHelper::getTable($model),
      'id' => $model->id
    ]));
  }

  // Logs the destroy operation
  public static function destroy($model) {

    LoggerHelper::log('DESTROY', Lang::get('logs.msg.delete.soft', [
      'resource' => MainHelper::getTable($model),
      'id' => $model->id
    ]));
  }

  // Logs the restore operation
  public static function restore($model) {

    LoggerHelper::log('RESTORE', Lang::get('logs.msg.restore', [
      'resource' => MainHelper::getTable($model),
      'id' => $model->id
    ]));
  }

  // Logs the report operation
  public static function report($model, $parameters) {

    LoggerHelper::log('REPORT', Lang::get('logs.msg.report', [
      'resource'   => MainHelper::getTable($model),
      'parameters' => json_encode($parameters)
    ]));
  }

  // Logs the export operation
  public static function export($model, $format, $parameters, $title) {

    LoggerHelper::log('EXPORT', Lang::get('logs.msg.export', [
      'resource'    => MainHelper::getTable($model),
      'format'      => $format,
      'id'          => $model->id,
      'title'       => $title,
      'parameters'  => json_encode($parameters)
    ]));
  }

  // Logs the print operation
  public static function printing($model, $type, $parameters = []) {

    if ($type === 'print-one')

      LoggerHelper::log('PRINT', Lang::get('logs.msg.print-one', [
        'resource' => MainHelper::getTable($model),
        'id'       => $model->id
      ]));

    else

      LoggerHelper::log('PRINT', Lang::get('logs.msg.print-all', [
        'resource'   => MainHelper::getTable($model),
        'parameters' => json_encode($parameters)
      ]));
  }

  // Logs the dashboard content
  public static function dashboard() {

    LoggerHelper::log('DASHBOARD', Lang::get('logs.msg.dashboard'));
  }

  // Logs the aprove operation
  public static function aprove($model) {

    LoggerHelper::log('APROVE', Lang::get('logs.msg.aprove', [
      'resource' => MainHelper::getTable($model),
      'id'       => $model->id
    ]));
  }

  // Logs the move operation
  public static function move($model,$nome, $numero) {

    LoggerHelper::log('MOVE', Lang::get('logs.msg.move', [
      'resource' => MainHelper::getTable($model),
      'nome'     => $nome,
      'numero'   => $numero,
      'pdf'      => $model->pdf,
      'id'       => $model->id
    ]));
  }

  // Logs the download operation
  public static function download($model,$nome,$numero) {

    LoggerHelper::log('DOWNLOAD', Lang::get('logs.msg.download', [
      'resource' => MainHelper::getTable($model),
      'exame'    => $nome,
      'numero'   => $numero,
      'pdf'      => $model->pdf,
      'id'       => $model->id
    ]));
  }

}
