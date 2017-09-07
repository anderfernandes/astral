<?php

namespace App\Http\Controllers\Admin;

use App\Organization;
use App\OrganizationType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
      $organizations = Organization::orderBy('id', 'desc')->paginate(10);

      return view('admin.organizations.index')->withOrganizations($organizations);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $organizationTypes = OrganizationType::pluck('name', 'id');
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
          'name'    => 'required',
          'type_id' => 'required|integer',
          'address' => 'required',
          'city'    => 'required',
          'country' => 'required',
          'state'   => 'required',
          'zip'     => 'required|numeric',
          'phone'   => 'required',
          'fax'     => 'nullable',
          'email'   => 'nullable|email',
          'website' => 'nullable',
        ]);

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

        Session::flash('success', 'The organization '. $organization->name . ' has been added successfully!');

        return redirect()->route('admin.organizations.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
