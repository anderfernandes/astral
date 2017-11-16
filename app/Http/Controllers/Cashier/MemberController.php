<?php

namespace App\Http\Controllers\Cashier;

use App\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
      $members = User::all()->where('role_id', '5');
      return view('cashier.members.index')->withMembers($members);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $users = User::all()->where('type', 'individual')->where('role_id', '!=', 5);
      $users = $users->mapWithKeys(function($item) {
        return [$item['id'] => $item['firstname'] . ' ' . $item['lastname']];
      });

      $memberTypes = MemberType::all()->where('id', '!=', 1);
      $memberTypes = $memberTypes->mapWithKeys(function($item) {
        return [$item['id'] => $item['name'] . ' - $ ' . number_format($item['price'], 2)];
      });

      $paymentMethods = PaymentMethod::all();
      return view('cashier.members.create')->withUsers($users)
                                         ->withPaymentMethods($paymentMethods)
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
          'user_id'           => 'required|integer',
          'member_type_id'    => 'required|integer',
          'tendered'          => 'numeric',
          'payment_method_id' => 'required',
        ]);

        $user = User::find($request->user_id);

        // Create Sale
        $sale = new Sale;
        $sale->creator_id        = Auth::user()->id;
        $sale->organization_id   = $user->organization_id;
        $sale->customer_id       = $user->id;
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

        // Create membership
        $membershipDuration = MemberType::find($request->member_type_id)->duration;



        $member = new Member([
          'member_type_id' => $request->member_type_id,
          'user_id'        => $request->user_id,
          'start'          => Date::parse($request->start)->toDateTimeString(),
          'end'            => Date::parse($request->end)->toDateTimeString(),
        ]);

        $member->save();

        $user->role_id = 5;
        $user->membership_id = $member->id;
        $user->save();

        Session::flash('success','<strong>' . $user->firstname .' ' . $user->lastname .', Member # '. $user->member->id .' ('. $user->member->type->name .')</strong> added successfully!');

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
