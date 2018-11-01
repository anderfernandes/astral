<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\{Auth, Carbon};
use Session;

class LogController extends Controller
{
    /**
     * Returns an array with information from the log file, newest first, to /admin/logs
     * @return array Returns an array with information from the log file, newest first, to /admin/logs
     */
    public function index(Request $request)
    {

      $log_types = ["emergency", "alert", "critical", "error", "warning", "notice", "info", "debug"];

      // Path to log file
      $file = storage_path('logs/laravel.log');
      // Read log file and assign it to a variable
      $logs = file($file);
      // Create an empty array that will received each line from the file
      $filtered_logs = [];
      // Loop through each line
      foreach ($logs as $log)
      {
        // Spit out everything but the stack trace information
        if (substr($log, 0, 2) == "[2")
          array_push($filtered_logs, $log);
      }
      // Clean the original $logs array
      $logs = [];
      // Create the array with the data we want (date, type, message)
      foreach ($filtered_logs as $filtered_log)
      {
        $log = explode(" ", $filtered_log);
        $date = "$log[0] $log[1]";
        // Trim out the brackets and parse it as date
        $date = substr($date, 1);
        $date = substr($date, 0, -1);
        // Type of log message
        $type = $log[2];
        $type = substr($type, 7);
        $type = substr($type, 0, -1);
        $type = strtolower($type);
        // Remove date and type
        array_shift($log);
        array_shift($log);
        array_shift($log);
        // Convert message back to array
        $log = implode(" ", $log);
        // Add message to array
        $message = $log;
        // Add data to logs array
          array_unshift($logs, [
            "date"    => new Carbon($date),
            "type"    => $type,
            "message" => $message,
          ]);
      }

      // Filter log based on search parameters
      if ($request->has('type'))
      {

        $logs = array_filter($logs,
          function($log) use ($request)
          {
            return $log["type"] == $request->type;
          });
      }

      return view('admin.logs')->withLogs($logs)->with(["log_types" => $log_types]);
    }

    public function clear()
    {
      // Path to log file
      $file = storage_path('logs/laravel.log');
      // Read log file and assign it to a variable
      $logs = file_put_contents($file, "");

      Session::flash('success', "Application logs cleared successfully!");

      return redirect()->route('admin.logs');
    }
}
