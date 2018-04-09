<?php

namespace App\Http\Controllers\Admin;

use App\EventType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Session;
use Illuminate\Support\Facades\Auth;

class EventTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
          'name'        => 'required',
          'color'       => 'required',
          'description' => 'required',
        ]);

        $eventType = new eventType;

        $eventType->name        = $request->name;
        $eventType->description = $request->description;
        $eventType->color       = $request->color;

        $eventType->creator_id  = Auth::user()->id;

        $eventType->save();

        Session::flash('success', 'Event Type <strong>'. $eventType->name .'</strong> added successfully!');

        return redirect()->to(route('admin.settings.index').'#event-types');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EventType  $eventType
     * @return \Illuminate\Http\Response
     */
    public function show(EventType $eventType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EventType  $eventType
     * @return \Illuminate\Http\Response
     */
    public function edit(EventType $eventType)
    {
        $colors = [
          'red'    => '#cf3534',
          'orange' => '#f2711c',
          'yellow' => '#fbbd08',
          'olive'  => '#b5cc18',
          'green'  => '#21ba45',
          'teal'   => '#00b5ad',
          'blue'   => '#002e5d',
          'violet' => '#6435c9',
          'purple' => '#a333c8',
          'pink'   => '#e03997',
          'brown'  => '#a5673f',
          'grey'   => '#767676',
          'black'  => '#1b1c1d',
        ];
        return view('admin.event-types.edit')->with('eventType', $eventType)
                                             ->with('colors', $colors);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EventType  $eventType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EventType $eventType)
    {
        $this->validate($request, [
          'name'        => 'required',
          'color'       => 'required',
          'description' => 'required',
        ]);

        $eventType->name        = $request->name;
        $eventType->description = $request->description;
        $eventType->color       = $request->color;

        $eventType->save();

        Session::flash('success', 'Event Type <strong>'. $eventType->name .'</strong> edited successfully!');

        return redirect()->to(route('admin.settings.index').'#event-types');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EventType  $eventType
     * @return \Illuminate\Http\Response
     */
    public function destroy(EventType $eventType)
    {
        //
    }
}
