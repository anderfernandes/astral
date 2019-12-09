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

  public function checkPrimary(Request $request)
  {
    $user = User::where('email', $request->email)->first();

    $message = isset($user)
      ? "Yay! $user->fullname exists in our database!"
      : "Sorry! {$request->firstname} {$request->lastname} is not in our database";

    $type = isset($user) ? 'success' : 'error';


    return response()->json([
      'message' => $message,
      'type' => $type,
    ], 201);
  }
}
