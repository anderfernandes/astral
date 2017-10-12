<?php

namespace App\Http\Controllers\Admin;

use App\Sale;
use Illuminate\Http\Request;

use Session;
use Jenssegers\Date\Date;
Use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

use App\User;
use App\Organization;
use App\Event;
use App\Show;
use App\Payment;
use App\PaymentMethod;
use App\Ticket;
use App\TicketType;


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
        return view('admin.sales.index')->withSales($sales);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $organizations = Organization::all();
        $customers = User::all();
        $events    = Event::where('start', '>', Date::now()->toDateTimeString())->get();
        $paymentMethods = PaymentMethod::all();
        $ticketTypes = TicketType::all();

        /*$customers = $allCustomers->mapWithKeys(function ($item) {
          return [ $item['id'] => $item['firstname'].' '.$item['lastname']];
        });

        /*$events = $allEvents->mapWithKeys(function($item) {
          $show = Show::find($item['show_id'])->name;
          $date = Date::parse($item['start'])->format('l, F j, Y \a\t g:i A');
          return [ $item['id'] => $show .' on '. $date];
        });*/

        return view('admin.sales.create')
          ->withCustomers($customers)
          ->withEvents($events->all())
          ->withTicketTypes($ticketTypes)
          ->withPaymentMethods($paymentMethods)
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

        if ($request->organization_id != User::find($request->customer_id)->organization_id) {

          return redirect()->route('admin.sales.create')
            ->withErrors('User '.User::find($request->customer_id)->firstname.' '.User::find($request->customer_id)->lastname.' does not belong to organization '.Organization::find($request->organization_id)->name);
        }

        else {

          $this->validate($request, [
            'organization_id'   => 'required',
            'customer_id'       => 'required',
            'status'            => 'required',
            'first_event_id'    => 'required|different:second_event_id',
            'tendered'          => 'numeric',
            'ticket.*'          => 'numeric',
            'memo'              => 'max:255',
          ]);

          // Create new sale
          $sale = new Sale;

          $sale->creator_id        = Auth::user()->id;
          $sale->organization_id   = $request->organization_id;
          $sale->customer_id       = $request->customer_id;
          $sale->status            = $request->status;
          $sale->taxable           = $request->taxable;
          $sale->subtotal          = number_format($request->subtotal, 2);
          $sale->tax               = number_format($request->tax, 2);
          $sale->total             = number_format($request->total, 2);
          $sale->refund            = false;
          $sale->memo              = $request->memo;
          $sale->first_event_id    = $request->first_event_id;
          $sale->second_event_id   = $request->second_event_id;
          $sale->source            = "admin";

          $sale->save();

          if (isSet($request->payment_method_id) && ($request->tendered > 0)) {

            // Create new payment
            $payment = new Payment;

            $payment->cashier_id        = Auth::user()->id;
            $payment->payment_method_id = $request->payment_method_id;
            // Tendered may be nullable if the customer hasn't paid
            $payment->tendered          = number_format($request->tendered, 2);
            $payment->total             = number_format($request->total, 2);
            // payment = total - tendered (precision set to two decimal places)
            $payment->change_due        = number_format($request->change_due, 2);
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
              $array['event_id'] = $request->first_event_id;
              $array['customer_id'] = $request->customer_id;
              $array['cashier_id'] = Auth::user()->id;

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
        $organizations = Organization::all();
        $customers = User::all();
        $events    = Event::where('start', '>', Date::now()->toDateTimeString())->get();
        $paymentMethods = PaymentMethod::all();
        $ticketTypes = TicketType::all();

        // $customers = $allCustomers->mapWithKeys(function ($item) {
        //   return [ $item['id'] => $item['firstname'].' '.$item['lastname']];
        // });

        return view('admin.sales.edit')
          ->withCustomers($customers)
          ->withEvents($events->all())
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
      if ($request->organization_id != User::find($request->customer_id)->organization_id) {

        return redirect()->route('admin.sales.create')
          ->withErrors('User '.User::find($request->customer_id)->firstname.' '.User::find($request->customer_id)->lastname.' does not belong to organization '.Organization::find($request->organization_id)->name);
      }

      else {

        $this->validate($request, [
          'organization_id'   => 'required',
          'customer_id'       => 'required',
          'status'            => 'required',
          'first_event_id'    => 'required|different:second_event_id',
          'tendered'          => 'numeric',
          'ticket.*'          => 'numeric',
          'memo'              => 'max:255',
        ]);

        $sale->creator_id        = Auth::user()->id;
        $sale->organization_id   = $request->organization_id;
        $sale->customer_id       = $request->customer_id;
        $sale->status            = $request->status;
        $sale->taxable           = $request->taxable;
        $sale->subtotal          = number_format($request->subtotal, 2);
        $sale->tax               = number_format($request->tax, 2);
        $sale->total             = number_format($request->total, 2);
        $sale->refund            = false;
        $sale->memo              = $request->memo;
        $sale->first_event_id    = $request->first_event_id;
        $sale->second_event_id   = $request->second_event_id;

        $sale->save();

        if (isSet($request->payment_method_id) && ($request->tendered > 0)) {

          // Create new payment
          $payment = new Payment;

          $payment->cashier_id        = Auth::user()->id;
          $payment->payment_method_id = $request->payment_method_id;
          // Tendered may be nullable if the customer hasn't paid
          $payment->tendered          = number_format($request->tendered, 2);
          $payment->total             = number_format($request->total, 2);
          // payment = total - tendered (precision set to two decimal places)
          $payment->change_due        = number_format($request->change_due, 2);
          $payment->reference         = $request->reference;
          $payment->source            = 'admin';
          $payment->sale_id           = $sale->id;

          $payment->save();

        }

        // Update tickets only if its number changes
        if (count($request->tickets) != count($sale->tickets)) {
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
              $array['event_id'] = $request->first_event_id;
              $array['customer_id'] = $request->customer_id;
              $array['cashier_id'] = Auth::user()->id;

              $firstShowTickets = array_prepend($firstShowTickets, $array);
            }
          }

          // Update first show tickets to the database
          $sale->tickets()->createMany($firstShowTickets);



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
        }

        Session::flash('success', 'Sale #'. $sale->id .' updated successfully!');

        return redirect()->route('admin.sales.index');

      }

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

    public function refund(Request $request, Sale $sale)
    {
      // Pending server side validation

      $sale->refund = true;
      $sale->memo   = $request->memo;

      $sale->save();


      Session::flash('success',
          'Sale # '.$sale->id.' has been refunded successfully!');

      return redirect()->route('admin.sales.show', $sale);
    }
}
