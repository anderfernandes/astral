<?php

namespace App\Http\Controllers\Api;

use App\{ Sale, Setting, User, Payment, PaymentMethod };
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

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
        // Calculate totals on the server 
        // ...

        // Define cashier
        $cashier = User::find(1);

        // Find user in database based on email
        $customer = User::where("email", $request->customer["email"])->first();

        if ($customer == null) {
          $customer = new User();
          
          $customer->firstname       = $request->customer["firstname"];
          $customer->lastname        = $request->customer["lastname"];
          $customer->email           = $request->customer["email"];
          $customer->role_id         = 7;
          $customer->type            = "individual";
          $customer->organization_id = 1;
          $customer->password        = Hash::make(str_random(9));
          $customer->membership_id   = 1;
          $customer->address         = $request->customer["address"];
          $customer->city            = $request->customer["city"];
          $customer->state           = $request->customer["state"];
          $customer->zip             = $request->customer["zip"];
          $customer->country         = "United States";
          $customer->phone           = $request->customer["phone"];
          $customer->active          = true;
          $customer->staff           = false;
          $customer->newsletter      = $request->has("customer.newsletter");

          // In the future, mark account created by the user themselves when that's the case
          $customer->creator_id      = 1; 

          $customer->save();
        }

        $sale = new Sale;

        $sale->creator_id = $cashier->id;
        $sale->organization_id = $customer->organization_id;
        $sale->customer_id = $customer->organization_id;
        $sale->customer_id = $customer->id;
        $sale->status = "complete";
        $sale->taxable = true;
        $sale->refund = false;
        $sale->source = "public";
        $sale->sell_to_organization = false;

        $sale->save();

        // Array of events
        $events = [];

        $tickets = [];

        $subtotal = 0;
        
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
            $subtotal += $ticket["price"] * $ticket["amount"];
          }

          // Updating array with events  
          array_push($events, $item['event']['id']);
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

        $sale->subtotal = $subtotal;
        $sale->tax = (double)(Setting::find(1)->tax / 100) * $sale->subtotal;
        $sale->total = $sale->subtotal + $sale->tax;

        $sale->save();

        $payment = new Payment;

        $payment->cashier_id = $cashier->id;
        $payment->payment_method_id = PaymentMethod::where('name', 'like', 'stripe')->first()->id;
        $payment->tendered = $sale->total;
        $payment->total = $sale->total;
        $payment->change_due = $payment->tendered - $payment->total;
        $payment->reference = $request->payment_intent;
        $payment->source = "public";

        $sale->payments()->save($payment);

        return response()->json([
          'data'    => $sale,
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
