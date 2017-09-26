<?php

namespace App\Http\Controllers\Admin;

use App\Sale;
use Illuminate\Http\Request;

use Session;
use Jenssegers\Date\Date;
Use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

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
        $allCustomers = User::all();
        $allEvents    = Event::where('start', '>', Date::now()->toDateTimeString())->get();
        $paymentMethods = PaymentMethod::all();
        $ticketTypes = TicketType::all();

        $customers = $allCustomers->mapWithKeys(function ($item) {
          return [ $item['id'] => $item['firstname'].' '.$item['lastname']];
        });

        $events = $allEvents->mapWithKeys(function($item) {
          $show = Show::find($item['show_id'])->name;
          $date = Date::parse($item['start'])->format('l, F j, Y \a\t g:i A');
          return [ $item['id'] => $show .' on '. $date];
        });

        return view('admin.sales.create')
          ->withCustomers($customers->all())
          ->withEvents($events->all())
          ->withTicketTypes($ticketTypes)
          ->withPaymentMethods($paymentMethods);
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
          'customer_id'    => 'required',
          'status'         => 'required',
          'first_event_id' => 'required',
          'payment_method_id' => 'required',
          'memo'           => 'max:255'
        ]);

        $sale_total = 0;

        // Create new sale
        $sale = new Sale;

        $sale->creator_id        = Auth::user()->id;
        $sale->customer_id       = $request->customer_id;
        $sale->status            = $request->status;

        // Loop through all the tickets
        foreach($request->ticket as $key => $ticket) {
          // Multiply number of tickets by the price of the ticket
          $sale_total += $request->ticket[$key] * TicketType::find($key)->price;
        }

        $sale->total  = number_format($sale_total, 2);
        $sale->refund = false;
        $sale->memo   = $request->memo;

        $sale->save();

        // Create new payment
        $payment = new Payment;

        $payment->cashier_id        = Auth::user()->id;
        $payment->payment_method_id = $request->payment_method_id;
        // Tendered may be nullable if the customer hasn't paid
        $payment->tendered          = $request->tendered;
        $payment->subtotal          = $request->subtotal;
        $payment->total             = $request->total;
        // payment = total - tendered (precision set to two decimal places)
        $payment->change_due        = number_format(number_format($request->total, 2) - number_format($request->total, 2), 2);
        $payment->reference         = $request->reference;
        $payment->source            = 'back office';
        $payment->sale_id           = $sale->id;

        $payment->save();

        // Store tickets in the database

        $firstShowTickets  = [];
        $secondShowTickets = [];

        //var_dump(isSet($request->second_event_id));

        // Create array with all tickets for the first show if the amount of
        // tickets for a ticket type is not zero
        foreach($request->ticket as $key => $value) {
          for($i = 1; $i <= $value; $i++) {
              $array = [
                'ticket_type_id' => $value,
                'event_id'       => $request->first_event_id,
                'customer_id'    => $request->customer_id,
                'cashier_id'     => Auth::user()->id,
              ];
              $firstShowTickets = array_prepend($firstShowTickets, $array);
          }
        }

        // Check if a second show exists
        if (isSet($request->second_event_id))
          // If it does, create and array with all the tickets for the second
          // show if the amount of tickets for a ticket type is not zero
          foreach($request->ticket as $key => $value) {
            for($i = 1; $i <= $value; $i++) {
                $array = [
                  'ticket_type_id' => $value,
                  'event_id'       => $request->second_event_id,
                  'customer_id'    => $request->customer_id,
                  'cashier_id'     => Auth::user()->id,
                ];
                $secondShowTickets = array_prepend($secondShowTickets, $array);
            }
          }

          //var_dump($firstShowTickets);
          //var_dump($secondShowTickets);

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
        //
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
        //
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
