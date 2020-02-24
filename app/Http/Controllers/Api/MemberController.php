<?php

namespace App\Http\Controllers\Api;

use App\{Member, User, Sale, Payment};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class MemberController extends Controller
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
    // Create users

    $primary = User::where('email', $request->primary['email'])->first();

    if (!$primary)
    {
      $primary = new User;
      
      $primary->firstname       = $request->input('primary.firstname');
      $primary->lastname        = $request->input('primary.lastname');
      $primary->address         = $request->input('primary.address');
      $primary->city            = $request->input('primary.city');
      $primary->state           = $request->input('primary.state');
      $primary->country         = $request->input('primary.country');
      $primary->zip             = $request->input('primary.zip');
      $primary->phone           = $request->input('primary.phone');
      $primary->email           = strtolower($request->input('primary.email'));
      $primary->newsletter      = $request->input('primary.newsletter');
      $primary->password        = bcrypt((str_random(16)));
      $primary->type            = 'individual';
      $primary->active          = true;
      $primary->role_id         = 7;
      $primary->creator_id      = $request->creator_id;
      $primary->organization_id = 1;
      
      $primary->save();

      $primary = User::find($primary->id);

    }

    // Create Sale
    $sale = new Sale;

    $sale->creator_id        = $request->creator_id;
    $sale->organization_id   = $primary->organization_id;
    $sale->customer_id       = $primary->id;
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
        'author_id' => $request->creator_id,
        'message'   => $request->memo,
      ]);
    }

    // Create Payment
    $payment = new Payment;

    $payment->cashier_id        = $request->creator_id;
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
      'member_type_id' => $request->input('membership_type.id'),
      'creator_id'     => $request->creator_id,
      'start'          => Carbon::parse($request->start)->startOfDay(),
      'end'            => Carbon::parse($request->end)->hour(23)->minute(59)->second(59),
      'primary_id'     => $primary->id,
    ]);

    $member->save();


    $primary->role_id = 5;
    $primary->membership_id = $member->id;
    $primary->save();

    // Create Free Secondaries
    $secondaries = $request->free_secondaries;
    
    if (count($secondaries) > 0)
    {
      foreach ($secondaries as $secondary)
      {
        $free_secondary = new User;
      
        $free_secondary->firstname  = $secondary['firstname'];
        $free_secondary->lastname   = $secondary['lastname'];

        // Check if this secondary will use primary address data

        if ($secondary['use_primary_data'])
        {
          $free_secondary->address    = $request->input('primary.address');
          $free_secondary->city       = $request->input('primary.city');
          $free_secondary->state      = $request->input('primary.state');
          $free_secondary->country    = $request->input('primary.country');
          $free_secondary->zip        = $request->input('primary.zip');
          $free_secondary->phone      = $request->input('primary.phone');
          $free_secondary->newsletter = $request->input('primary.newsletter');
        }
        else
        {
          $free_secondary->address    = $secondary['address'];
          $free_secondary->city       = $secondary['city'];
          $free_secondary->state      = $secondary['state'];
          $free_secondary->country    = $secondary['country'];
          $free_secondary->zip        = $secondary['zip'];
          $free_secondary->phone      = $secondary['phone'];
          $free_secondary->newsletter = $secondary['newsletter'];
        }
        
        $free_secondary->email      = strtolower($secondary['email']);
        
        $free_secondary->password        = bcrypt((str_random(16)));
        $free_secondary->type            = 'individual';
        $free_secondary->active          = true;
        $free_secondary->role_id         = 5;
        $free_secondary->creator_id      = $request->creator_id;
        $free_secondary->organization_id = 1;
        $free_secondary->membership_id   = $member->id;
        
        $free_secondary->save();

      }
    }


    // Create Nonfree Secondaries
    $secondaries = $request->nonfree_secondaries;
    
    if (count($secondaries) > 0)
    {
      foreach ($secondaries as $secondary)
      {
        $nonfree_secondary = new User;
      
        $nonfree_secondary->firstname  = $secondary['firstname'];
        $nonfree_secondary->lastname   = $secondary['lastname'];

        // Check if this secondary will use primary address data

        if ($secondary['use_primary_data'])
        {
          $nonfree_secondary->address    = $request->input('primary.address');
          $nonfree_secondary->city       = $request->input('primary.city');
          $nonfree_secondary->state      = $request->input('primary.state');
          $nonfree_secondary->country    = $request->input('primary.country');
          $nonfree_secondary->zip        = $request->input('primary.zip');
          $nonfree_secondary->phone      = $request->input('primary.phone');
          $nonfree_secondary->newsletter = $request->input('primary.newsletter');
        }
        else
        {
          $nonfree_secondary->address    = $secondary['address'];
          $nonfree_secondary->city       = $secondary['city'];
          $nonfree_secondary->state      = $secondary['state'];
          $nonfree_secondary->country    = $secondary['country'];
          $nonfree_secondary->zip        = $secondary['zip'];
          $nonfree_secondary->phone      = $secondary['phone'];
          $nonfree_secondary->newsletter = $secondary['newsletter'];
        }
        
        $nonfree_secondary->email      = strtolower($secondary['email']);
        
        $nonfree_secondary->password        = bcrypt((str_random(16)));
        $nonfree_secondary->type            = 'individual';
        $nonfree_secondary->active          = true;
        $nonfree_secondary->role_id         = 5;
        $nonfree_secondary->creator_id      = $request->creator_id;
        $nonfree_secondary->organization_id = 1;
        $nonfree_secondary->membership_id   = $member->id;
        
        $nonfree_secondary->save();

      }
    }


    // Return membership data

    return response()->json([
      'message' => "$primary->fullname's account created successfully!",
      'membership'  => $member,
    ]);
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

  // This should be called "check member" in the future
  public function checkPrimary(Request $request)
  {
    $user = User::where('email', $request->email)->first();

    $message = '';
    $membership = null;

    $type = isset($user) ? 'success' : 'warning';

    // If user exists in database...
    if (isset($user)) {
      // Checking if they are a member
      if ($user->membership_id != 1) {
        $message = "$user->fullname is already a member.";
        $membership = $user->member;
        $type = 'member';
      } else
        $message = "$user->fullname already exists in our database.";
    } else { // If user doesn't exists...
      $message = "$request->firstname $request->lastname is not in our database.";
    }


    return response()->json([
      'message'    => $message,
      'type'       => $type,
      'membership' => $membership,
      'exists'     => isset($user),
      'user'       => $user,
    ], 201);
  }
}
