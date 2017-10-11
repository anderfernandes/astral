<?php

namespace App\Http\Controllers\Admin;

use App\Organization;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\OrganizationType;

use Session;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $organizations = Organization::where('type_id', '!=', 1)
        ->orderBy('id', 'desc')->paginate(10);

      return view('admin.organizations.index')->withOrganizations($organizations);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $organizationTypes = OrganizationType::where('name', '!=', 'System')->pluck('name', 'id');
        return view('admin.organizations.create')->withOrganizationTypes($organizationTypes);
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
          'name'    => 'required|unique:organizations,name',
          'type_id' => 'required|integer',
          'address' => 'required|unique:organizations,address',
          'city'    => 'required',
          'country' => 'required',
          'state'   => 'required',
          'zip'     => 'required|numeric',
          'phone'   => 'required|unique:organizations,phone',
          'fax'     => 'nullable',
          'email'   => 'required|email|unique:organizations,email',
          'website' => 'nullable',
        ]);

        // ORGANIZATIONS HAVE ACCOUNTS!!!

        $organization = new Organization;

        $organization->name    = $request->name;
        $organization->type_id = $request->type_id;
        $organization->address = $request->address;
        $organization->city    = $request->city;
        $organization->country = $request->country;
        $organization->state   = $request->state;
        $organization->zip     = $request->zip;
        $organization->phone   = $request->phone;
        $organization->fax     = $request->fax;
        $organization->email   = $request->email;
        $organization->website = $request->website;

        $organization->save();

        $user = new User;

        $user->firstname       = $request->name;
        $user->lastname        = '';
        $user->email           = $request->email;
        $user->password        = bcrypt('Mayborn152');
        $user->role_id         = OrganizationType::find($request->type_id)->id;
        $user->organization_id = $organization->id;
        $user->type            = 'organization';

        $user->save();

        Session::flash('success', 'The organization '. $organization->name . ' has been added successfully!');

        return redirect()->route('admin.organizations.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Organization $organization)
    {
        return view('admin.organizations.show')->withOrganization($organization);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Organization $organization)
    {
        $organizationTypes = OrganizationType::where('id', '!=', 1)->pluck('name', 'id');
        return view('admin.organizations.edit')
          ->withOrganizationTypes($organizationTypes)
          ->withOrganization($organization);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Organization $organization)
    {
        $this->validate($request, [
          'name'    => 'required',
          'type_id' => 'required|integer',
          'address' => 'required',
          'city'    => 'required',
          'country' => 'required',
          'state'   => 'required',
          'zip'     => 'required|numeric',
          'phone'   => 'required',
          'fax'     => 'nullable',
          'email'   => 'required|email',
          'website' => 'nullable',
        ]);

        $organization->name    = $request->name;
        $organization->type_id = $request->type_id;
        $organization->address = $request->address;
        $organization->city    = $request->city;
        $organization->country = $request->country;
        $organization->state   = $request->state;
        $organization->zip     = $request->zip;
        $organization->phone   = $request->phone;
        $organization->fax     = $request->fax;
        $organization->email   = $request->email;
        $organization->website = $request->website;

        $organization->save();

        Session::flash('success', 'The organization '. $organization->name . ' has been updated successfully!');

        return redirect()->route('admin.organizations.show', $organization);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Organization $organization)
    {
        //
    }
}
