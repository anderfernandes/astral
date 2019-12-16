<?php

namespace App\Http\Controllers\Api;

use App\{Member, User};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
    //
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
    ], 201);
  }
}
