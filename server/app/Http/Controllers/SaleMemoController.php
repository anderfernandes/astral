<?php

namespace App\Http\Controllers;

use App\Models\SaleMemo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SaleMemoController extends Controller
{
    public array $rules = [
        'message' => ['min:3', 'max:255', 'required'],
        'sale_id' => ['integer', 'required']
    ];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->input(), $this->rules);

        if ($validator->fails()) {
            return response([
                "errors" => $validator->errors()
            ], 422);
        }

        $sale_memo = (new SaleMemo())->create([
            'message' => $request->input('message'),
            'author_id' => $request->user()->id,
            'sale_id' => $request->input('sale_id')
        ]);

        return response(['data' => $sale_memo->id], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(SaleMemo $saleMemo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SaleMemo $saleMemo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SaleMemo $saleMemo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SaleMemo $saleMemo)
    {
        //
    }
}
