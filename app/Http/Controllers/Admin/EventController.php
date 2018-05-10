<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use App\EventType;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Show;
use Session;
use Jenssegers\Date\Date;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
            'memo'           => 'required',
            'public'         => 'required',
        ]);

        foreach ($request->dates as $date) {

          $event = new Event;

          $event->show_id        = $request->show_id;
          $event->type_id        = $request->type_id;
          $event->start          = new Date($date['start']);
          $event->end            = new Date($date['end']);
          $event->seats          = $request->seats;
          //$event->memo           = $request->memo;
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
          'memo'           => 'required',
          'public'         => 'required',
      ]);

      $event->show_id        = $request->show_id;
      $event->type_id        = $request->type_id;
      $event->start          = new Date($request->dates[0]['start']);
      $event->end            = new Date($request->dates[0]['end']);
      $event->seats          = $request->seats;
      //$event->memo           = $request->memo;
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

        return redirect()->to(route('admin.calendar.index') . '/?type=events&date=' . $date . '&view=agendaDay');
    }
}
