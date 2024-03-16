<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShowTypeRequest;
use App\Http\Requests\UpdateShowTypeRequest;
use App\Models\ShowType;
use Illuminate\Http\Response;

class ShowTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $show_types = (new ShowType())->where('id', '!=', 1)->get();

        return response(['data' => $show_types], 200);
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
    public function store(StoreShowTypeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ShowType $showType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShowType $showType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShowTypeRequest $request, ShowType $showType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShowType $showType)
    {
        //
    }
}
