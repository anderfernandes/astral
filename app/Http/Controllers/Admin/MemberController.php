<?php

namespace App\Http\Controllers\Admin;

use App\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\MemberType;
use App\PaymentMethod;
use App\Payment;
use App\Sale;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

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
    // Cleaning up memberships that don't have users attach to them
    // PREVENT THE NEED FOR THIS IN BETA!!!
    foreach (Member::all() as $member) {
      // If membership doesn't have a primary but has at least one secondary...
      if (!isset($member->primary) && isset($member->secondaries->first()->id)) {
        //... set membership primary to the first secondary.
        // This means that primary user account has been deleted...
        $member->primary_id = $member->secondaries->first()->id;
        $member->save();
      }
      // If membership has no primaries or secondaries, delete it
      else if (!isset($member->primary) && !isset($member->secondaries->first()->id))
        $member->delete();
    }

    $expired = $request->has('expired') ? $request->expired == 'true' : false;

    // member role_id is 5
    $members = Member::where('id', '!=', 1);

    $members = $members->when(true, function ($query) use ($expired) {
      if ($expired)
        return $query->where('end', '<', now()->startOfDay()->toDateTimeString());
      else
        return $query->where('end', '>=', now()->startOfDay()->toDateTimeString());
    });

    $member_query = [];

    // The incoming id field now should be of all users whose membership_id == 5
    if ($request->has('id') && isset($request->id))
      array_push($member_query, ['id', User::find($request->id)->membership_id]);
    if ($request->has('membership_number') && isset($request->membership_number))
      array_push($member_query, ['id', $request->membership_number]);
    if ($request->has('type') && isset($request->type))
      array_push($member_query, ['member_type_id', $request->type]);

    $members = count($member_query) > 0
      ? $members->where($member_query)
      : $members;

    $members = $members->paginate(10);

    // if app.force_https is true, make pagination links have https in them

    if (config('app.force_https')) {
      $members->setPath('/admin/members');
    }

    return view('admin.members.index')->withMembers($members);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $users = User::all()->where('type', '!=', 'walk-up')->where('role_id', '!=', 5);
    $memberTypes = MemberType::all()->where('id', '!=', 1);
    $paymentMethods = PaymentMethod::all();
    return view('admin.members.create')->withUsers($users)
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

    if (isset($request->memo)) {
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
    if (isset($request->secondaries)) {
      foreach ($request->secondaries as $secondary) {
        $u = User::find($secondary);
        $u->role_id = 5;
        $u->membership_id = $member->id;
        $u->save();
      }
    }

    // Store free secondaries if they exis
    if (isset($request->paid_secondaries)) {
      foreach ($request->paid_secondaries as $paid_secondary) {
        $p = User::find($paid_secondary);
        $p->role_id = 5;
        $p->membership_id = $member->id;
        $p->save();
      }
    }

    Session::flash('success', '<strong>' . $member->users[0]->fullname . ', Member # ' . $member->id . ' (' . $member->type->name . ')</strong> added successfully!');

    return redirect()->route('admin.members.show', $member);
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
    $users = $users->mapWithKeys(function ($item) {
      return [$item['id'] => $item['firstname'] . ' ' . $item['lastname'] . ' (' . $item->role->name . ')'];
    });
    $methods = \App\PaymentMethod::all()->mapWithKeys(function ($item) {
      return [$item['id'] => $item['name']];
    });

    // If membership doesn't have a primary but has at least one secondary...
    if (!isset($member->primary) && isset($member->secondaries->first()->id)) {
      //... set membership primary to the first secondary.
      // This means that primary user account has been deleted...
      $member->primary_id = $member->secondaries->first()->id;
      $member->save();
    }
    // If membership has no primaries or secondaries, delete it
    else if (!isset($member->primary) && !isset($member->secondaries->first()->id))
      $member->delete();

    return view('admin.members.show')->withMember($member)->withUsers($users)->withMethods($methods);
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

    return view('admin.members.edit')->withMember($member)
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
      'user_id'           => 'required|integer',
      'member_type_id'    => 'required|integer',
      'tendered'          => 'numeric|min:' . ($request->total - $request->paid),
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

    if (isset($request->memo)) {
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

    // Updating membership
    $member->member_type_id = $request->member_type_id;
    $member->start          = Date::parse($request->start)->startOfDay();
    $member->end            = Date::parse($request->end)->hour(23)->minute(59)->second(59);

    $member->save();

    $user->role_id = 5;
    $user->membership_id = $member->id;
    $user->save();

    // Store free secondaries if they exist
    if (isset($request->secondaries)) {
      foreach ($request->secondaries as $secondary) {
        $u = User::find($secondary);
        $u->role_id = 5;
        $u->membership_id = $member->id;
        $u->save();
      }
    }

    // Store free secondaries if they exis
    if (isset($request->paid_secondaries)) {
      foreach ($request->paid_secondaries as $paid_secondary) {
        $p = User::find($paid_secondary);
        $p->role_id = 5;
        $p->membership_id = $member->id;
        $p->save();
      }
    }

    Session::flash('success', '<strong>' . $member->primary->fullname . ', Member # ' . $member->id . ' (' . $member->type->name . ')</strong> edited successfully!');

    return redirect()->route('admin.members.show', $member);
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
    if ($request->format == 'pdf') {
      return PDF::loadView('pdf.members.card', ['member' => $member])
        ->stream('Astral - Membership Card.pdf');
    } else {
      return view('admin.members.card')->withMember($member)->withRequest($request);
    }
  }

  public function receipt(Member $member, Request $request)
  {
    $primary_price = (float)$member->type->price;
    $secondary_price = 0;

    if ($member->secondaries->count() > (int)$member->type->max_secondaries)
      $secondary_price = $member->secondaries->count() * (int)$member->type->secondary_price;

    $membership_total = $primary_price + $secondary_price;

    $sales = Sale::where('customer_id', $member->primary->id)
      // NEED TO FIGURE OUT A WAY TO GET MEMBERSHIP PAYMENTS FOR THIS MEMBER/USER
      // HAVING THEM AS PRODUCTS IS PROBABLY THE WAY TO GO
      ->where('subtotal', $membership_total)
      ->get();
    // Ensure we get the last membership payment
    $sale = $sales->last();

    if ($request->format == 'pdf') {
      return PDF::loadView('pdf.members.receipt', ['sale' => $sale, 'member' => $member])
        ->stream("Astral - Invoice #$sale->id.pdf");
    } else {
      return view('admin.members.receipt')->withMember($member)->withsale($sale);
    }
  }

  public function addSecondary(Member $member, Request $request)
  {
    if ($request->has('nonfree')) {
      // Find all users selected
      $users = User::whereIn('id', explode(',', $request->input('secondaries')))->get();
      // Create sale
      $sale =  new Sale();
      $sale->creator_id = auth()->user()->id;
      $sale->organization_id = $member->primary->organization_id;
      $sale->customer_id = $member->primary_id;
      $sale->status = "complete";
      $sale->taxable = true;

      // Calculations
      $subtotal = $users->count() * $member->type->secondary_price;
      $tax = number_format($subtotal * (\App\Setting::find(1)->tax / 100), 2, '.', '');

      $sale->subtotal = $subtotal;
      $sale->tax = (float)$tax;
      $sale->total = $subtotal + (float)$tax;
      $sale->refund = false;
      $sale->source = "admin";
      $sale->sell_to_organization = false;
      // Save sale
      $sale->save();
      // Add memo to sale
      $sale->memo()->create([
        'author_id' => auth()->user()->id,
        'message' => 'I have added ' . $users->count() . ' secondary(ies) to membership #' . $member->id . '.',
      ]);
      // Create payment
      $payment_method = \App\PaymentMethod::findOrFail($request->input('payment_method_id'));

      $sale->payments()->create([
        'cashier_id' => auth()->user()->id,
        'payment_method_id' => $payment_method->id,
        'tendered' => $request->input('tendered'),
        'total' => $sale->total,
        'change_due' => $sale->total - (float)$request->input('tendered'),
        'reference' => $request->input('reference'),
        'source' => 'admin'
      ]);
      // Make them members
      foreach ($users as $user) {
        $user->membership_id = $member->id;
        $user->role_id = \App\Role::where('name', 'Member')->get()->first()->id;
        $user->save();
      }
      // Redirect them to sale page
      if ($users->count() == 1)
        Session::flash('success', $users->count() . ' secondary has been added to <strong>Member # ' . $member->id . ' (' . $member->primary->fullname . ' / ' . $member->type->name . ')</strong> successfully!');
      else
        Session::flash('success', $users->count() . ' secondaries have been added to <strong>Member # ' . $member->id . ' (' . $member->primary->fullname . ' / ' . $member->type->name . ')</strong> successfully!');

      return redirect()->route('admin.sales.show', $sale);
    }

    $user = User::find($request->user_id);
    $user->role_id = 5;
    $user->membership_id = $member->id;
    $user->save();

    Session::flash('success', '<strong>' . $user->fullname . '</strong> has been added as a secondary to <strong>Member # ' . $member->id . ' (' . $member->primary->fullname . ' / ' . $member->type->name . ')</strong> successfully!');

    return redirect()->route('admin.members.show', $member);
  }

  public function wizard()
  {
    return view('admin.members.wizard');
  }
}
