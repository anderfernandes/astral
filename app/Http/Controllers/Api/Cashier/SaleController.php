<?php

namespace App\Http\Controllers\Api\Cashier;

use App\{ Sale, User };
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
        $cashier  = User::find($request->cashier_id);
        $customer = User::find($request->customer_id);

        $sale = new Sale;

        $sale->creator_id = $cashier->id;
        $sale->organization_id = $customer->organization_id;
        $sale->customer_id = $customer->id;
        $sale->status = "complete";
        $sale->taxable              = true;
        $sale->subtotal             = (double)$request->subtotal;
        $sale->tax                  = (double)$request->tax;
        $sale->total                = (double)$request->total;
        $sale->refund               = false;
        $sale->source               = "cashier";
        $sale->sell_to_organization = false;

        // $sale->save();

        // Get an array of all events
        $events_array = [];

        foreach($request->tickets as $ticket)
          array_push($events, $ticket['event']['id']);

        // $sale->events()->attach($events_array);

        /*if ($request->has('memo'))
          $sale->memo()->create([
            'author_id' => $cashier->id,
            'message'   => $request->memo,
          ]);
        */

        $tickets = [];

        for ($i = 0; $i < count($request->tickets) - 1; $i++)
        {
          foreach ($request->tickets[$i]['tickets'] as $data)
          {
            for ($j = 0; $j < count($data['quantity']) - 1; $j++)
              $tickets = array_prepend($tickets, [
                'ticket_type_id'  => $data['id'],
                'event_id'        => $events_array[$i],
                'customer_id'     => $customer->id,
                'cashier_id'      => $cashier->id,
                'organization_id' => $customer->organization_id,
              ]);
          }
        }

        
        return response()->json([
          'events' => $events_array,
          'tickets' => $tickets,
        ]);
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
}
