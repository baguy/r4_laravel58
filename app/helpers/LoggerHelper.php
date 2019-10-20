<?php

namespace App\helpers;

use App\Logger;
use Auth;

class LoggerHelper {

  // Log Register - First records on database and after 10 days exports them to file text
  public static function log($action, $message) {

    event('logger.exporting');

    $log     = Logger::orderBy('id', 'DESC')->first();
    $today   = date('Y-m-d H:i:s');
    $user    = null;
    $minutes = '+10 minutes';

    if (Auth::check())

      $user = Auth::user()->id;

    switch (true) {

      case is_null($log): // Is log empty
      case $log->message !== $message: // Is message not equals previous message
      case $log->user_id !== (Auth::guest() ? null : Auth::user()->id): // Is user not equals previous user
      case $action === 'AUTH': // Is Auth operation
      case strtotime($log->created_at . $minutes) < strtotime($today): // Is it passed +10min from last message

        Logger::create([
          'action'  => $action,
          'message' => $message,
          'user_id' => $user
        ]);

        break;
    }
  }

  // Log Retrieve - Restore logs from files and database from oldest to most recent ones
  public static function get($search = null) {

    $logs = [];

    if ($search) {

      Self::log('SEARCH', trans('logs.msg.index.search', [
        'resource' => 'LOGGER', 'parameters' => $search
      ]));

      $FOLDER_PATH = storage_path('logs/');

      $files       = scandir($FOLDER_PATH);

      $ignored     = ['.', '..', '.gitignore', 'laravel.log'];

      foreach ($files as $file) {

        if (in_array($file, $ignored)) continue;

        $filepath = $FOLDER_PATH.$file;

        $contents = file_get_contents($filepath);

        $pattern  = preg_quote($search, '/');

        $pattern  = "/^.*$pattern.*\$/mi";

        if(preg_match_all($pattern, $contents, $matches))
          $logs[] = $matches[0];
      }

      $loggers = Logger::where('action', 'LIKE', "%{$search}%")
        ->orWhere('message', 'LIKE', "%{$search}%")
        ->orWhere('created_at', 'LIKE', "%{$search}%")
        ->orWhereHas('user', function ($q) use ($search) {
          $q->where('email', 'LIKE', "%{$search}%");
        })->get();

      $fileIterator = new FilesystemIterator($FOLDER_PATH, FilesystemIterator::SKIP_DOTS);

      foreach ($loggers as $log) {

        $register = Self::getRegister($log);

        $logs[(iterator_count($fileIterator) - 3)][] = $register;
      }

    }

    return $logs;
  }

  // Color for each action
  public static function getColors() {

    return [
      'AUTH'      => 'success',
      'CREATE'    => 'primary',
      'DASHBOARD' => 'dashboard',
      'DELETE'    => 'danger',
      'DESTROY'   => 'destroy',
      'EDIT'      => 'info',
      'EXPORT'    => 'export',
      'INDEX'     => 'secondary',
      'PRINT'     => 'dark',
      'REPORT'    => 'report',
      'RESTORE'   => 'warning',
      'SEARCH'    => 'secondary',
      'SHOW'      => 'secondary',
      'UPDATE'    => 'info',
      'APROVE'    => 'info',
      'MOVE'      => 'warning',
      'DOWNLOAD'  => 'success'
    ];
  }

  // Icon for each action
  public static function getIcons() {

    return [
      'AUTH'      => 'lock',
      'CREATE'    => 'plus',
      'DASHBOARD' => 'chart-line',
      'DELETE'    => 'times',
      'DESTROY'   => 'trash-alt',
      'EDIT'      => 'pencil-alt',
      'EXPORT'    => 'table',
      'INDEX'     => 'list-ul',
      'PRINT'     => 'print',
      'REPORT'    => 'file-alt',
      'RESTORE'   => 'recycle',
      'SEARCH'    => 'search',
      'SHOW'      => 'eye',
      'UPDATE'    => 'sync',
      'APROVE'    => 'file-signature',
      'MOVE'      => 'file-export',
      'DOWNLOAD'  => 'file-download'
    ];
  }

  // Register Maker - Put all the pieces together to make a register line
  private static function getRegister($log) {

    $action     = $log->action;
    $created_at = $log->created_at;
    $message    = $log->message;
    $user       = 'NO USER';
    $role       = 'ANONYMOUS';

    if (!is_null($log->user)) {

      $user = "({$log->user_id}) {$log->user->email}";
      $role = $log->user->minRole()->name;
    }

    $register = "$created_at | [ $user : $role ] | $action | $message \r\n";

    return $register;
  }
}
