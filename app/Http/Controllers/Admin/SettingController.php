<?php

namespace App\Http\Controllers\Admin;

use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Session;

use App\Organization;
use App\OrganizationType;
use App\Role;
use App\TicketType;
use App\PaymentMethod;

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
        $organizationTypes = OrganizationType::orderBy('created_at', 'desc')->where('name', '!=', 'System')->get();
        $ticketTypes = TicketType::orderBy('created_at', 'desc')->get();
        $paymentMethods = PaymentMethod::all();

        return view('admin.settings.index')
          ->withSetting($setting)
          ->withOrganizationTypes($organizationTypes)
          ->withTicketTypes($ticketTypes)
          ->withPaymentMethods($paymentMethods);
    }

    public function addOrganizationType(Request $request)
    {
      $this->validate($request, [
        'name'        => 'required|unique:organization_types,name',
        'description' => 'required|max:255',
        'taxable'     => 'required'
      ]);

      $organizationType = new OrganizationType;

      $organizationType->name        = $request->input('name');
      $organizationType->description = $request->input('description');
      $organizationType->taxable     = $request->input('taxable');

      $organizationType->save();

      // Create user Role to go with an organization account
      $role = new Role;

      $role->name        = $request->input('name');
      $role->type        = 'organizations';
      $role->description = $request->input('description');

      $role->save();

      Session::flash('success', 'Organization Type '. $organizationType->name .' added successfully!');

      return redirect()->route('admin.settings.index');

    }

    public function addTicketType(Request $request)
    {
      $this->validate($request, [
        'name'        => 'required|unique:ticket_types,name',
        'price'       => 'required|numeric',
        'description' => 'required|max:255'
      ]);

      $ticketType = new TicketType;

      $ticketType->name        = $request->name;
      $ticketType->price       = number_format($request->price, 2);
      $ticketType->description = $request->description;

      $ticketType->save();

      Session::flash('success', 'Ticket Type '. $ticketType->name .' added successfully!');

      return redirect()->route('admin.settings.index');
    }

    public function addPaymentMethod(Request $request)
    {
      $this->validate($request, [
        'name'        => 'required',
        'description' => 'required|max:255',
        'icon'        => 'required'
      ]);

      $paymentMethod =  new paymentMethod;

      $paymentMethod->name        = $request->name;
      $paymentMethod->description = $request->description;
      $paymentMethod->icon        = $request->icon;

      $paymentMethod->save();

      Session::flash('success', 'Payment Method '. $paymentMethod->name .' added successfully!');

      return redirect()->route('admin.settings.index');

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
