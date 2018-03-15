<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use App\EventType;

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
        // $events = Event::where('id', '<>', 1)->orderBy('start', 'desc')->paginate(10);

        $shows = Show::pluck('name', 'id');
        $eventTypes = EventType::where('id', '<>', 1)->pluck('name', 'id');

        return view('admin.events.index', compact('shows'), compact('eventTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $shows = Show::pluck('name', 'id');
        $eventTypes = EventType::where('id', '<>', 1)->pluck('name', 'id');

        return view('admin.events.create', compact('shows'), compact('eventTypes'));
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
            'show_id'        => 'required',
            'type_id'        => 'required',
            'dates.*.start'  => 'required',
            'dates.*.end'    => 'required',
            'seats'          => 'required|min:0',
            'memo'           => 'nullable',
            'public'         => 'required',
        ]);

        foreach ($request->dates as $date) {

          $event = new Event;

          $event->show_id        = $request->show_id;
          $event->type_id        = $request->type_id;
          $event->start          = new Date($date['start']);
          $event->end            = new Date($date['end']);
          $event->seats          = $request->seats;
          $event->memo           = $request->memo;
          $event->creator_id     = Auth::user()->id;
          $event->public         = $request->public;

          $event->save();
        }

        $date = Date::parse($event->start)->format('Y-m-d');

        Session::flash('success',
            'The event(s) <strong>'.$event->type->name.'</strong> show <strong>'.Show::find($event->show_id)->name.'</strong> been added successfully!');

        return redirect()->to(route('admin.calendar.index') . '/?type=events&date=' . $date . '&view=agendaDay');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        $shows = Show::pluck('name', 'id');
        $eventTypes = EventType::where('id', '<>', 1)->pluck('name', 'id');
        return view('admin.events.show', compact('shows'), compact('eventTypes'))->withEvent($event);
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
        $eventTypes = EventType::where('id', '<>', 1)->pluck('name', 'id');
        return view('admin.events.edit', compact('shows'), compact('eventTypes'))->withEvent($event);
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
          'type_id'        => 'required',
          'dates.*.start'  => 'required',
          'dates.*.end'    => 'required',
          'seats'          => 'required',
          'memo'           => 'nullable',
          'public'         => 'required',
      ]);

      $event->show_id        = $request->show_id;
      $event->type_id        = $request->type_id;
      $event->start          = new Date($request->dates[0]['start']);
      $event->end            = new Date($request->dates[0]['end']);
      $event->seats          = $request->seats;
      $event->memo           = $request->memo;
      $event->creator_id     = Auth::user()->id;
      $event->public         = $request->public;

      $event->save();

      $date = Date::parse($event->start)->format('Y-m-d');

      Session::flash('success',
          'The <strong>'.$event->type->name.'</strong> show <strong>'.Show::find($event->show_id)->name.'</strong> on <strong>'.Date::parse($event->start)->format('l, F j, Y \a\t h:i A').'</strong> has been updated successfully!');

      return redirect()->to(route('admin.calendar.index') . '/?type=events&date=' . $date . '&view=agendaDay');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //$temp = $event;
        //$event->delete();

        //Session::flash('success',
        //    'The <strong>'.$event->type->name.'</strong> show <strong>'.Show::find($event->show_id)->name.'</strong> on <strong>'.Date::parse($event->start)->format('l, F j, Y \a\t h:i A').'</strong> has been deleted successfully!');
        //return redirect()->route('admin.events.index');
    }
}
