<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Event;
use Jenssegers\Date\Date;
use App\Sale;
use App\Ticket;
use App\Payment;
use App\PaymentMethod;
use App\User;
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
      // Get Available Payment Methods
      $paymentMethods = PaymentMethod::all();
      $allCustomers = User::all();

      $customers = $allCustomers->mapWithKeys(function ($item) {
        return [ $item['id'] => $item['firstname'].' '.$item['lastname']];
      });

      return view('cashier.index')->withUser($user)
                                  ->withPaymentMethods($paymentMethods)
                                  ->withCustomers($customers)
                                  ->withEvents($events);
    }

    public function reports($type) {

      $today = Date::now()->startOfDay();
      // REPORT STARTING POINT MUST BE GREATER THAN TODAY!!!
      $sales = Sale::where('created_at', '>=', $today)->orderBy('created_at', 'asc');
      $sales = $sales->where('creator_id', Auth::user()->id)->get();

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
        'payment_method'           => 'required',
        'reference'                => 'nullable|integer',
        'tendered'                 => 'required|numeric',
        'customer_id'              => 'required|integer',
        'ticket.*.event_id'        => 'required',
        'ticket.*.cashier_id'      => 'required',
        'ticket.*.ticket_type_id'  => 'required',
      ]);

      //$ticketsInput = $request->get('ticket');

      $tickets = [];

      if (count($request->ticket) <= 0) {
        Session::flash('error', 'You cannot sell 0 tickets, silly!');
        return redirect()->route('cashier.index');
      }

      else {

        $sale = new Sale;

        $sale->creator_id      = Auth::user()->id;
        $sale->taxable         = User::find($request->customer_id)->organization->type->taxable;
        $sale->subtotal        = $request->subtotal;
        $sale->total           = $request->total;
        $sale->organization_id = User::find($request->customer_id)->organization->id;
        $sale->source          = "cashier";
        $sale->refund          = false;
        $sale->customer_id     = $request->customer_id;
        $sale->status          = 'complete';

        $sale->save();

        // Create new payment
        $payment = new Payment;

        $payment->cashier_id        = Auth::user()->id;
        $payment->payment_method_id = $request->payment_method;
        // Tendered may be nullable if the customer hasn't paid
        $payment->tendered          = number_format($request->tendered, 2);
        $payment->total             = number_format($request->total, 2);
        // payment = total - tendered (precision set to two decimal places)
        $payment->change_due        = number_format($request->tendered - $request->total, 2);
        $payment->reference         = $request->reference;
        $payment->source            = 'admin';
        $payment->sale_id           = $sale->id;

        $payment->save();

        // Holds the tickets coming from the request
        $firstShowTickets  = [];

        foreach($request->ticket as $ticket) {
          $array['ticket_type_id'] = $ticket['ticket_type_id'];
          $array['event_id']       = $ticket['event_id'];
          $array['customer_id']    = $request->customer_id;
          $array['cashier_id']     = Auth::user()->id;

          $firstShowTickets = array_prepend($firstShowTickets, $array);
        }

        $sale->tickets()->createMany($firstShowTickets);

        // attach on pivot table
        $eventsListArray = array_unique(array_pluck($firstShowTickets, 'event_id'));
        $sale->events()->attach($eventsListArray);

        //foreach($ticketsInput as $ticket) {
        //  $tickets[] = new Ticket($ticket);
        //}

        $sale->tickets()->saveMany($tickets);

        Session::flash('success', count($request->input('ticket')). ' ticket(s) sold successfully');

        return redirect()->route('cashier.index');

      }

    }

    public function query(Request $request)
    {
      // Preventing all sales data from being pulled up
      if( !$request->query_id && !$request->query_payment_method && !$request->query_total && !$request->query_reference)
      {
        $results = null;

        return view('cashier.query')->withResults($results);
      }
      else
      {

        if ($request->query_payment_method)
        {
          $sales = \DB::table('payments')->where('payment_method_id', $request->query_payment_method)->get(['sale_id'])->toArray();
          $results = \DB::table('sales')->whereIn('id', array_pluck($sales, 'sale_id'));
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

          if ($request->query_reference)
            $results = $results->where('reference', $request->query_reference);
          else
            $results;
        }
        return view('cashier.query')->withResults($results->where('created_at', '>=', Date::now('America/Chicago')->startOfDay())->get());

      }
    }

    // This controller will return a view with sale information

    public function sale(Sale $sale)
    {
        return view('cashier.sale')->withSale($sale);
    }
}
