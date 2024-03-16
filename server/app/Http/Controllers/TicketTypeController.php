<?php

namespace App\Http\Controllers;

use App\Models\TicketType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TicketTypeController extends Controller
{
    private array $rules = [
        'name' => ['required'],
        'price' => ['required', 'numeric'],
        //'allowed_in_events.*' => 'required',
        'is_active' => ['nullable'],
        'is_public' => ['nullable'],
        'description' => ['required', 'min:3', 'max:255'],
        'in_cashier' => ['nullable'],
    ];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        return response(['data' => TicketType::all()], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Response
    {
        $validator = Validator::make($request->input(), $this->rules);

        if ($validator->fails()) {
            return response([
                'errors' => $validator->errors()
            ], 422);
        }

        $ticketType = (new TicketType)->create([
            'creator_id' => $request->user()->id,
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'is_active' => $request->has('is_active'),
            'is_public' => $request->input('is_public'),
            'description' => $request->input('description'),
            'in_cashier' => $request->input('in_cashier')
        ]);

        return response(['data' => $ticketType->id], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(TicketType $ticketType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TicketType $ticketType): Response
    {
        $validator = Validator::make($request->input(), $this->rules);

        if ($validator->fails()) {
            return response([
                'errors' => $validator->errors()
            ], 422);
        }

        $ticketType->update([
            'creator_id' => $request->user()->id,
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'is_active' => $request->has('is_active'),
            'is_public' => $request->input('is_public'),
            'description' => $request->input('description'),
            'in_cashier' => $request->input('in_cashier')
        ]);

        return response(['data' => $ticketType->id], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
