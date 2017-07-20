<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Event;
use Jenssegers\Date\Date;

class CashierController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }

    public function index()
    {
      // Get the authenticated user
      $user = Auth::user();
      // Get today's date for the query that will show today's events
      $today = Date::now()->format('Y-m-d');
      // Get all events going on today
      $events = Event::where('start','>=', $today . ' 00:00:00')
                  ->where('start','<=', $today . ' 23:59:59')
                  ->orderBy('start', 'desc')
                  ->get();
      return view('cashier.index')->withUser($user)->withEvents($events);
    }
}
