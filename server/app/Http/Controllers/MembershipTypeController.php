<?php

namespace App\Http\Controllers;

use App\Models\MembershipType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class MembershipTypeController extends Controller
{
    /**
     * Validation rules.
     */
    private array $rules = [
        'name' => ['required'],
        'description' => ['required'],
        'price' => ['required', 'numeric'],
        'duration' => ['required', 'numeric'],
        'max_secondaries' => ['required', 'integer'],
        'secondary_price' => ['required', 'numeric'],
    ];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $membershipTypes = (new MembershipType)->where('id', '>', 1);

        if ($request->has('active')) $membershipTypes = $membershipTypes->where('is_active', true);

        return response([
            'data' => $membershipTypes->get(),
        ], 200);
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

        $membership_type = (new MembershipType)->create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'duration' => $request->input('duration'),
            'max_secondaries' => $request->input('max_secondaries'),
            'secondary_price' => $request->input('secondary_price'),
            'is_active' => $request->has('is_active'),
            'keep_remaining_days' => $request->has('keep_remaining_days'),
        ]);

        return response(['data' => $membership_type->id], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(MembershipType $membershipType): Response
    {
        return response($membershipType, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MembershipType $membershipType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MembershipType $membershipType): Response
    {
        $validator = Validator::make($request->input(), $this->rules);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()], 422);
        }

        $membershipType->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'duration' => $request->input('duration'),
            'max_secondaries' => $request->input('max_secondaries'),
            'secondary_price' => $request->input('secondary_price'),
            'is_active' => $request->has('is_active'),
            'keep_remaining_days' => $request->has('keep_remaining_days'),
        ]);

        return response(['data' => $membershipType->id], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MembershipType $membershipType)
    {
        //
    }
}
