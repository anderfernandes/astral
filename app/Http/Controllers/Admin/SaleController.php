<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Session;
use Jenssegers\Date\Date;
Use Illuminate\Support\Facades\Auth;

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
        $sales = Sale::orderBy('id', 'desc')->paginate(10);
        $eventTypes = EventType::where('id', '!=', 1)->get();
        return view('admin.sales.index')->withSales($sales)->withEventTypes($eventTypes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(EventType $eventType)
    {
        $organizations  = Organization::pluck('name', 'id');
        $events         = Event::where('type_id', $eventType->id)
                               ->where('start', '>=', Date::now()->subDays(7)->toDateTimeString())
                               ->orderBy('start', 'asc')
                               ->get();
        $paymentMethods = PaymentMethod::all();
        $ticketTypes    = $eventType->allowedTickets;

        /*$customers = $allCustomers->mapWithKeys(function ($item) {
          return [ $item['id'] => $item['firstname'].' '.$item['lastname']];
        });

        /*$events = $allEvents->mapWithKeys(function($item) {
          $show = Show::find($item['show_id'])->name;
          $date = Date::parse($item['start'])->format('l, F j, Y \a\t g:i A');
          return [ $item['id'] => $show .' on '. $date];
        });*/

        return view('admin.sales.create')
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
            'first_event_id'       => 'min:1|required|different:second_event_id',
            'second_event_id'      => 'min:1',
            'tendered'             => 'numeric',
            'ticket.*'             => 'numeric',
            'memo'                 => 'max:255',
            'sell_to_organization' => 'required',
          ]);

          // Create new sale
          $sale = new Sale;

          $sale->creator_id           = Auth::user()->id;
          $sale->organization_id      = $request->organization_id;
          $sale->customer_id          = $request->customer_id;
          $sale->status               = $request->status;
          $sale->taxable              = $request->taxable;
          $sale->subtotal             = round($request->subtotal, 2);
          $sale->tax                  = round($request->tax, 2);
          $sale->total                = round($request->total, 2);
          $sale->refund               = false;
          //$sale->memo                 = $request->memo;
          $sale->source               = "admin";
          $sale->sell_to_organization = ($request->organization_id == 1) ? false : true;

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

          }

          // Store tickets in the database

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

          return redirect()->route('admin.sales.index');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        return view('admin.sales.show')->withSale($sale);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        $organizations = Organization::pluck('name', 'id');
        $events    = Event::where('type_id', $sale->events[0]->type->id)->orderBy('start', 'asc')->get();
        $paymentMethods = PaymentMethod::all();
        $ticketTypes = $sale->events[0]->type->allowedTickets;

        // $customers = $allCustomers->mapWithKeys(function ($item) {
        //   return [ $item['id'] => $item['firstname'].' '.$item['lastname']];
        // });

        return view('admin.sales.edit')
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

        $sale->organization_id      = $request->organization_id;
        $sale->customer_id          = $request->customer_id;
        $sale->status               = $request->status;
        $sale->taxable              = $request->taxable;
        $sale->subtotal             = round($request->subtotal, 2);
        $sale->tax                  = round($request->tax, 2);
        $sale->total                = round($request->total, 2);
        $sale->refund               = false;
        //$sale->memo                 = $request->memo;
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

        Session::flash('success', 'Sale #'. $sale->id .' updated successfully!');

        return redirect()->route('admin.sales.index');

        //dd(array_sum($request->ticket));


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

    // THIS METHODS REFUNDS SALES, NOT PAYMENTS
    public function refund(Request $request, Sale $sale)
    {
      // Pending server side validation

      $sale->refund = true;
      $sale->memo()->create([
        'author_id' => Auth::user()->id,
        'message'   => $request->memo,
        'sale_id'   => $sale->id,
      ]);

      // Add a negative payment of the sum of payments for this sale to even out



      $refund =  new Payment([
        'cashier_id'        => Auth::user()->id,
        'payment_method_id' => $sale->payments[0]->payment_method_id,
        'tendered'          => - round($sale->payments[0]->sum('tendered'), 2),
        'total'             => - round($sale->payments[0]->sum('total'), 2),
        'change_due'        => - round($sale->payments[0]->sum('change_due'), 2),
        'source'            => 'admin',
        'sale_id'           => $sale->payments[0]->sale_id,
      ]);

      $sale->payments()->save($refund);

      $sale->status = "complete";

      $sale->save();


      Session::flash('success',
          'Sale # '.$sale->id.' has been refunded successfully!');

      return redirect()->route('admin.sales.show', $sale);
    }

    // THIS METHOD REFUNDS INDIVIDUAL PAYMENTS, NOT SALES
    public function refundPayment(Payment $payment)
    {

      $refund = new Payment;

      $sale = Sale::find($payment->sale_id);

      $refund->cashier_id        = Auth::user()->id;
      $refund->payment_method_id = $payment->payment_method_id;
      // Tendered may be nullable if the customer hasn't paid
      $refund->tendered          = - round($sale->payments->sum('tendered'), 2);
      $refund->total             = - round($sale->payments->sum('total'), 2);
      // payment = total - tendered (precision set to two decimal places)
      $refund->change_due        = - round($payment->change_due, 2);
      $refund->reference         = $payment->reference;
      $refund->source            = 'admin';
      $refund->sale_id           = $payment->sale_id;

      $refund->save();

      Session::flash('success',
          'Payment # ' . $refund->id . ' has been refunded successfully!');

      return redirect()->route('admin.sales.show', $payment->sale_id);

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
