<?php

namespace App\Http\Controllers\Admin;

use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Session;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = Setting::find(1);
        return view('admin.settings.index')->withSetting($setting);
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
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {

      $this->validate($request, [
        'organization' => 'required|min:5',
        'seats'        => 'required',
      ]);

      $setting->organization         = $request->organization;
      $setting->seats                = $request->seats;

      $setting->adults_weekend       = $request->adults_weekend;
      $setting->adults_matinee       = $request->adults_matinee;
      $setting->adults_special_event = $request->adults_special_event;

      $setting->children_weekend       = $request->children_weekend;
      $setting->children_matinee       = $request->children_matinee;
      $setting->children_special_event = $request->children_special_event;

      $setting->members_weekend       = $request->members_weekend;
      $setting->members_matinee       = $request->members_matinee;
      $setting->members_special_event = $request->members_special_event;

      $setting->tax                   = $request->tax;

      $setting->save();

      Session::flash('success', 'Settings updated successfully!');
      return redirect()->route('admin.settings.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
