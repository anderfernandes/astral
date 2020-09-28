<?php

namespace App\Http\Controllers\Api\Publc;

use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{

  public function index()
  {
    $settings = Setting::find(1);

    return response([
      "data" => $settings,
    ], 201);
  }

}