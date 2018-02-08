<?php

namespace App\Http\Controllers\Admin;

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
        $users = User::where('type', 'individual')->where('role_id', '!=', 5)
                 ->orderBy('firstname', 'asc')->paginate(12);

        $roles = Role::where('type', '=', 'individuals')->pluck('name', 'id');
        $organizations = Organization::where('type', '!=', 'System')->pluck('name', 'id');

        return view('admin.users.index')->withUsers($users)
                                        ->withRoles($roles)
                                        ->withOrganizations($organizations);;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where('type', '=', 'individuals')->pluck('name', 'id');
        $organizations = Organization::where('type', '!=', 'System')->pluck('name', 'id');

        return view('admin.users.create')->withRoles($roles)
                                         ->withOrganizations($organizations);
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
          'firstname'             => 'required',
          'lastname'              => 'required',
          'email'                 => 'required|email|unique:users',
          'role_id'               => 'required',
          'address'               => 'required',
          'city'                  => 'required',
          'country'               => 'required',
          'state'                 => 'required',
          'zip'                   => 'required|numeric',
          'phone'                 => 'required',
        ]);

        $user = new User;

        $user->firstname       = $request->firstname;
        $user->lastname        = $request->lastname;
        $user->email           = strtolower($request->email);
        $user->role_id         = $request->role_id;
        $user->type            = 'individual';
        $user->organization_id = $request->organization_id;
        $user->password        = bcrypt(str_random(10));
        $user->membership_id   = 1;
        $user->address         = $request->address;
        $user->city            = $request->city;
        $user->country         = $request->country;
        $user->state           = $request->state;
        $user->zip             = $request->zip;
        $user->phone           = $request->phone;
        $user->active          = true;
        $user->staff           = Role::find($request->role_id)->staff;

        $user->save();

        Session::flash('success', '<strong>' . $user->fullname . '\'s</strong> account created successfully!');

        return redirect()->route('admin.users.show', $user);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
      $roles = Role::where('type', '=', 'individuals')->pluck('name', 'id');
      $organizations = Organization::where('type', '!=', 'System')->pluck('name', 'id');

      return view('admin.users.show')->withUser($user)
                                     ->withRoles($roles)
                                     ->withOrganizations($organizations);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::where('type', '=', 'individuals')->pluck('name', 'id');
        $organizations = Organization::where('type', '!=', 'System')->pluck('name', 'id');
        return view('admin.users.edit')
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
          'email'                 => 'required|email|unique:users,email,' . $user->id,
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
        $user->membership_id   = 1;
        $user->address         = $request->address;
        $user->city            = $request->city;
        $user->country         = $request->country;
        $user->state           = $request->state;
        $user->zip             = $request->zip;
        $user->phone           = $request->phone;
        $user->active          = true;
        $user->staff           = Role::find($request->role_id)->staff;

        if ($request->password == null) {

          $user->save();

          Session::flash('success',
            ''.$user->firstname.' '.$user->lastname.
            '\'s account information has been updated successfully!');

          return redirect()->route('admin.users.show', $user);
        }
        else {
          $user->password = bcrypt($request->password);
          $user->save();

          Session::flash('success', '<strong>'. $user->fullname . '\'s</strong> account information has been updated successfully!');

          return redirect()->route('admin.users.show', $user);
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
      $temp = $user;

      $user->delete();

      Session::flash('success', 'The <strong>'.$temp->role.'</strong> user '. $user->fullname .' was successfully deleted.');

      return redirect()->route('admin.users.index');
    }

    public function selfupdate(Request $request, User $user)
    {
      $this->validate($request, [
        'email'                 => 'required|unique:users',
        'password'              => 'nullable|same:password_confirmation|min:6',
        'password_confirmation' => 'nullable|min:6',
        'address'               => 'required',
        'city'                  => 'required',
        'country'               => 'required',
        'state'                 => 'required',
        'zip'                   => 'required|numeric',
        'phone'                 => 'required|unique:organizations,phone',
      ]);

      $user = User::find(\Auth::id());

      $user->email           = strtolower($request->email);
      $user->type            = 'individual';
      $user->address         = $request->address;
      $user->city            = $request->city;
      $user->country         = $request->country;
      $user->state           = $request->state;
      $user->zip             = $request->zip;
      $user->phone           = $request->phone;
      $user->active          = true;

      if ($request->password == null) {

        $user->save();

        Session::flash('success', '<strong>' . $user->fullname . '\'s</strong> account information has been updated successfully!');

        return redirect()->route('account');
      }
      else {
        $user->password = bcrypt($request->input('password'));
        $user->save();

        Session::flash('success', '<strong>' . $user->fullname. '\'s</strong> account information has been updated successfully!');

        return redirect()->route('account');
      }
    }

}
