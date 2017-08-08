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

      $this->validate($request, [
        'payment_method'        => 'required',
        'reference'             => 'nullable',
        'ticket.*.type'         => 'required',
        'ticket.*.price'        => 'required',
        'ticket.*.event_id'     => 'required',
        'ticket.*.cashier_id'   => 'required',
        'ticket.*.customer_id'  => 'required',
      ]);

      $sale = new Sale;

      $sale->cashier_id     = Auth::user()->id;
      $sale->payment_method = $request->payment_method;
      $sale->reference      = $request->reference;
      $sale->subtotal       = $request->subtotal;
      $sale->total          = $request->total;
      $sale->source         = "cashier";

      $sale->save();

      $ticketsInput = $request->get('ticket');

      $tickets = [];

      foreach($ticketsInput as $ticket){
        $tickets[] = new Ticket($ticket);
      }

      $sale->tickets()->saveMany($tickets);

      Session::flash('success', count($request->input('ticket')). ' ticket(s) sold successfully');

      return redirect()->route('cashier.index');

    }

    public function query(Request $request, Sale $query)
    {

      $results = \DB::table('sales');

      if ($request->query_id)
        $results = $results->where('id', $request->query_id);
      else
        $results;

      if ($request->query_total)
        $results = $results->where('total', $request->query_total);
      else
        $results;

      if ($request->query_payment_method)
        $results = $results->where('payment_method', $request->query_payment_method);
      else
        $results;

      if ($request->query_reference)
        $results = $results->where('reference', $request->query_reference);
      else
        $results;

      return view('cashier.query')->withResults($results->get());
    }
}
