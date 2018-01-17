<?php

namespace App\Http\Controllers\Cashier;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Session;

use App\Role;
use App\Organization;

class UserController extends Controller
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
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::where('type', '!=', 'walk-up')->where('type', '!=', 'organizations')->pluck('name', 'id');
        $organizations = Organization::where('type', '!=', 'System')->pluck('name', 'id');
        return view('cashier.users.edit')
          ->withUser($user)
          ->withRoles($roles)
          ->withOrganizations($organizations);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
          'firstname'             => 'required',
          'lastname'              => 'required',
          'email'                 => 'required|email',
          'role_id'               => 'required',
          'password'              => 'nullable|same:password_confirmation',
          'password_confirmation' => 'nullable',
          'address'               => 'required',
          'city'                  => 'required',
          'country'               => 'required',
          'state'                 => 'required',
          'zip'                   => 'required|numeric',
          'phone'                 => 'required',
        ]);

        $user->firstname       = $request->firstname;
        $user->lastname        = $request->lastname;
        $user->email           = strtolower($request->email);
        $user->role_id         = $request->role_id;
        $user->type            = 'individual';
        $user->organization_id = $request->organization_id;
        $user->password        = bcrypt($request->password);
        $user->address         = $request->address;
        $user->city            = $request->city;
        $user->country         = $request->country;
        $user->state           = $request->state;
        $user->zip             = $request->zip;
        $user->phone           = $request->phone;
        $user->active          = true;

        if ($request->password == null) {

          $user->save();

          Session::flash('success',
            ''.$user->firstname.' '.$user->lastname.
            '\'s account information has been updated successfully!');

          return redirect()->route('cashier.members.show', $user->member);
        }
        else {
          $user->password = bcrypt($request->input('password'));
          $user->save();

          Session::flash('success',
            '<strong>'.$user->firstname.' '.$user->lastname.
            '\'s</strong> account information has been updated successfully!');

          return redirect()->route('cashier.members.show', $user->member);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
