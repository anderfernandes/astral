<?php

namespace App\Http\Controllers\Cashier;

use App\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\{ Role, Organization, User, MemberType, PaymentMethod, Payment, Sale };

use Illuminate\Support\Facades\Auth;

use Jenssegers\Date\Date;
use Session;
use PDF;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      // member role_id is 5
      $members = Member::where('id', '!=', 1);


      if (count($request->all()) > 0)
      {
        if ($request->memberId) {
          $members = $members->where('id', $request->memberId);
        }

        if ($request->membershipNumber) {
          $members = $members->where('id', $request->membershipNumber);
        }

        if ($request->memberType) {
          $members = $members->where('member_type_id', $request->memberType);
        }

        $memberIds = $members->pluck('id');
        $members = Member::whereIn('id', $memberIds)->paginate(12);
      }
      else
      {
        $members = $members->paginate(12);
      }

      // if app.force_https is true, make pagination links have https in them

      if (config('app.force_https'))
      {
        $members->setPath('/cashier/members');
      }

      return view('cashier.members.index')->withRequest($request)->withMembers($members);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all()->where('type','!=', 'walk-up')->where('role_id', '!=', 5);
        $memberTypes = MemberType::all()->where('id', '!=', 1);
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
        'tendered'          => 'numeric|min:' . $request->total,
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

      if (isSet($request->memo))
      {
        $sale->memo()->create([
          'author_id' => Auth::user()->id,
          'message'   => $request->memo,
        ]);
      }

      // Create Payment
      $payment = new Payment;

      $payment->cashier_id        = Auth::user()->id;
      $payment->payment_method_id = $request->payment_method_id;
      // Tendered may be nullable if the customer hasn't paid
      $payment->tendered          = number_format($request->tendered, 2, '.', '');
      $payment->total             = number_format($request->total, 2, '.', '');
      // payment = total - tendered (precision set to two decimal places)
      $payment->change_due        = number_format($request->change_due, 2, '.', '');
      $payment->reference         = $request->reference;
      $payment->source            = 'admin';
      $payment->sale_id           = $sale->id;

      $payment->save();

      // Create membership
      $member = new Member([
        'member_type_id' => $request->member_type_id,
        'creator_id'     => Auth::user()->id,
        'start'          => Date::parse($request->start)->startOfDay(),
        'end'            => Date::parse($request->end)->hour(23)->minute(59)->second(59),
        'primary_id'     => $user->id,
      ]);

      $member->save();

      $user->role_id = 5;
      $user->membership_id = $member->id;
      $user->save();

      // Store free secondaries if they exist
      if (isSet($request->secondaries))
      {
        foreach ($request->secondaries as $secondary)
        {
          $u = User::find($secondary);
          $u->role_id = 5;
          $u->membership_id = $member->id;
          $u->save();
        }
      }

      // Store free secondaries if they exis
      if (isSet($request->paid_secondaries))
      {
        foreach ($request->paid_secondaries as $paid_secondary)
        {
          $p = User::find($paid_secondary);
          $p->role_id = 5;
          $p->membership_id = $member->id;
          $p->save();
        }
      }

      Session::flash('success','<strong>' . $member->users[0]->fullname . ', Member # '. $member->id .' ('. $member->type->name .')</strong> added successfully!');

      return redirect()->route('cashier.members.show', $member);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show(Member $member)
    {
      $users = User::all()->where('type', 'individual')->where('role_id', '!=', 5);
      $users = $users->mapWithKeys(function($item) {
        return [$item['id'] => $item['firstname'] . ' ' . $item['lastname']];
      });

      return view('cashier.members.show')->withMember($member)->withUsers($users);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $member)
    {
      $memberTypes = MemberType::all()->where('id', '!=', 1);
      $paymentMethods = PaymentMethod::all();
      // Passing membership payments

      // IN ORDER TO GET THE LATEST MEMBERSHIP PAYMENT, QUERY THE DATABASE FOR A PAYMENT THAT...
      $sales = Sale::where('customer_id', $member->primary->id) // ...HAS THE PRIMARY MEMBER AS A CUSTOMER...
                    ->where('subtotal', '>=', $member->type->price) // ...SUBTOTAL >= MEMBERSHIP TYPE PRICE
                    ->whereDate('created_at', $member->created_at->format('Y-m-d'))->get(); // .. WAS CREATED THE SAME DAY THE MEMBERSHIP WAS CREATED
      // Ensure we get the last membership payment
      $sale = $sales->last();

      return view ('cashier.members.edit')->withMember($member)
                                        ->withSale($sale)
                                        ->withMemberTypes($memberTypes)
                                        ->withPaymentMethods($paymentMethods);
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
        $this->validate($request, [
          'user_id'        => 'required|integer',
          'member_type_id' => 'required|integer',
          'tendered'       => 'numeric|min:' . $request->total,
        ]);

        $user = User::find($member->users[0]->id);

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

        // Update Membership
        $member->member_type_id = $request->member_type_id;
        $member->start          = Date::parse($request->start)->startOfDay()->toDateTimeString();
        $member->end            = Date::parse($request->end)->startOfDay()->toDateTimeString();

        $member->save();

        $user->role_id = 5;
        $user->save();

        Session::flash('success','<strong>' . $member->users[0]->fullname .', Member # '. $member->id .' ('. $member->type->name .')</strong> added successfully!');

        return redirect()->route('cashier.members.show', $member);
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

    public function card(Member $member, Request $request)
    {
      if ($request->format == 'pdf')
      {
        return PDF::loadView('pdf.members.card', ['member' => $member])
                  ->stream('Astral - Membership Card.pdf');
      }
      else
      {
        return view('admin.members.card')->withMember($member)->withRequest($request);
      }

    }

    public function receipt(Member $member, Request $request)
    {
      $sales = Sale::where('customer_id', $member->primary->id)->where('subtotal', $member->type->price)->get();
      // Ensure we get the last membership payment
      $sale = $sales->last();

      if ($request->format == 'pdf')
      {
        return PDF::loadView('pdf.members.receipt', ['sale' => $sale, 'member' => $member])
                  ->stream("Astral - Invoice #$sale->id.pdf");
      }
      else
      {
        return view('admin.members.receipt')->withMember($member)->withsale($sale);
      }
    }

    public function addSecondary(Request $request, Member $member)
    {
      $user = User::find($request->user_id);
      $user->role_id = 5;
      $user->membership_id = $member->id;
      $user->save();

      Session::flash('success','<strong>' . $user->fullname . '</strong> has been added as a secondary to <strong>Member # '. $member->id .' (' . $member->primary->fullname . ' / ' . $member->type->name .')</strong> successfully!');

      return redirect()->route('cashier.members.show', $member);
    }
}
