<?php

namespace App\Http\Controllers\Admin;

use App\MemberType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Session;

class MemberTypeController extends Controller
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
          'name'            => 'required',
          'description'     => 'required',
          'price'           => 'required|numeric',
          'duration'        => 'required|numeric',
          'max_secondaries' => 'required|numeric'
        ]);

        $memberType = new MemberType;

        $memberType->name            = $request->name;
        $memberType->description     = $request->description;
        $memberType->price           = $request->price;
        $memberType->duration        = $request->duration;
        $memberType->max_secondaries = $request->max_secondaries;
        $memberType->secondary_price = $request->secondary_price;

        $memberType->creator_id     = Auth::user()->id;

        $memberType->save();

        Session::flash('success', "<strong>{$memberType->name}</strong> added successfully!");

        return redirect()->to(route('admin.settings.index').'#member-types');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MemberType  $memberType
     * @return \Illuminate\Http\Response
     */
    public function show(MemberType $memberType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MemberType  $memberType
     * @return \Illuminate\Http\Response
     */
    public function edit(MemberType $memberType)
    {
        return view('admin.member-types.edit')->withMemberType($memberType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MemberType  $memberType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MemberType $memberType)
    {
        $this->validate($request, [
          'name'            => 'required|min:3',
          'description'     => 'required|min:3',
          'price'           => 'required|numeric',
          'duration'        => 'required|numeric',
          'max_secondaries' => 'required|numeric',
          'secondary_price' => 'required|numeric'
        ]);

        $memberType->name            = $request->name;
        $memberType->description     = $request->description;
        $memberType->price           = $request->price;
        $memberType->duration        = $request->duration;
        $memberType->max_secondaries = $request->max_secondaries;
        $memberType->secondary_price = $request->secondary_price;

        $memberType->save();

        Session::flash('success', "<strong>{$memberType->name}</strong> updated successfully!");

        return redirect()->to(route('admin.settings.index').'#member-types');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MemberType  $memberType
     * @return \Illuminate\Http\Response
     */
    public function destroy(MemberType $memberType)
    {
        //
    }
}
