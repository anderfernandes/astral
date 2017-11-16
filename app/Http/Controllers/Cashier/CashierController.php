<?php

namespace App\Http\Controllers\Cashier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

    public function store(Request $request)
    {

      $this->validate($request, [
        'payment_method'           => 'required',
        'reference'                => 'nullable|numeric',
        //'tendered'                 => 'required|numeric',
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
        $payment->tendered          = round($request->tendered, 2);
        $payment->total             = round($request->total, 2);
        // payment = total - tendered (precision set to two decimal places)
        $payment->change_due        = round($request->tendered - $request->total, 2);
        $payment->reference         = $request->reference;
        $payment->source            = 'cashier';
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
}
