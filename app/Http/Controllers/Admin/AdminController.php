<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use App\{ Event, EventType, Show, Announcement };

class AdminController extends Controller
{
    public function index()
    {
      $announcements = Announcement::where('end', '<=', today()->toDateTimeString())->get();
      return view('admin.index')->withAnnouncements($announcements);
    }

    public function calendar(Request $request)
    {
      $shows = Show::pluck('name', 'id');
      $eventTypes = EventType::where('id', '<>', 1)->pluck('name', 'id');

      return view('admin.calendar.index', compact('shows'), compact('eventTypes'))->withRequest($request);
      //dd($request->type);
    }
}
