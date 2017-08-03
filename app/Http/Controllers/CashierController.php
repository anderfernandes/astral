<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Event;
use Jenssegers\Date\Date;
use App\Sale;
use App\Ticket;
use Session;

class CashierController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }

    public function index()
    {
      // Get the authenticated user
      $user = Auth::user();
      // Get today's date for the query that will show today's events
      $today = Date::now('America/Chicago')->addMinutes(-30)->toDateTimeString();
      // Get all events going on today
      $events = Event::where('start','>=', $today)
                  ->where('start','<=', Date::now('America/Chicago')->endOfDay())
                  ->orderBy('start', 'asc')
                  ->get();
      return view('cashier.index')->withUser($user)->withEvents($events);
    }

    public function store(Request $request)
    {

      $ticket = new Ticket;

      

      $sale = new Sale;

      $sale->save();

      // $ticket->sale()->associate($ticket);

      $sale->payment_method = $request->payment_method;
      $sale->reference = $request->reference;
      $sale->subtotal = $request->subtotal;
      $sale->total = $request->total;
      $sale->source = "cashier";


      foreach($request->input('ticket') as $t) {

        $ticketsPurchased[] = [
          'type'        => $t['ticket_type'],
          'show_id'     => $t['show_id'],
          'price'       => number_format($t['price'], 2),
          'event_id'    => $t['event_id'],
          'customer_id' => 999,
          'cashier_id'  => Auth::user()->id,
        ];
      }

      // $tickets = $request->get('ticket');

      $sale->tickets()->createMany($ticketsPurchased);

      Session::flash('success', count($request->input('ticket')). ' ticket(s) sold successfully');



      return redirect()->route('cashier.index');


    }
}
