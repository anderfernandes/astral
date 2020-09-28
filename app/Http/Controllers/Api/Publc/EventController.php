<?php

namespace App\Http\Controllers\Api\Publc;

use App\{ Event, Announcement };
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventController extends Controller
{

  public function index()
  {
    $today = now()->toDateString();
    $target = now()->addDays(14)->toDateString();
    // Getting dates in which we actually have events
    $dates = Event::where('public', true)
      ->whereDate('start', '>=', $today)->whereDate('end', '<=', $target)
      ->pluck('start')
      ->map(function ($item) { return $item->startOfDay(); })
      ->unique();

    // Building a schedule based on dates
    $schedule = $dates->map(function ($date) { 
      return [ 
        "date" => $date->toIsoString(),
        "events" => Event::whereDate('start', $date->toDateString())
          ->where('public', true)
          ->with(['show', 'type.allowedTickets'])
          ->get()
      ]; 
    });

    // Getting announcements
    $announcements = Announcement::where('public', true)->get();

    return response([
      'data' => $schedule,
      'anouncements' => $announcements
    ], 201);
  }

  public function show(Event $event)
  {
    $announcements = Announcement::where('public', true)->get();
    
    return response([
      'data' => $event->load(['show', 'type.allowedTickets']),
      'announcements' => $announcements
    ], 201);
  }

}