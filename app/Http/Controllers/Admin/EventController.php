<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Show;
use Session;
use Jenssegers\Date\Date;
Use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::orderBy('start', 'desc')->paginate(10);
        return view('admin.events.index')->withEvents($events);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $shows = Show::pluck('name', 'id');
        return view('admin.events.create', compact('shows'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'show'           => 'required',
            'type'           => 'required',
            'start'          => 'required',
            'end'            => 'required',
            'adults_price'   => 'required',
            'children_price' => 'required',
            'members_price'  => 'required',
            'seats'          => 'required',
            'memo'           => 'nullable',
        ]);

        $event = new Event;

        $event->show_id        = $request->show;
        $event->type           = $request->type;
        $event->start          = new Date($request->start);
        $event->end            = new Date($request->end);
        $event->adults_price   = number_format($request->adults_price, 2);
        $event->children_price = number_format($request->children_price, 2);
        $event->members_price  = number_format($request->members_price, 2);
        $event->seats          = $request->seats;
        $event->memo           = $request->memo;
        $event->creator_id     = Auth::user()->id;

        $event->save();

        Session::flash('success',
            'The event '.$event->type.' '.Show::find($event->show_id)->name.' on '.Date::parse($event->start)->format('l, F j, Y \a\t h:i A').' has been added successfully!');
        return redirect()->route('admin.events.show', $event);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        return view('admin.events.show')->withEvent($event);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        $shows = Show::pluck('name', 'id');
        return view('admin.events.edit', compact('shows'))->withEvent($event);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
      $this->validate($request, [
          'show_id'        => 'required',
          'type'           => 'required',
          'start'          => 'required',
          'end'            => 'required',
          'adults_price'   => 'required',
          'children_price' => 'required',
          'members_price'  => 'required',
          'seats'          => 'required',
          'memo'           => 'nullable',
      ]);

      $event->show_id        = $request->show_id;
      $event->type           = $request->type;
      $event->start          = new Date($request->start);
      $event->end            = new Date($request->end);
      $event->adults_price   = round($request->adults_price, 2);
      $event->children_price = round($request->children_price, 2);
      $event->members_price  = round($request->members_price, 2);
      $event->seats          = $request->seats;
      $event->memo           = $request->memo;
      $event->creator_id     = Auth::user()->id;

      $event->save();

      Session::flash('success',
          'The '.$event->type.' '.Show::find($event->show_id)->name.' on '.Date::parse($event->start)->format('l, F j, Y \a\t h:i A').' has been updated successfully!');

      return redirect()->route('admin.events.show', $event);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $temp = $event;
        $event->delete();

        Session::flash('success',
            'The '.$event->type.' '.Show::find($event->show_id)->name.' on '.Date::parse($event->start)->format('l, F j, Y \a\t h:i A').' has been deleted successfully!');
        return redirect()->route('admin.events.index');
    }
}
