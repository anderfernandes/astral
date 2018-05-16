<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use Illuminate\Http\Request;

use Session;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\RoleAccessControl;

class RoleController extends Controller
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
        $this->validate($request, [
          'name'        => 'required|unique:roles,name',
          'description' => 'required',
          'staff'       => 'required',
        ]);

        $role = new Role;

        $role->name        = $request->name;
        $role->description = $request->description;
        $role->type        = 'individuals';
        $role->staff       = $request->staff;

        $role->creator_id  = Auth::user()->id;

        $role->save();

        $role->permissions()->create([
          'dashboard'     => null,
          'shows'         => null,
          'products'      => null,
          'calendar'      => null,
          'sales'         => null,
          'reports'       => null,
          'members'       => null,
          'users'         => null,
          'organizations' => null,
          'bulletin'      => null,
          'settings'      => null,
          'admin'         => false,
          'cashier'       => false,
        ]);



        Session::flash('success', "The role <strong>$role->name</strong> has been created successfully!<br> Please set the permissions for this role.");

        // return redirect()->to(route('admin.settings.index').'#user-roles');

        return view('admin.roles.edit')->withRole($role);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return view('admin.roles.edit')->withRole($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $this->validate($request, [
          'name'  => 'required',
          'staff' => 'required',
        ]);

        $permissions = \App\RoleAccessControl::find($role->permissions->id);

        $role->name        = $request->name;
        $role->description = $request->description;
        $role->staff       = $request->staff;

        $permissions->dashboard     = isSet($request->dashboard)     ? implode("", $request->dashboard)     : null;
        $permissions->shows         = isSet($request->shows)         ? implode("", $request->shows)         : null;
        $permissions->products      = isSet($request->products)      ? implode("", $request->products)      : null;
        $permissions->calendar      = isSet($request->calendar)      ? implode("", $request->calendar)      : null;
        $permissions->sales         = isSet($request->sales)          ? implode("", $request->sales)          : null;
        $permissions->reports       = isSet($request->reports)       ? implode("", $request->reports)       : null;
        $permissions->members       = isSet($request->members)       ? implode("", $request->members)       : null;
        $permissions->users         = isSet($request->users)         ? implode("", $request->users)         : null;
        $permissions->organizations = isSet($request->organizations) ? implode("", $request->organizations) : null;
        $permissions->bulletin      = isSet($request->bulletin)      ? implode("", $request->bulletin)      : null;
        $permissions->settings      = isSet($request->settings)      ? implode("", $request->settings)      : null;
        $permissions->admin         = (boolean)$request->admin;
        $permissions->cashier       = (boolean)$request->cashier;


        $permissions->save();

        Session::flash('success', 'The <strong>User Role ' . $role->name . '</strong> has been updated successfully!');

        return redirect()->to(route('admin.settings.index').'#user-roles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //
    }
}
