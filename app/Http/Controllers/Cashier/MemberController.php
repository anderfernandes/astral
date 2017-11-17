<?php

namespace App\Http\Controllers\Cashier;

use App\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Role;
use App\Organization;
use App\User;
use App\MemberType;
use App\PaymentMethod;
use App\Payment;
use App\Sale;

use Illuminate\Support\Facades\Auth;

use Jenssegers\Date\Date;
use Session;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      // member role_id is 5
      $members = Member::all()->where('id', '!=', 1);
      return view('cashier.members.index')->withMembers($members);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $roles = Role::where('type', '=', 'members')->pluck('name', 'id');
      $organizations = Organization::where('type', '!=', 'System')->pluck('name', 'id');
      $memberTypes = MemberType::all()->where('id', '!=', 1);
      $memberTypes = $memberTypes->mapWithKeys(function($item) {
        return [$item['id'] => $item['name'] . ' - ' . $item['duration'] .' days' . ' - $ '  . number_format($item['price'], 2)];
      });

      $paymentMethods = PaymentMethod::all();
      return view('cashier.members.create')->withPaymentMethods($paymentMethods)
                                           ->withRoles($roles)
                                           ->withOrganizations($organizations)
                                           ->withMemberTypes($memberTypes);
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
          'firstname'         => 'required',
          'lastname'          => 'required',
          'member_type_id'    => 'required|integer',
          // tendered must be minimum of the lowest membership price
          'tendered'          => 'numeric|min:' . $request->total,
          'payment_method_id' => 'required',
          'start'             => 'required|date',
          'end'               => 'required|date',
          'address'           => 'required',
          'city'              => 'required',
          'country'           => 'required',
          'state'             => 'required',
          'zip'               => 'required',
          'phone'             => 'required',
          'role_id'           => 'required',
          'organization_id'   => 'required',
          'email'             => 'required|email',
        ]);

        $user = new User;

        $user->firstname       = $request->firstname;
        $user->lastname        = $request->lastname;
        $user->email           = $request->email;
        $user->role_id         = $request->role_id;
        $user->type            = 'individual';
        $user->organization_id = $request->organization_id;
        $user->password        = bcrypt('Mayborn152');
        $user->active          = true;
        $user->role_id         = 5;
        //$user->membership_id   = $member->id;

        //$user->save();

        // Create membership
        $membershipDuration = MemberType::find($request->member_type_id)->duration;
        $member = new Member([
          'member_type_id' => $request->member_type_id,
          'start'          => Date::parse($request->start)->startOfDay()->toDateTimeString(),
          'end'            => Date::parse($request->end)->startOfDay()->toDateTimeString(),
        ]);
        $member->save();
        $member->users()->save($user);

        // Create Sale
        $sale = new Sale;
        $sale->creator_id        = Auth::user()->id;
        $sale->organization_id   = $user->organization_id;
        $sale->customer_id       = $member->users->first->id;
        $sale->status            = "complete";
        $sale->taxable           = false;
        $sale->subtotal          = round($request->subtotal, 2);
        $sale->tax               = round($request->tax, 2);
        $sale->total             = round($request->total, 2);
        $sale->refund            = false;
        $sale->source            = "admin";

        $sale->save();

        // Create Payment
        $payment = new Payment;

        $payment->cashier_id        = Auth::user()->id;
        $payment->payment_method_id = $request->payment_method_id;
        // Tendered may be nullable if the customer hasn't paid
        $payment->tendered          = round($request->tendered, 2);
        $payment->total             = round($request->total, 2);
        // payment = total - tendered (precision set to two decimal places)
        $payment->change_due        = round($request->change_due, 2);
        $payment->reference         = $request->reference;
        $payment->source            = 'admin';
        $payment->sale_id           = $sale->id;

        $payment->save();

        Session::flash('success','<strong>' . $member->users[0]->firstname .' ' . $member->users[0]->lastname .', Member # '. $member->id .' ('. $member->type->name .')</strong> added successfully!');

        return redirect()->route('cashier.members.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show(Member $member)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Member $member)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
    {
        //
    }
}
