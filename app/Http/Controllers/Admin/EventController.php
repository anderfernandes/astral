<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use App\EventType;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Show;
use Session;
use Jenssegers\Date\Date;

use Illuminate\Support\Facades\{ Auth, Log };
use Illuminate\Support\Carbon;

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
    public function create(Request $request)
    {
        $shows = Show::pluck('name', 'id');
        $eventTypes = EventType::where('id', '<>', 1)->pluck('name', 'id');

        // Getting conflicting events, which here will come from store()
        $conflicting_events = $request->session()->pull('conflicting_events');


        return view('admin.events.create', compact('shows'), compact('eventTypes'))
                   ->with(['conflicting_events' => $conflicting_events]);
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
            'type_id'        => 'required',
            'dates.*.start'  => 'required',
            'dates.*.end'    => 'required',
            'dates.*.show_id' => 'required',
            'seats'          => 'required|min:0',
            'memo'           => 'required',
            'public'         => 'required',
        ]);

        // Loop through events and make sure their start time doesn't mach some other events
        $confEventsBucket = collect();
        foreach ($request->dates as $date)
        {
          $beginning = new Carbon($date['start']);
          $conflicting_events = Event::where('start', $beginning->toDateTimeString())
                                     ->where('type_id', $request->type_id)
                                     ->get();
          foreach ($conflicting_events as $conflicting_event)
          {
            $confEventsBucket->push($conflicting_event);
          }
        }

        if ($confEventsBucket->count() > 0)
        {
          session(['conflicting_events' => $confEventsBucket]);
          return redirect()->route('admin.events.create')->withInput();
        }


        foreach ($request->dates as $date) {

          $event = new Event;

          // Setting a Date object for start and end times of this even
          $start = new Date($date['start']);
          $end   = new Date($date['end']);

          $event->show_id        = $date['show_id'];
          $event->type_id        = $request->type_id;

          /**
          * If the event is "all day", set it to start at the beginning of the
          * day and end at the end of the day. If not, keep original datetimes
          * If the event is "all day", set it to start at the beginning of the
          * day and end at the end of the day. If not, keep original datetimes
          **/
          $event->start          = (bool)$request->allday ? $start->startOfDay() : $start;
          $event->end            = (bool)$request->allday ? $start->endOfDay()->hour(23)->minute(59)->second(59)   : $end;

          $event->seats          = $request->seats;

          // The old memo field will serve as a title for the event if it is all day
          $event->memo           = $request->show_id == 1 ? $request->title : null;
          $event->creator_id     = Auth::user()->id;
          $event->public         = $request->public;

          $event->save();

          if (isSet($request->memo))
          {
            $event->memo()->create([
              'author_id' => Auth::user()->id,
              'message'   => $request->memo,
              'event_id'   => $event->id,
            ]);
          }

        }

        $date = Date::parse($event->start)->format('l, F j, Y \a\t h:i A');

        Session::flash('success',
          "The <strong>{$event->type->name}</strong> show <strong>{$event->show->name}</strong> on <strong>{$date}</strong> has been added successfully!");

        $date = Date::parse($event->start)->format('Y-m-d');

        // Log created event
        Log::info(Auth::user()->fullname . ' created Event #' . $event->id .' using admin');

        return redirect()->to(route('admin.calendar.index') . '?type=events&date=' . $date . '&view=agendaDay');

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
    public function edit(Event $event, Request $request)
    {
        $shows = Show::pluck('name', 'id');
        $eventTypes = EventType::where('id', '<>', 1)->pluck('name', 'id');

        // Getting conflicting events, which here will come from update()
        $conflicting_events = $request->session()->pull('conflicting_events');

        return view('admin.events.edit', compact('shows'), compact('eventTypes'))
                  ->withEvent($event)
                  ->with(['conflicting_events' => $conflicting_events]);
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
          'type_id'         => 'required',
          'dates.*.start'   => 'required',
          'dates.*.end'     => 'required',
          'dates.*.show_id' => 'required',
          'seats'           => 'required',
          'memo'            => 'required',
          'public'          => 'required',
      ]);

      // Loop through events and make sure their start time doesn't mach some other events
      $confEventsBucket = collect();
      foreach ($request->dates as $date)
      {
        $beginning = new Carbon($date['start']);
        $conflicting_events = Event::where('start', $beginning->toDateTimeString())
                                   ->where('type_id', $request->type_id)
                                   ->get();
        foreach ($conflicting_events as $conflicting_event)
        {
          // Making sure that we can change anything in events with the same id
          if ($event->id != $conflicting_event->id)
            $confEventsBucket->push($conflicting_event);
        }
      }

      if ($confEventsBucket->count() > 0)
      {
        session(['conflicting_events' => $confEventsBucket]);
        return redirect()->route('admin.events.edit', $event)->withInput();
      }

      // Setting a Date object for start and end times of this even

      $start = new Date($request->dates[0]['start']);
      $end   = new Date($request->dates[0]['end']);

      $event->show_id        = $request->dates[0]['show_id'];
      $event->type_id        = $request->type_id;

      // If the event is "all day", set it to start at the beginning of the
      // day and end at the end of the day. If not, keep original datetimes
      $event->start          = (bool)$request->allday ? $start->startOfDay()                       : $start;
      $event->end            = (bool)$request->allday ? $start->hour(23)->minute(59)->second(59)   : $end;

      $event->seats          = $request->seats;

      // The old memo field will serve as a title for the event if it is all day
      $event->memo           = $request->show_id == 1 ? $request->title : null;
      $event->creator_id     = Auth::user()->id;
      $event->public         = $request->public;

      $event->save();

      if (isSet($request->memo))
      {
        $event->memo()->create([
          'author_id' => Auth::user()->id,
          'message'   => $request->memo,
          'event_id'   => $event->id,
        ]);
      }

      $date = Date::parse($event->start)->format('l, F j, Y \a\t h:i A');

      Session::flash('success',
        "The <strong>{$event->type->name}</strong> show <strong>{$event->show->name}</strong> on <strong>{$date}</strong> has been edited successfully!");

      $date = Date::parse($event->start)->format('Y-m-d');

      // Log edited event
      Log::info(Auth::user()->fullname . ' edited Event #' . $event->id .' using admin');

      return redirect()->to(route('admin.calendar.index') . '?type=events&date=' . $date . '&view=agendaDay');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $date = Date::parse($event->start)->format('l, F j, Y \a\t h:i A');

        if ($event->sales->count() <= 0)
        {
          Session::flash('success',
              "The <strong>{$event->type->name}</strong> show <strong>{$event->show->name}</strong> on <strong>{$date}</strong> has been deleted successfully!");
          $event->memos()->delete();
          $event->delete();
        }
        else
        {
          $word = $event->sales->count() == 1 ? 'sale' : 'sales';
          Session::flash('info',
          "The <strong>{$event->type->name} {$event->show->name}</strong> on <strong>{$date}</strong> cannot be deleted because it contains {$event->sales->count()} {$word} that depend on it");
        }

        $date = Date::parse($event->start)->format('Y-m-d');

        // Log deleted event
        Log::info(Auth::user()->fullname . ' deleted Event #' . $event->id .' using admin');

        return redirect()->to(route('admin.calendar.index') . '?date=' . $date . '&view=agendaDay');
    }
}
