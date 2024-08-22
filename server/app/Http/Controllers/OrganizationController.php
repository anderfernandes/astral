<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrganizationController extends Controller
{
    private array $rules = [
      'name' => ['required', 'min:3', 'max:127'],
      'address' => ['required', 'min:3', 'max: 127'],
      'city' => ['required', 'min:3', 'max:63'],
      //'state' => ['required', 'min:3', 'max:31'],
      'zip' => ['required', 'size:5'],
      //'country' => ['required'],
      'phone' => ['required', 'size:10'],
      'fax' => ['size:10'],
      'email' => ['email', 'unique:users,email'],
      'website' => ['nullable', 'url'],
      'type_id' => ['required', 'integer', 'exists:organization_types,id'],
    ];
    
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\Response
    {
        $organizations = Organization::where('id', '>', 1)->with('type')->orderByDesc('id')->get();
        
        return response([ 'data' => $organizations ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : \Illuminate\Http\Response
    {
        $validator = Validator::make($request->input(), $this->rules);
        
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()], 422);
        }
        
        $organization = (new Organization())->create([
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'city' => $request->input('city'),
            'state' => 'Texas',
            'zip' => $request->input('zip'),
            'country' => 'United States',
            'phone' => $request->input('phone'),
            'fax' => $request->input('fax'),
            'email' => $request->input('email'),
            'website' => $request->input('website'),
            'type_id' => $request->input('type_id'),
        ]);
        
        return response(['data' => $organization->id], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Organization $organization) : \Illuminate\Http\Response
    {
        return response($organization->load(['type', 'users.role']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Organization $organization)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Organization $organization) : \Illuminate\Http\Response
    {
        $validator = Validator::make($request->input(), $this->rules);
        
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()], 422);
        }
        
        $organization->update([
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'city' => $request->input('city'),
            'state' => 'Texas',
            'zip' => $request->input('zip'),
            'country' => 'United States',
            'phone' => $request->input('phone'),
            'fax' => $request->input('fax'),
            'email' => $request->input('email'),
            'website' => $request->input('website'),
            'type_id' => $request->input('type_id'),
        ]);
        
        return response()->noContent(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Organization $organization)
    {
        //
    }
}
