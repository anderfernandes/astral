<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Session;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Date\Date;

use App\Role;
use App\Organization;

class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {

    $users = User::where([
      ['type', 'individual'],
      ['role_id', '!=', 5]
    ]);

    $user_query = [];

    if ($request->has('id') && isset($request->id))
      array_push($user_query, ['id', $request->id]);
    if ($request->has('role_id') && isset($request->role_id))
      array_push($user_query, ['role_id', $request->role_id]);

    $roles = Role::where('type', '=', 'individuals')->orderBy('name', 'asc')->pluck('name', 'id');
    $organizations = Organization::orderBy('name', 'asc')->pluck('name', 'id');
    $organizations->prepend('No Organization', 1);

    $users = count($user_query) > 0
      ? $users->where($user_query)->paginate(12)
      : $users->paginate(12);

    if (config('app.force_https')) {
      $users->setPath('/admin/users');
    }

    return view('admin.users.index')->withUsers($users)
      ->withRoles($roles)
      ->withOrganizations($organizations);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $roles = Role::where('type', '=', 'individuals')->orderBy('name', 'asc')->pluck('name', 'id');
    $organizations = Organization::where('id', '!=', 1)->orderBy('name', 'asc')->pluck('name', 'id');
    $organizations->prepend('No Organization', 1);

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
      'active'                => 'required|boolean',
      'newsletter'            => 'boolean',
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
    $user->active          = $request->active;
    $user->staff           = Role::find($request->role_id)->staff;
    $user->newsletter      = $request->has('newsletter');

    $user->creator_id      = Auth::user()->id;

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
    $roles = Role::where('type', '=', 'individuals')->orderBy('name', 'asc')->pluck('name', 'id');
    $organizations = Organization::where('type_id', '!=', 1)->orderBy('name', 'asc')->pluck('name', 'id');
    $organizations->prepend('No Organization', 1);

    $today = Date::today()->toDateTimeString();

    $pastSales = \App\Sale::where([
      ['customer_id', $user->id],
      ['created_at', '<=', $today]
    ])->orderBy('created_at', 'desc')->get();

    $futureSales = \App\Sale::where([
      ['customer_id', $user->id],
      ['created_at', '>', $today]
    ])->orderBy('created_at', 'desc')->get();

    return view('admin.users.show')->withUser($user)
      ->withRoles($roles)
      ->withPastSales($pastSales)
      ->withFutureSales($futureSales)
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
    $roles = Role::where('type', '=', 'individuals')->orderBy('name', 'asc')->pluck('name', 'id');
    $organizations = Organization::where('type_id', '!=', 1)->orderBy('name', 'asc')->pluck('name', 'id');
    $organizations->prepend('No Organization', 1);

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
      'active'                => 'required|boolean',
      'newsletter'            => 'boolean',
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
    $user->active          = $request->active;
    $user->staff           = Role::find($request->role_id)->staff;
    $user->newsletter      = $request->has('newsletter');

    if ($request->password == null) {

      $user->save();

      Session::flash(
        'success',
        '' . $user->firstname . ' ' . $user->lastname .
          '\'s account information has been updated successfully!'
      );

      return redirect()->route('admin.users.show', $user);
    } else {
      $user->password = bcrypt($request->password);
      $user->save();

      Session::flash('success', '<strong>' . $user->fullname . '\'s</strong> account information has been updated successfully!');

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

    try {
      $user->delete();
      Session::flash('success', "<strong>$temp->fullname</strong> was successfully deleted.");
      return redirect()->route('admin.users.index');
    } catch (\Illuminate\Database\QueryException $e) {
      Session::flash(
        'info',
        "<strong>$user->fullname</strong> owns items in the database. Delete all sales, events and memberships, etc. that they own and try again."
      );
      return redirect()->route('admin.users.show', $user);
    }
  }

  public function selfupdate(Request $request, User $user)
  {
    $this->validate($request, [
      'email'                 => 'required',
      'password'              => 'nullable|same:password_confirmation|min:6',
      'password_confirmation' => 'nullable|min:6',
      'address'               => 'required',
      'city'                  => 'required',
      'country'               => 'required',
      'state'                 => 'required',
      'zip'                   => 'required|numeric',
      'phone'                 => 'required',
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
    } else {
      $user->password = bcrypt($request->input('password'));
      $user->save();

      Session::flash('success', '<strong>' . $user->fullname . '\'s</strong> account information has been updated successfully!');

      return redirect()->route('account');
    }
  }
}
