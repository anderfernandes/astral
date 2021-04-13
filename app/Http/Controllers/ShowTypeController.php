<?php

namespace App\Http\Controllers;

use App\Models\ShowType;
use Illuminate\Http\Request;

class ShowTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ShowType::where('id', '!=', 1)->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ShowType  $showType
     * @return \Illuminate\Http\Response
     */
    public function show(ShowType $showType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ShowType  $showType
     * @return \Illuminate\Http\Response
     */
    public function edit(ShowType $showType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ShowType  $showType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShowType $showType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ShowType  $showType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShowType $showType)
    {
        //
    }
}
