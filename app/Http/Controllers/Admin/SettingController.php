<?php

namespace App\Http\Controllers\Admin;

use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Session;
use Illuminate\Support\Facades\{Auth, Storage};

use App\{Organization, OrganizationType, Role, TicketType, PaymentMethod};
use App\{EventType, MemberType, Category, ProductType, Grade, Announcement, ShowType, Position};

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
    $categories = Category::all();
    $productTypes = ProductType::all();
    $grades = Grade::all();
    $showTypes = ShowType::where('id', '!=', 1)->get();
    $announcements = Announcement::all();
    $positions = Position::all();
    $colors = [
      'red'    => '#cf3534',
      'orange' => '#f2711c',
      'yellow' => '#fbbd08',
      'olive'  => '#b5cc18',
      'green'  => '#21ba45',
      'teal'   => '#00b5ad',
      'blue'   => '#002e5d',
      'violet' => '#6435c9',
      'purple' => '#a333c8',
      'pink'   => '#e03997',
      'brown'  => '#a5673f',
      'grey'   => '#767676',
      'black'  => '#1b1c1d',
    ];

    return view('admin.settings.index')
      ->withSetting($setting)
      ->withOrganizationTypes($organizationTypes)
      ->withTicketTypes($ticketTypes)
      ->withPaymentMethods($paymentMethods)
      ->withRoles($roles)
      ->withMemberTypes($memberTypes)
      ->withEventTypes($eventTypes)
      ->withColors($colors)
      ->withCategories($categories)
      ->withProductTypes($productTypes)
      ->withGrades($grades)
      ->withShowTypes($showTypes)
      ->withPositions($positions)
      ->withAnnouncements($announcements);
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
    $organizationType->creator_id  =  Auth::user()->id;

    $organizationType->save();

    // Create user Role to go with an organization account
    $role = new Role;

    $role->name        = $request->input('name');
    $role->type        = 'organizations';
    $role->description = $request->input('description');
    $role->creator_id  = Auth::user()->id;

    $role->save();

    Session::flash('success', 'Organization Type ' . $organizationType->name . ' added successfully!');

    return redirect()->to(route('admin.settings.index') . '#organization-types');
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

    $paymentMethod->creator_id = Auth::user()->id;

    $paymentMethod->save();

    Session::flash('success', 'Payment Method <strong>' . $paymentMethod->name . '</strong> added successfully!');

    return redirect()->to(route('admin.settings.index') . '#payment-methods');
  }

  public function addEventType(Request $request)
  { }

  public function editEventType(EventType $eventType)
  { }

  // Add Roles has its own controler

  public function addMemberType(Request $request)
  {
    $this->validate($request, [
      'name'            => 'required|min:3',
      'description'     => 'required|min:3',
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

    $memberType->creator_id     = Auth::user()->id;

    $memberType->save();

    Session::flash('success', '<strong>' . $memberType->name . '</strong> added successfully!');

    return redirect()->to(route('admin.settings.index') . '#member-types');
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
      'organization'    => 'required|min:5',
      'address'         => 'required',
      'phone'           => 'required',
      'email'           => 'e-mail',
      'seats'           => 'required',
      'emailserver'     => 'string|min:3',
      'emailserverport' => 'integer|min:2',
      'emailservertype' => 'string',
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
    $setting->membership_card_width     = $request->membership_card_width;
    $setting->membership_card_height    = $request->membership_card_height;
    $setting->membership_card_barcode   = $request->membership_card_barcode;
    $setting->membership_number_length  = $request->membership_number_length;
    $setting->cashier_customer_dropdown = $request->cashier_customer_dropdown;
    $setting->ticket_width              = $request->ticket_width;
    $setting->ticket_height             = $request->ticket_height;
    $setting->self_confirmation         = (bool) $request->self_confirmation;
    $setting->self_confirmation_days    = (int) $request->self_confirmation_days;
    $setting->self_confirmation_time    = $request->self_confirmation_time;
    $setting->gateway                   = $request->gateway;
    $setting->gateway_public_key        = $request->gateway_public_key;
    $setting->gateway_private_key       = $request->gateway_private_key;

    if ($request->logo != null) {
      Storage::disk('public')->delete($setting->logo);
      $setting->logo = $request->logo->store('settings', 'public');
    }
    if ($request->cover != null) {
      Storage::disk('public')->delete($setting->cover);
      $setting->cover = $request->cover->store('settings', 'public');
    }

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
