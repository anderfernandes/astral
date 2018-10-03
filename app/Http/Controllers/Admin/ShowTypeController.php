<?php

namespace App\Http\Controllers\Admin;

use App\ShowType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Session;

class ShowTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $this->validate($request, [
          'name'        => "min:3|max:64|required",
          'description' => "min:3|max:128|required",
          'active'      => "required",
        ]);

        $showType = new ShowType;

        $showType->name        = $request->name;
        $showType->description = $request->description;
        $showType->active      = (boolean)$request->active;
        $showType->creator_id  = Auth::user()->id;

        $showType->save();

        Session::flash("success", "Show Type <strong>{$showType->name}</strong> created successfully!");

        return redirect()->to(route('admin.settings.index').'#show-types');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ShowType  $showType
     * @return \Illuminate\Http\Response
     */
    public function show(ShowType $showType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ShowType  $showType
     * @return \Illuminate\Http\Response
     */
    public function edit(ShowType $showType)
    {
        return view('admin.show-types.edit')->withShowType($showType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ShowType  $showType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShowType $showType)
    {
        $this->validate($request, [
          'name'        => "min:3|max:64|required",
          'description' => "min:3|max:128|required",
          'active'      => "required",
        ]);

        $showType->name        = $request->name;
        $showType->description = $request->description;
        $showType->active      = (boolean)$request->active;
        $showType->creator_id   = Auth::user()->id;

        $showType->save();

        Session::flash("success", "Show Type <strong>{$showType->name}</strong> updated successfully!");

        return redirect()->to(route('admin.settings.index').'#show-types');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ShowType  $showType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShowType $showType)
    {
        //
    }
}
