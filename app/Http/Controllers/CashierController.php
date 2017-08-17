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

    public function reports($type) {

      $today = Date::now()->startOfDay();
      // REPORT STARTING POINT MUST BE GREATER THAN TODAY!!!
      $sales = Sale::where('created_at', '>=', $today);
      $sales = $sales->where('cashier_id', Auth::user()->id)->get();

      if ($type == 'closeout')
      {

        // Cash Sales
        $cashSales = Sale::where([
          ['created_at', '>=', $today],
          ['cashier_id', '=', Auth::user()->id],
          ['payment_method', '=', 'cash'],
          ['refund', '=', false],
          ])->get();
        // Card Sales
        $cardSales = Sale::where([
          ['created_at', '>=', $today],
          ['cashier_id', '=', Auth::user()->id],
          ['payment_method', '<>', 'cash'],
          ['refund', '=', false],
          ]);
        $cardSales = $cardSales->where('payment_method', '<>', 'check')->get();
        // Check Sales
        $checkSales = Sale::where([
          ['created_at', '>=', $today],
          ['cashier_id', '=', Auth::user()->id],
          ['payment_method', '=', 'check'],
          ['refund', '=', false],
          ])->get();

        return view('cashier.reports.closeout')->with('cashSales', $cashSales)->with('cardSales', $cardSales)->with('checkSales', $checkSales);
      }
      if ($type == 'transaction-detail')
      {
        return view('cashier.reports.transaction-detail')->withSales($sales);
      }
    }

    public function store(Request $request)
    {

      $this->validate($request, [
        'payment_method'        => 'required',
        'reference'             => 'nullable',
        'tendered'              => 'required',
        'ticket.*.type'         => 'required',
        'ticket.*.price'        => 'required',
        'ticket.*.event_id'     => 'required',
        'ticket.*.cashier_id'   => 'required',
        'ticket.*.customer_id'  => 'required',
      ]);

      $ticketsInput = $request->get('ticket');

      $tickets = [];

      if (count($ticketsInput) <= 0) {
        Session::flash('error', 'You cannot sell 0 tickets, silly!');
        return redirect()->route('cashier.index');
      }

      else {

        $sale = new Sale;

        $sale->cashier_id     = Auth::user()->id;
        $sale->payment_method = $request->payment_method;
        $sale->reference      = $request->reference;
        $sale->subtotal       = $request->subtotal;
        $sale->total          = $request->total;
        $sale->tendered       = $request->tendered;
        $sale->change_due     = $request->tendered - $request->total;
        $sale->source         = "cashier";
        $sale->refund         = false;
        $sale->customer_id     = 2; // this assigns all cashier sales to walk ups

        $sale->save();



        foreach($ticketsInput as $ticket) {
          $tickets[] = new Ticket($ticket);
        }

        $sale->tickets()->saveMany($tickets);

        Session::flash('success', count($request->input('ticket')). ' ticket(s) sold successfully');

        return redirect()->route('cashier.index');
      }

    }

    public function query(Request $request)
    {
      // Preventing all sales data from being pulled up
      if( !$request->query_id && !$request->query_total && !$request->query_payment_method && !$request->query_reference)
      {
        $results = null;

        return view('cashier.query')->withResults($results);
      }
      else
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

        return view('cashier.query')->withResults($results->where('created_at', '>=', Date::now('America/Chicago')->startOfDay())->get());
      }
    }
    
    // This controller will return a view with sale information
    
    public function sale(Sale $sale)
    {
        return view('cashier.sale')->withSale($sale);
    }
}
