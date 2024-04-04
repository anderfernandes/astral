<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StripeController extends Controller
{
    /**
     * Creates a Stripe session. Will fail if keys are not set up.
     * @param  Request  $request
     * @return Response
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function create(Request $request): Response
    {
        $key = config('app.stripe_key');
        $secret = config('app.stripe_secret');

        if (!$key || !$secret) {
            return response(['message' => 'Online payments not yet set up.'], 422);
        }

        $stripe = new \Stripe\StripeClient($secret);

        $subtotal = 0;

        if ($request->has('products')) {
            foreach ($request->input('products') as $sale_product) {
                $product = (new \App\Models\Product())->find($sale_product['id']);

                if ($product === null || $product->price === null) {
                    return response()->noContent(422);
                }

                $subtotal += $sale_product['quantity'] * $product->price;
            }
        }

        if ($request->has('tickets')) {
            foreach ($request->input('tickets') as $sale_ticket) {
                $ticket_type = (new \App\Models\TicketType())->find($sale_ticket['type_id']);

                if ($ticket_type === null || $ticket_type->price === null) {
                    return response()->noContent(422);
                }

                $subtotal += $sale_ticket['quantity'] * $ticket_type->price;
            }
        }

        $tax = \Illuminate\Support\Facades\DB::table('settings')->first()->tax / 100;

        $total = $subtotal + round($subtotal * $tax, 2);

        $intent = $stripe->paymentIntents->create([
            [
                'amount' => $total * 100,
                'currency' => 'usd',
            ]
        ]);

        return response(["client_secret" => $intent->client_secret, 'total' => $total], 200);
    }
}
