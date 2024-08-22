<?php

namespace App\Http\Controllers;

use App\Models\OrganizationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrganizationTypeController extends Controller
{
    private array $rules = [
        'name' => ['required', 'min:3', 'max:31'],
        'description' => ['required', 'min:3', 'max:255'],
        'taxable' => ['string']
    ];
    
    /**
     * Display a listing of the resource.
     */
    public function index() : \Illuminate\Http\Response
    {
        return response([ 'data' => OrganizationType::where('id', '>', 1)->get() ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
        
        (new OrganizationType())->create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'taxable' => $request->has('taxable')
        ]);
        
        return response()->noContent(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(OrganizationType $organizationType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrganizationType $organizationType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrganizationType $organizationType)
    {
        $validator = Validator::make($request->input(), $this->rules);
        
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()], 422);
        }
        
        $organizationType->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'taxable' => $request->has('taxable')
        ]);
        
        return response()->noContent(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrganizationType $organizationType)
    {
        //
    }
}
