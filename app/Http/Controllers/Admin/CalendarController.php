<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\{Show, EventType};

class CalendarController extends Controller
{

    //
    public function events(Request $request) {
      $shows = Show::where('id', '!=', 1)->orderBy('name', 'asc')->pluck('name', 'id');
      $shows->prepend('No Show', 0);
      $eventTypes = EventType::where('id', '<>', 1)->orderBy('name', 'asc')->pluck('name', 'id');

      return view('admin.calendar.events', compact('shows'), compact('eventTypes'))->withRequest($request);
    }

    //
    public function sales(Request $request) {
      $shows = Show::where('id', '!=', 1)->orderBy('name', 'asc')->pluck('name', 'id');
      $shows->prepend('No Show', 0);
      $eventTypes = EventType::where('id', '<>', 1)->orderBy('name', 'asc')->pluck('name', 'id');

      return view('admin.calendar.sales', compact('shows'), compact('eventTypes'))->withRequest($request);
    }
}
