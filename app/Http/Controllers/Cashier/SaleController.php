<?php

namespace App\Http\Controllers\Cashier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Session;
use Jenssegers\Date\Date;

Use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\Sale;
use App\User;
use App\Organization;
use App\Event;
use App\Show;
use App\Payment;
use App\PaymentMethod;
use App\Ticket;
use App\TicketType;
use App\EventType;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $today = Date::now();
        // Return open sales who are coming for an event happening today
        $events = Event::whereDate('start', $today->format('Y-m-d'))->get();
        $todaySalesIds = [];
        foreach($events as $event) {
          foreach($event->sales as $sale) {
              array_push($todaySalesIds, $sale->id);
              $todaySalesIds = array_unique($todaySalesIds);
          }
        }

        $sales = Sale::whereIn('id', $todaySalesIds)->orderBy('id', 'desc')->paginate(10);

        return view('cashier.sales.index')->withSales($sales);
        //dd($sales);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $organizations = Organization::pluck('name', 'id');
        $events        = Event::where('type_id', $request->eventType)
                           ->where('start', '>=', Date::now()->subDays(7)->toDateTimeString())
                           ->orderBy('start', 'asc')
                           ->get();
        $paymentMethods = PaymentMethod::all();
        $eventType = EventType::find($request->eventType);
        $ticketTypes    = $eventType->allowedTickets;

        /*$customers = $allCustomers->mapWithKeys(function ($item) {
          return [ $item['id'] => $item['firstname'].' '.$item['lastname']];
        });

        /*$events = $allEvents->mapWithKeys(function($item) {
          $show = Show::find($item['show_id'])->name;
          $date = Date::parse($item['start'])->format('l, F j, Y \a\t g:i A');
          return [ $item['id'] => $show .' on '. $date];
        });*/

        return view('cashier.sales.create')
          ->withEvents($events)
          ->withTicketTypes($ticketTypes)
          ->withPaymentMethods($paymentMethods)
          ->withEventType($eventType)
          ->withOrganizations($organizations);
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
          'organization_id'      => 'required',
          'customer_id'          => 'required',
          'status'               => 'required',
          'first_event_id'       => 'required|different:second_event_id',
          'tendered'             => 'numeric',
          'ticket.*'             => 'numeric',
          'memo'                 => 'max:255',
          'sell_to_organization' => 'required',
        ]);

        // Create new sale
        $sale = new Sale;

        $sale->creator_id        = Auth::user()->id;
        $sale->organization_id   = $request->organization_id;
        $sale->customer_id       = $request->customer_id;
        $sale->status            = $request->status;
        $sale->taxable           = $request->taxable;
        $sale->subtotal          = round($request->subtotal, 2);
        $sale->tax               = round($request->tax, 2);
        $sale->total             = round($request->total, 2);
        $sale->refund            = false;
        //$sale->memo              = $request->memo;
        $sale->source            = "admin";
        $sale->sell_to_organization = $request->sell_to_organization;

        $sale->save();

        $sale->events()->attach([$request->first_event_id, $request->second_event_id]);

        if (isSet($request->memo))
        {
          $sale->memo()->create([
            'author_id' => Auth::user()->id,
            'message'   => $request->memo,
            'sale_id'   => $sale->id,
          ]);
        }

        if (isSet($request->payment_method_id) && ($request->tendered > 0)) {

          // Create new payment
          $payment = new Payment;

          $payment->cashier_id        = Auth::user()->id;
          $payment->payment_method_id = $request->payment_method_id;
          // Tendered may be nullable if the customer hasn't paid
          $payment->tendered          = round($request->tendered, 2);
          $payment->total             = round($request->total, 2);
          // payment = total - tendered (precision set to two decimal places)
          $payment->change_due        = round($request->change_due, 2);
          $payment->reference         = $request->reference;
          $payment->source            = 'admin';
          $payment->sale_id           = $sale->id;

          $payment->save();

          // Log added payment
          Log::info(Auth::user()->fullname . ' added Payment #' . $payment->id . ' to Sale #' . $sale->id .' using cashier');

        }

        // Mark sale as completed if it has been paid in full
        if ($sale->payments->sum('tendered') >= $sale->total) {
          $sale->status = "complete";
          $sale->save();
        }

        // Holds the tickets coming from the request
        $firstShowTickets  = [];

        // Create array with all tickets for the first show if the amount of
        // tickets for a ticket type is not zero
        foreach($request->ticket as $key => $value) {
          for($i = 1; $i <= $value; $i++) {
            $array['ticket_type_id'] = $key;
            $array['event_id']       = $request->first_event_id;
            $array['customer_id']    = $request->customer_id;
            $array['cashier_id']     = Auth::user()->id;

            $firstShowTickets = array_prepend($firstShowTickets, $array);
          }
        }

        /*********************************************************************
        A NOTE ON TICKET UPDATES!
        Tickets are not actually updated because their number may change.
        The previous tickets created are deleted and new ones are created
        every time a sale is updated to ensure that each ticket has the right
        event, sale number and owner.
        *********************************************************************/

        // Add first show tickets to the database
        $sale->tickets()->createMany($firstShowTickets);

        // add second show tickets if a second show exists
        if ($request->second_event_id != 1) {
          // If it does, create and array with all the tickets for the second
          // show if the amount of tickets for a ticket type is not zero

          // Create array with second show tickets
          $secondShowTickets = [];

          // Populate the array
          foreach($request->ticket as $key => $value) {
            for($i = 1; $i <= $value; $i++) {
              $array['ticket_type_id'] = $key;
              $array['event_id'] = $request->second_event_id;
              $array['customer_id'] = $request->customer_id;
              $array['cashier_id'] = Auth::user()->id;
              $secondShowTickets = array_prepend($secondShowTickets, $array);
            }
          }

          // Save to the database
          $sale->tickets()->createMany($secondShowTickets);
        }

        Session::flash('success', 'Sale #'. $sale->id .' created successfully!');

        // Log created sale
        Log::info(Auth::user()->fullname . ' created Sale #' . $sale->id .' using cashier');

        return redirect()->route('cashier.sales.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        $paid = number_format($sale->payments->sum('tendered') - $sale->payments->sum('change_due'), 2);
        $balance = number_format(($sale->payments->sum('tendered') - $sale->payments->sum('change_due')) - $sale->total, 2);
        $memos = \App\SaleMemo::where('sale_id', $sale->id)->orderBy('updated_at', 'desc')->get();
        return view('cashier.sales.show')->withSale($sale)
                                       ->withPaid($paid)
                                       ->withMemos($memos)
                                       ->withBalance($balance);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
      $organizations  = Organization::pluck('name', 'id');
      $events    = Event::where('type_id', $sale->events[0]->type->id)->orderBy('start', 'asc')->get();
      $paymentMethods = PaymentMethod::all();
      $ticketTypes    = $sale->events[0]->type->allowedTickets;

      // $customers = $allCustomers->mapWithKeys(function ($item) {
      //   return [ $item['id'] => $item['firstname'].' '.$item['lastname']];
      // });

      return view('cashier.sales.edit')
        ->withEvents($events)
        ->withTicketTypes($ticketTypes)
        ->withPaymentMethods($paymentMethods)
        ->withOrganizations($organizations)
        ->withSale($sale);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale)
    {

        $this->validate($request, [
          'organization_id'      => 'required',
          'customer_id'          => 'required',
          'status'               => 'required',
          'first_event_id'       => 'required|different:second_event_id',
          'tendered'             => 'numeric',
          'ticket.*'             => 'numeric',
          'memo'                 => 'max:255',
          'sell_to_organization' => 'required',
        ]);

        $sale->organization_id   = $request->organization_id;
        $sale->customer_id       = $request->customer_id;
        $sale->status            = $request->status;
        $sale->taxable           = $request->taxable;
        $sale->subtotal          = round($request->subtotal, 2);
        $sale->tax               = round($request->tax, 2);
        $sale->total             = round($request->total, 2);
        $sale->refund            = false;
        //$sale->memo              = $request->memo;
        $sale->sell_to_organization = $request->sell_to_organization;

        $sale->save();

        $sale->events()->detach();

        $sale->events()->attach([$request->first_event_id, $request->second_event_id]);

        if (isSet($request->memo))
        {
          $sale->memo()->create([
            'author_id' => Auth::user()->id,
            'message'   => $request->memo,
            'sale_id'   => $sale->id,
          ]);
        }

        if (isSet($request->payment_method_id) && ($request->tendered > 0)) {

          // Create new payment
          $payment = new Payment;

          $payment->cashier_id        = Auth::user()->id;
          $payment->payment_method_id = $request->payment_method_id;
          // Tendered may be nullable if the customer hasn't paid
          $payment->tendered          = round($request->tendered, 2);
          $payment->total             = round($request->total, 2);
          // payment = total - tendered (precision set to two decimal places)
          $payment->change_due        = round($request->change_due, 2);
          $payment->reference         = $request->reference;
          $payment->source            = 'admin';
          $payment->sale_id           = $sale->id;

          $payment->save();

          // Log created payment
          Log::info(Auth::user()->fullname . ' added Payment #' . $payment->id . ' to Sale #' . $sale->id .' using cashier');

        }

        // Mark sale as completed if it has been paid in full
        if ($sale->payments->sum('tendered') >= $sale->total) {
          $sale->status = "complete";
          $sale->save();
        }

        // Update tickets only if its number changes
        if (array_sum($request->ticket) != $sale->tickets->count()) {
          // Delete old tickets created
          $sale->tickets()->delete();

          // Store updated tickets in the database

          // Holds the tickets coming from the request
          $firstShowTickets  = [];

          // Create array with all tickets for the first show if the amount of
          // tickets for a ticket type is not zero
          foreach($request->ticket as $key => $value) {
            for($i = 1; $i <= $value; $i++) {
              $array['ticket_type_id'] = $key;
              $array['event_id']       = $request->first_event_id;
              $array['customer_id']    = $request->customer_id;
              $array['cashier_id']     = Auth::user()->id;

              $firstShowTickets = array_prepend($firstShowTickets, $array);
            }
          }

          // Update first show tickets to the database
          $sale->tickets()->createMany($firstShowTickets);

        }

        // Check if a second show exists
        if ($request->second_event_id != 1) {
          // If it does, create and array with all the tickets for the second
          // show if the amount of tickets for a ticket type is not zero

          // Create array with second show tickets
          $secondShowTickets = [];

          // Populate the array
          foreach($request->ticket as $key => $value) {
            for($i = 1; $i <= $value; $i++) {
              $array['ticket_type_id'] = $key;
              $array['event_id'] = $request->second_event_id;
              $array['customer_id'] = $request->customer_id;
              $array['cashier_id'] = Auth::user()->id;
              $secondShowTickets = array_prepend($secondShowTickets, $array);
            }
          }

          // Save to the database
          $sale->tickets()->createMany($secondShowTickets);
        }

        Session::flash('success', '<strong>Sale #'. $sale->id .'</strong> updated successfully!');

        // Log created sale
        Log::info(Auth::user()->fullname . ' updated Sale #' . $sale->id .' using cashier');

        return redirect()->route('cashier.sales.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        //
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
        /*
        Payment information and Sale information come from two different tables,
        thus the need for the code below. Also, I want to return them as an instance
        of Eloquent, which allows Astral to query relationships.
        */

        if ($request->query_payment_method)
        {
          $sales = \DB::table('payments')->where('payment_method_id', $request->query_payment_method)->get(['sale_id'])->toArray();
          $results = \DB::table('sales')->whereIn('id', array_pluck($sales, 'sale_id'));
        }

        else if ($request->query_reference)
        {
          $sales = \DB::table('payments')->where('reference', $request->query_reference)->get(['sale_id'])->toArray();
          $results = \DB::table('sales')->whereIn('id', array_pluck($sales, 'sale_id'));
        }

        else if ($request->query_payment_method && $request->query_reference) {
          $sales = \DB::table('payments')
            ->where('payment_method_id', $request->query_payment_method)
            ->where('reference', $request->query_reference);
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
        }

        $results = $results->get();
        $resultsSalesIds = array_pluck($results, 'id');
        $results = Sale::whereIn('id', $resultsSalesIds);

        return view('cashier.query')->withResults($results->where('created_at', '>=', Date::now('America/Chicago')->startOfDay())->get());

      }
    }
    public function confirmation(Sale $sale)
    {
      return view('admin.sales.confirmation')->withSale($sale);
    }

    public function invoice(Sale $sale)
    {
      return view('admin.sales.invoice')->withSale($sale);
    }

    public function receipt(Sale $sale)
    {
      return view('admin.sales.receipt')->withSale($sale);
    }

    public function cancelation(Sale $sale)
    {
      return view('admin.sales.cancelation')->withSale($sale);
    }
}
