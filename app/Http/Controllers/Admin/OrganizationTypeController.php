<?php

namespace App\Http\Controllers\Admin;

use Session;
use Illuminate\Support\Facades\{ Auth, Log };

use App\{OrganizationType, Role};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrganizationTypeController extends Controller
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
          'name'        => 'required|min:3|unique:organization_types,name',
          'description' => 'required|max:255',
          'taxable'     => 'required'
        ]);

        $organizationType = new OrganizationType;

        $organizationType->name        = $request->input('name');
        $organizationType->description = $request->input('description');
        $organizationType->taxable     = $request->input('taxable');
        $organizationType->creator_id  =  Auth::user()->id;

        $organizationType->save();

        // Create user Role to go with an organization account
        $role = new Role;

        $role->name        = $request->input('name');
        $role->type        = 'organizations';
        $role->description = $request->input('description');
        $role->creator_id  = Auth::user()->id;

        $role->save();

        Session::flash('success', "Organization Type {$organizationType->name} added successfully!");

        return redirect()->to(route('admin.settings.index').'#organization-types');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OrganizationType  $organizationType
     * @return \Illuminate\Http\Response
     */
    public function show(OrganizationType $organizationType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OrganizationType  $organizationType
     * @return \Illuminate\Http\Response
     */
    public function edit(OrganizationType $organizationType)
    {
        return view('admin.organization-types.edit')->with('organizationType', $organizationType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OrganizationType  $organizationType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrganizationType $organizationType)
    {
        $this->validate($request, [
          'name'        => 'required|min:3',
          'description' => 'required|max:255',
          'taxable'     => 'required'
        ]);

        $organizationType = OrganizationType::find($organizationType->id);

        $organizationType->name        = $request->input('name');
        $organizationType->description = $request->input('description');
        $organizationType->taxable     = $request->input('taxable');
        $organizationType->creator_id  =  Auth::user()->id;

        $organizationType->save();

        // Edit user Role that goes with an organization account
        // If the role doesn't exist, create it
        $role = Role::where('name', $organizationType->name)->first() ?? new Role;

        $role->name        = $request->name;
        $role->type        = 'organizations';
        $role->description = $request->description;
        $role->creator_id  = Auth::user()->id;

        $role->save();

        Log::info(Auth::user()->fullname . " edited Organization Type {$organizationType->name}");

        Session::flash('success', "Organization Type {$organizationType->name} added successfully!");

        return redirect()->to(route('admin.settings.index').'#organization-types');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OrganizationType  $organizationType
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrganizationType $organizationType)
    {
        //
    }
}
