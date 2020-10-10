<?php

namespace App\Http\Controllers\Api\Publc;

use App\{ Sale, Setting };
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Calculate totals onthe server 
        // ...

        // Define cashier
        $cashier = User::find(1);

        // Find user in database based on email
        $customer = User::find(1);

        $sale = new Sale;

        $sale->creator_id = $cashier->id;
        $sale->organization_id = $customer->organization_id;
        $sale->customer_id = $customer->organization_id;
        $sale->customer_id = $customer->id;
        $sale->status = "complete";
        $sale->taxable = true;
        $sale->subtotal = (double)$request->subtotal;
        $sale->tax = (double)$request->tax;
        $sale->total = (double)$request->total;
        $sale->refund = false;
        $sale->source = "public";
        $sale->sell_to_organization = false;

        $sale->save();

        // Array of events
        $events = [];

        $tickets = [];
        
        foreach ($request->sale as $item)
        {
          //
          foreach ($item["tickets"] as $ticket)
          {
            for ($i = 0; $i < $ticket["amount"]; $i++)
            {
              array_push($tickets, [
                'ticket_type_id'  => $ticket["id"],
                'event_id'        => $ticket["event_id"],
                'customer_id'     => $customer->id,
                'cashier_id'      => $cashier->id,
                'organization_id' => $customer->organization_id,
              ]);
            }
          }

          // Updating array with events  
          array_push($event, $item['event']['id']);
        }

        // Attacthing events to sale
        $sale->events()->attach($events);

        // Attaching tickets to sale
        $sale->tickets()->createMany($tickets);

        $sale->memo()->create([
          'author_id' => $cashier->id,
          'message' => "Purchase created by customer on ticket purchasing portal",
        ]);

        $sale->organization->events()->attach($events);

        // Payment

        $payment = new Payment;

        $payment->cashier_id = $cashier->id;
        $payment->payment_method_id = 1; // create one for stripe???
        $payment->tendered = $sale->total;
        $payment->total = $payment->total;
        $payment->change_due = $payment->tendered - $payment->total;
        $payment->reference = $request->payment_intent;
        $payment->source = "public";

        $sale->payments()->save($payment);

        return response()->json([
          'data' => $sale,
          'message' => 'Payment completed successfully!',
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        //
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

    /**
     * This method will generate a payment intent and return a
     * client token
     *
     * @param   Request  $request  [$request description]
     *
     * @return  [type]             [return description]
     */
    public function stripe(Request $request)
    {
        // Remember to calculate totals on the server

        $key = Setting::find(1)->gateway_private_key;

        \Stripe\Stripe::setApiKey($key);

        $paymentIntent = \Stripe\PaymentIntent::create([
          'amount' => (double)$request->total * 100,
          'currency' => 'usd'
        ]);

        return response([
          'client_secret' => $paymentIntent->client_secret
        ], 201);
    }
}
