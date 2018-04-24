<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use Illuminate\Http\Request;

use Session;

use App\Http\Controllers\Controller;

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

        Session::flash('success', 'The <strong>User Role ' . $role->name . '</strong> has been created successfully!');

        return redirect()->to(route('admin.settings.index').'#user-roles');
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

        $role->name        = $request->name;
        $role->description = $request->description;
        $role->staff       = $request->staff;

        $role->save();

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
