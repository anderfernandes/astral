<?php

namespace App\Http\Controllers;

use App\Models\EventType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class EventTypeController extends Controller
{
    private array $rules = [
        'name' => ['required', 'min:3', 'max:32'],
        'description' => ['required', 'min:3', 'max:255'],
        'is_public' => ['nullable']
    ];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $eventTypes = (new EventType())->where('id', '!=', 1)->get();

        return response(['data' => $eventTypes], 200);
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

        $eventType = (new EventType)->create([
            "name" => $request->get("name"),
            "description" => $request->get("description"),
            "is_public" => $request->has("is_public"),
            'creator_id' => $request->user()->id
        ]);

        if ($request->has('allowed_tickets')) {
            $allowed_tickets = explode(",", $request->get("allowed_tickets"));

            if (count($allowed_tickets) > 0) {
                $eventType->allowedTickets()->attach($allowed_tickets);
            }
        }

        // TODO: DO NOT FORGET THE COLORS PROPERTY

        return response(['data' => $eventType->id], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(EventType $eventType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EventType $eventType): Response
    {
        $validator = Validator::make($request->all(), $this->rules);

        if ($validator->fails()) {
            return response([
                'errors' => $validator->errors()
            ], 422);
        }

        $eventType->update([
            "name" => $request->input("name"),
            "description" => $request->input("description"),
            "is_public" => $request->has("is_public")
        ]);

        if ($request->has('allowed_tickets')) {
            $new_allowed_tickets = explode(",", $request->get("allowed_tickets"));
            $current_allowed_tickets = $eventType->allowedTickets->pluck('id')->toArray();

            if (count($new_allowed_tickets) > 0 && ($new_allowed_tickets != $current_allowed_tickets)) {
                $eventType->allowedTickets()->detach();
                $eventType->allowedTickets()->attach($new_allowed_tickets);
            }
        }

        return response(['data' => $eventType->id], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventType $eventType)
    {
        //
    }
}
