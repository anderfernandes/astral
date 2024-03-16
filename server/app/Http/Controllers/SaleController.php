<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Product;
use App\Models\Sale;
use App\Models\TicketType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class SaleController extends Controller
{
    private array $rules = [
        "tickets.*.type_id" => ["integer"],
        "tickets.*.event_id" => ["integer"],
        "tickets.*.quantity" => ["integer"],
        "products.*.id" => ["integer"],
        "products.*.quantity" => ["integer"],
        "organization_id" => ["integer", "nullable"],
        "customer_id" => ["required", "integer"],
        "tendered" => ["numeric", "nullable"],
        "method_id" => ["integer"],
        "reference" => ["min:2", "max:8", "nullable"],
        "taxable" => ["boolean", "nullable"]
    ];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $relations = [
            "payments.method", "customer", "events.type", "creator", "products.type", "tickets.type"
        ];

        $sales = (new Sale)->with($relations)->orderByDesc('id')->get();

        return response(['data' => $sales]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Response
    {
        $validator = Validator::make($request->input(), $this->rules);

        if ($validator->fails()) {
            return response([
                "errors" => $validator->errors()
            ], 422);
        }

        if ($request->has('method_id')) {
            $method = (new \App\Models\PaymentMethod())->find($request->input("method_id"));

            if ($method == null) {
                return response(['message' => 'Invalid payment method.']);
            }
        }

        $subtotal = 0;

        $tax_rate = (new \App\Models\Setting())->find(1)->tax / 100;

        if ($request->has('taxable') && $request->input('taxable')) {
            $tax_rate = 0;
        }

        if ($request->has("products")) {
            foreach ($request->input("products") as $sale_product) {

                $product = (new Product())->find($sale_product['id']);

                if ($product == null) {
                    return response(['message' => "Product not found."], 422);
                }

                if ($product->inventory) {
                    if ($sale_product['quantity'] > $product->stock) {
                        return response(['message' => "Not enough $product->name on stock."], 422);
                    }
                    $product->stock -= (int) $sale_product['quantity'];
                    $product->save();
                }

                $subtotal += (int) $sale_product['quantity'] * $product->price;
            }
        }

        if ($request->has("tickets")) {
            foreach ($request->input('tickets') as $sale_ticket) {
                $ticket_type = (new TicketType())->find($sale_ticket["type_id"]);

                if ($ticket_type == null) {
                    return response(["message" => "Invalid ticket type."], 422);
                }

                $subtotal += (int) $sale_ticket['quantity'] * $ticket_type->price;
            }
        }

        $tax = round($subtotal * $tax_rate, 2);

        $total = $subtotal + $tax;

        // TODO: ENUMS?
        $source = 'online';

        if (str_contains($request->getRequestUri(), '/cashier')) {
            $source = 'cashier';
        }

        if (str_contains($request->getRequestUri(), '/admin')) {
            $source = 'admin';
        }

        // Create sale
        $sale = (new Sale)->create([
            "creator_id" => $request->user()->id,
            "customer_id" => $request->input("customer_id"),
            "organization_id" => 1,
            "status" => "open", // TODO: MARK AS COMPLETE IF BALANCE IS ZERO
            "taxable" => $request->has("taxable"),
            "subtotal" => $subtotal,
            "tax" => $tax,
            "total" => $total,
            "refund" => false, // TODO: replace whole sale refund with refunded payments
            "source" => $source,
            "sell_to_organization" => false
        ]);

        // Create new payment if it exists
        if ($request->has('method_id')) {
            $method = (new \App\Models\PaymentMethod())->find($request->input("method_id"));

            $tendered = $method->type == "cash" ? $request->input('tendered') : $total;

            $sale->payments()->create([
                "cashier_id" => $request->user()->id, // TODO: GET THIS FROM AUTH USER,
                "method_id" => $request["method_id"],
                "total" => $total,
                "tendered" => $tendered,
                "change_due" => $tendered - $total,
                "reference" => $request->has("reference") ? $request->input("reference") : null,
                "source" => $source,
                "refunded" => $request->has("refunded")
            ]);

            if ($sale->balance <= 0) {
                $sale->update(["status" => "complete"]);
            }
        }

        $tickets = [];

        // Process tickets
        if ($request->has('tickets')) {
            // TODO: ADDED VOIDED PROP TO TICKET, VOID UPON ATTENDING EVENT

            foreach ($request->input('tickets') as $sale_ticket) {
                for ($i = 0; $i < $sale_ticket['quantity']; $i++) {
                    $tickets[] = [
                        "customer_id" => (int) $request->input("customer_id"),
                        "type_id" => (int) $sale_ticket["type_id"],
                        "event_id" => (int) $sale_ticket["event_id"],
                        "cashier_id" => $request->user()->id,
                    ];
                }
            }

            $sale->tickets()->createMany($tickets);

            $sale->events()->attach(array_unique(array_column($tickets, 'event_id')));
        }

        // Process products
        if ($request->has('products')) {
            $products = [];

            foreach ($request->input("products") as $sale_product) {
                for ($i = 0; $i < $sale_product['quantity']; $i++) {
                    $products[] = $sale_product['id'];
                }
            }
            $sale->products()->attach($products);
        }

        // Sale memo
        if ($request->has("memo")) {
            $sale->memos()->create([
                "message" => $request->input("memo"),
                "author_id" => $request->user()->id
            ]);
        }

        return response(["data" => $sale->id, 'tickets' => $tickets], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale): Response
    {
        return response($sale->load([
            'tickets.type', 'events.show.type', 'events.type', 'payments.method', 'payments.customer',
            'payments.cashier',
            'products.type',
            'customer', 'creator',
            'memos.author.role'
        ]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale, Request $request)
    {
        if ($sale->payments()->get() == null || $sale->payments()->count() <= 0) {
            return response(["message" => "This sale doesn't have any payments."], 422);
        }

        if ($sale->refund) {
            return response(["message" => "This sale has already been refunded."], 422);
        }

        // Refunding sale: mark payments as refunded, if tickets then void, if products restore stock

        $sale->update(["refund" => true]);

        $sale->payments()->update(["refunded" => true]);

        // Group distinct products, loop through them, add stock back if keep inventory is true
        $products = $sale->products()->where('inventory', true)->distinct()->get();

        foreach ($products as $product) {
            $count = $sale->products()->get()->where('id', $product->id)->count();
            $product->update(["stock" => $product->stock + $count]);
        }

        $sale->memos()->create(["message" => "Sale was refunded.", "author_id" => $request->user()->id]);

        return response(["data" => $sale->id], 200);
    }
}