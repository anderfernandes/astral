<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use App\{ Event, EventType, Show, Announcement, Setting, Shift, Sale };

class AdminController extends Controller
{
    public function index()
    {
      $announcements = Announcement::where([
        [ 'end', '>=', now()->toDateTimeString() ],
        [ 'public', false ]
      ])->get();
      $cover = Setting::find(1)->cover;
      $shifts = Shift::where('start', '>=', now()->startOfDay()->toDateTimeString())
                      ->whereHas('employees', function($query) {
        $query->where('user_id', auth()->user()->id);
      })->get();

      $sales = Sale::where([
        ['status',     '=', 'tentative'],
        ['creator_id', '=', 1],
      ])->orderBy('created_at', 'desc')->get();

      return view('admin.index')->withAnnouncements($announcements)
                                ->withShifts($shifts)
                                ->withSales($sales)
                                ->withCover($cover);
    }

    public function calendar(Request $request)
    {
      $shows = Show::where('id', '!=', 1)->orderBy('name', 'asc')->pluck('name', 'id');
      $shows->prepend('No Show', 0);
      $eventTypes = EventType::where('id', '<>', 1)->orderBy('name', 'asc')->pluck('name', 'id');

      return view('admin.calendar.index', compact('shows'), compact('eventTypes'))->withRequest($request);
      //dd($request->type);
    }
}
