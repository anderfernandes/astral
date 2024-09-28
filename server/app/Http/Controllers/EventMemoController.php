<?php

namespace App\Http\Controllers;

use App\Models\EventMemo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class EventMemoController extends Controller
{
    private array $rules = [
        'message' => ['required', 'min:3', 'max:255']
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request, \App\Models\Event $event) : Response
    {
        $validator = Validator::make($request->only('message'), $this->rules);

        if ($validator->fails()) return response(['errors' => $validator->errors()], 422);

        $event->memos()->create([
            'message' => $request->input('message'),
            'author_id' => $request->user()->id
        ]);

        return response()->noContent(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(EventMemo $eventMemo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EventMemo $eventMemo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EventMemo $eventMemo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventMemo $eventMemo)
    {
        //
    }
}
