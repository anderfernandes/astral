<?php

namespace App\Http\Controllers\Cashier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\{ Auth, Log };
use App\{ Event, Sale, Ticket, Payment, PaymentMethod, User, Setting };

use Jenssegers\Date\Date;
use Session;

class CashierController extends Controller
{

    public function index()
    {
      // Get the authenticated user
      $user = Auth::user();
      // Get today's date for the query that will show today's events
      // $today = Date::now('America/Chicago')->addMinutes(-30)->toDateTimeString();
      $startOfDay = Date::now('America/Chicago')->startOfDay()->toDateTimeString();
      $endOfDay = Date::now('America/Chicago')->endOfDay()->toDateTimeString();
      // Get all events going on today
      $events = Event::where('show_id', '!=', 1)
                     ->where([['start', '>=', $startOfDay], ['start', '<=', $endOfDay]])
                     ->orderBy('start', 'asc')
                     ->get();
      // Get Available Payment Methods
      $paymentMethods = PaymentMethod::all();

      $settings = Setting::find(1);
      
      $allCustomers = $settings->cashier_customer_dropdown
                      ? User::where('membership_id', '!=', 1)->orWhere('id', 1)->get()
                      : User::all();

      if ($settings->cashier_customer_dropdown)
        $customers = $allCustomers->mapWithKeys(function ($item) 
        {
          if ($item['id'] == 1)
            $data = $item['fullname'];
          else
            $data = "{$item['membership_number']} {$item['fullname']}";
          return [ $item['id'] => $data];
        });
      else
        $customers = $allCustomers->mapWithKeys(function ($item) { 
          return [ $item['id'] => $item['fullname']];
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
        'tendered'                 => 'numeric|min:'.$request->total,
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

        $sale->creator_id           = Auth::user()->id;
        $sale->subtotal             = $request->subtotal;
        $sale->total                = $request->total;
        $sale->organization_id      = User::find($request->customer_id)->organization->id;
        $sale->source               = "cashier";
        $sale->refund               = false;
        $sale->customer_id          = $request->customer_id;
        $sale->status               = 'complete';
        $sale->tax                  = $request->total - $request->subtotal;
        $sale->taxable              = ($sale->tax > 0) ? true : false;
        $sale->sell_to_organization = false;

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

        if (isSet($request->memo))
        {
          $sale->memo()->create([
            'author_id' => Auth::user()->id,
            'message'   => $request->memo,
          ]);
        }

        Session::flash('success', count($request->input('ticket')). ' ticket(s) sold successfully');

        // Log created sale
        Log::info(Auth::user()->fullname . ' created Sale #' . $sale->id .' using cashier');

        return redirect()->route('cashier.index');

      }

    }
}
