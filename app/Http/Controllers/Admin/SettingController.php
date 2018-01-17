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
use App\EventType;
use App\MemberType;

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
        $roles = Role::all()->where('type', 'individuals');
        $organizationTypes = OrganizationType::orderBy('created_at', 'desc')->where('name', '!=', 'System')->get();
        $ticketTypes = TicketType::orderBy('created_at', 'desc')->get();
        $paymentMethods = PaymentMethod::all();
        $eventTypes = EventType::where('name', '!=', 'system')->get();
        $memberTypes = MemberType::where('id', '!=', 1)->get();

        return view('admin.settings.index')
          ->withSetting($setting)
          ->withOrganizationTypes($organizationTypes)
          ->withTicketTypes($ticketTypes)
          ->withPaymentMethods($paymentMethods)
          ->withRoles($roles)
          ->withMemberTypes($memberTypes)
          ->withEventTypes($eventTypes);
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

      return redirect()->to(route('admin.settings.index').'#organization-types');

    }

    public function addTicketType(Request $request)
    {
      $this->validate($request, [
        'name'                => 'required',
        'price'               => 'required|numeric',
        'allowed_in_events.*' => 'required',
        'active'              => 'required',
        'description'         => 'required|max:255'
      ]);

      $allowed_in_events = [];

      $ticketType = new TicketType;

      $ticketType->name        = $request->name;
      $ticketType->price       = number_format($request->price, 2);
      $ticketType->active      = $request->active;
      $ticketType->description = $request->description;

      $ticketType->save();

      $ticketType->allowedEvents()->attach($request->allow_in_events);

      Session::flash('success', 'Ticket Type <strong>'. $ticketType->name .'</strong> added successfully!');

      return redirect()->to(route('admin.settings.index').'#ticket-types');
    }

    public function addPaymentMethod(Request $request)
    {
      $this->validate($request, [
        'name'        => 'required',
        'description' => 'required|max:255',
        'icon'        => 'required',
        'type'        => 'required',
      ]);

      $paymentMethod =  new paymentMethod;

      $paymentMethod->name        = $request->name;
      $paymentMethod->description = $request->description;
      $paymentMethod->icon        = $request->icon;
      $paymentMethod->type        = $request->type;

      $paymentMethod->save();

      Session::flash('success', 'Payment Method <strong>'. $paymentMethod->name .'</strong> added successfully!');

      return redirect()->to(route('admin.settings.index').'#payment-methods');

    }

    public function addEventType(Request $request)
    {
      $this->validate($request, [
        'name'        => 'required',
        'description' => 'required',
      ]);

      $eventType = new eventType;

      $eventType->name        = $request->name;
      $eventType->description = $request->description;

      $eventType->save();

      Session::flash('success', 'Event Type <strong>'. $eventType->name .'</strong> added successfully!');

      return redirect()->to(route('admin.settings.index').'#event-types');
    }

    // Add Roles has its own controler

    public function addMemberType(Request $request)
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

      $memberType->save();

      Session::flash('success', '<strong>'. $memberType->name .'</strong> added successfully!');

      return redirect()->to(route('admin.settings.index').'#member-types');
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
        'address'      => 'required',
        'phone'        => 'required',
        'email'        => 'required',
        'seats'        => 'required',
      ]);

      $setting->organization         = $request->organization;
      $setting->address              = $request->address;
      $setting->phone                = $request->phone;
      $setting->fax                  = $request->fax;
      $setting->email                = $request->email;
      $setting->website              = $request->website;
      $setting->seats                = $request->seats;
      $setting->tax                  = $request->tax;
      $setting->astc                 = $request->astc;
      $setting->membership_text      = $request->membership_text;
      $setting->confirmation_text    = $request->confirmation_text;
      $setting->invoice_text         = $request->invoice_text;

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
