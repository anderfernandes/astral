<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MembershipController extends Controller
{
    protected array $rules = [
        'primary_id' => ['required', 'integer', 'exists:users,id'], // TODO: MAKE SURE ALL PRIMARY AND SECONDARIES DIFFER
        'secondaries' => ['nullable', 'array'],
        'type_id' => ['required', 'integer', 'exists:member_types,id'],
        'tendered' => ['nullable', 'numeric'],
        'method_id' => ['required', 'integer', 'exists:payment_methods,id'],
        'start' => ['nullable', 'date'],
    ];

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return response(['data' => (new Membership)->where('id', '>', 1)->get()], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Response
    {
        $validator = Validator::make($request->input(), $this->rules);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()], 422);
        }

        $paymentMethod = (new \App\Models\PaymentMethod)->find($request->input('method_id'));

        if ($paymentMethod == null) {
            return response(['message' => 'Invalid payment method.'], 422);
        }

        $membershipType = (new \App\Models\MembershipType)->find($request->input('type_id'));

        if ($membershipType == null) {
            return response(['message' => 'Invalid membership type.'], 422);
        }

        // TODO: CHECK IF TENDERED IS GREATER THAN MEMBERSHIP COST

        // TODO: CHECK IF ALL SECONDARIES EXISTS

        // Calcualte totals
        $tax_rate = (new \App\Models\Setting)->find(1)->tax / 100;
        $subtotal = $membershipType->price + count($request->input('secondaries') ?? []) * $membershipType->secondary_price;
        $tax = round($subtotal * $tax_rate, 2);
        $total = $subtotal + $tax;
        $tendered = $paymentMethod->type == 'cash' ? (float) $request->input('tendered') : $total;
        $change_due = $paymentMethod->type == 'cash' ? $tendered - $total : 0;

        // Create sale

        $sale = (new \App\Models\Sale)->create([
            'method_id' => $request->input('method_id'),
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
            'customer_id' => $request->input('primary_id'), // TODO: ADD MEMBERSHIP PRODUCT
            'creator_id' => $request->user()->id,
            'status' => 'complete',
            'source' => 'admin', // TODO: GET SOURCE FROM REQUEST URL
            'taxable' => true,
            'refund' => false,
            'sell_to_organization' => false,
            'organization_id' => 1,
        ]);

        // Add payment

        $sale->payments()->create([
            'cashier_id' => $request->user()->id,
            'method_id' => $paymentMethod->id,
            'total' => $total,
            'tendered' => $tendered,
            'change_due' => $change_due,
            'reference' => $request->has('reference') ? $request->input('reference') : null,
            'source' => 'admin',
            'refunded' => false,

        ]);

        // Create membership

        $start = $request->has('start') ? Carbon::parse($request->input('start')) : Carbon::now();

        $membership = (new Membership)->create([
            'type_id' => $membershipType->id,
            'creator_id' => $request->user()->id,
            'start' => $start,
            'end' => $start->addDays($membershipType->duration)->endOfDay(),
            'primary_id' => $request->input('primary_id'),
        ]);

        // Set membership id on primary
        (new \App\Models\User)->find($request->input('primary_id'))->update(['membership_id' => $membership->id]);

        // Set membership id on secondaries if any
        if ($request->has('secondaries')) {
            (DB::table('users'))
                ->whereIn('id', $request->input('secondaries'))
                ->update(['membership_id' => $membership->id]);
        }

        return response(['data' => $membership->id], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Membership $membership): Response
    {
        return response($membership, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Membership $membership)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Membership $membership)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Membership $membership)
    {
        //
    }
}
