<?php

namespace App\Http\Controllers\Admin;

use App\TicketType;
use App\EventType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Session;

class TicketTypeController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TicketType  $ticketType
     * @return \Illuminate\Http\Response
     */
    public function show(TicketType $ticketType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TicketType  $ticketType
     * @return \Illuminate\Http\Response
     */
    public function edit(TicketType $ticketType)
    {
        $eventTypes = EventType::where('name', '!=', 'system')->get();
        return view('admin.ticket-types.edit')->with('ticketType', $ticketType)->with('eventTypes', $eventTypes);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TicketType  $ticketType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TicketType $ticketType)
    {
      $this->validate($request, [
        'name'                => 'required',
        'price'               => 'required|numeric',
        'allowed_in_events.*' => 'required',
        'active'              => 'required',
        'description'         => 'required|max:255'
      ]);

      $ticketType->allowedEvents()->detach();

      $allowed_in_events = [];

      $ticketType->name        = $request->name;
      $ticketType->price       = number_format($request->price, 2);
      $ticketType->active      = $request->active;
      $ticketType->description = $request->description;

      $ticketType->save();

      $ticketType->allowedEvents()->attach($request->allow_in_events);

      Session::flash('success', 'Ticket Type <strong>'. $ticketType->name .'</strong> edited successfully!');

      return redirect()->to(route('admin.settings.index').'#ticket-types');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TicketType  $ticketType
     * @return \Illuminate\Http\Response
     */
    public function destroy(TicketType $ticketType)
    {
        //
    }
}
