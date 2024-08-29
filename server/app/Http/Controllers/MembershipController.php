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
        'secondaries' => ['array'],
        'type_id' => ['required', 'integer', 'exists:member_types,id'],
        'tendered' => ['required', 'numeric'],
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

        $membershipType = (new \App\Models\MembershipType)->firstOrFail($request->input('type_id'));

        $method = (new \App\Models\PaymentMethod)->firstOrFail($request->input('method_id'));

        // TODO: CHECK IF TENDERED IS GREATER THAN MEMBERSHIP COST

        // TODO: CHECK IF ALL SECONDARIES EXISTS

        // Create sale

        $sale = (new \App\Models\Sale)->create([
            'method_id' => $request->input('method_id'),
            'tendered' => $request->input('tendered'),
            'customer_id' => $request->input('primary_id'), // TODO: ADD MEMBERSHIP PRODUCT
            'creator_id' => $request->user()->id,
            'status' => 'complete',
            'source' => 'admin', // TODO: GET SOURCE FROM REQUEST URL
            'taxable' => true,
            'refund' => false,
            'organization_id' => 1,
        ]);

        // Add payment

        $sale->payments()->create([
            'tendered' => $request->input('tendered'),
            'method_id' => $request->input('method_id'),
            'cashier_id' => $request->user()->id,
            'source' => 'admin',
        ]);

        // Create membership

        $start = $request->has('start') ? Carbon::parse($request->input('start')) : Carbon::now();

        $membership = (new Membership)->create([
            'type_id' => $request->input('type_id'),
            'creator_id' => $request->user()->id,
            'start' => $start,
            'end' => $start->addDays($membershipType->duration),
            'primary_id' => $request->input('primary_id'),
        ]);

        // Set membership id on primary
        (new \App\Models\User)->firstOrFail($request->input('primary_id'))->update(['membership_id' => $membership->id]);

        // Set membership id on secondaries if any
        if (! is_null($request->input('secondaries'))) {
            (DB::table('users'))->whereIn('id', $request->input('secondaries'))->update(['membership_id' => $membership->id]);
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
