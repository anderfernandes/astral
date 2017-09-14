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
        // Pending validation

        $sale = new Sale;

        $sale->creator_id        = Auth::user()->id;
        $sale->status            = $request->status;
        $sale->total             = $request->total;
        $sale->refund            = false;
        $sale->customer_id       = $request->customer_id;
        $sale->memo              = $request->memo;

        $sale->save();

        $payment = new Payment;

        $payment->cashier_id        = Auth::user()->id;
        $payment->payment_method_id = $request->payment_method_id;
        $payment->tendered          = $request->tendered;
        $payment->subtotal          = $request->subtotal;
        $payment->total             = $request->total;
        // payment = total - tendered (precision set to two decimal places)
        $payment->change_due        = number_format(number_format($request->total, 2) - number_format($request->total, 2), 2);
        $payment->reference         = $request->reference;
        $payment->source            = $request->source;
        $payment->sale_id           = $sale->id;

        $payment->save;

        // Store tickets in the database

        $tickets = [];

        if (count($request->tickets) <= 0) {
          Session::flash('error', 'You cannot sell 0 tickets, silly!');
          return redirect()->route('admin.sales.create');
        } else {
          foreach ($request->tickets as $ticket) {
            $tickets[] = new Ticket($ticket);

          }
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
