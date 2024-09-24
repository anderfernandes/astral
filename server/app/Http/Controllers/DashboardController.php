<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $data = [];

        $data['users'] = DB::table('users')->count();
        $data['events'] = DB::table('events')->count();
        $data['sales'] = DB::table('sales')->where('total')->count();
        $data['tickets'] = DB::table('tickets')->count();
        $data['payments'] = DB::table('payments')->latest()->take(5)->get();

        return response(['data' => $data]);
    }
}
