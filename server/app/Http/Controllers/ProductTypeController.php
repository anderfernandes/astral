<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductTypeRequest;
use App\Http\Requests\UpdateProductTypeRequest;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ProductTypeController extends Controller
{
    private array $rules = [
        'name' => ['required', 'string', 'min:3', 'max:63'],
        'description' => ['required', 'string', 'min:3', 'max:255'],
    ];

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $productTypes = (new ProductType())->all();

        return response(['data' => $productTypes], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Response
    {
        $validator = Validator::make($request->input(), $this->rules);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()], 422);
        }

        $productType = (new ProductType())->create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'creator_id' => $request->user()->id
        ]);

        return response(['data' => $productType->id], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductType $productType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductType $productType): Response
    {
        $validator = Validator::make($request->input(), $this->rules);

        if ($validator->fails()) {
            return response([
                'errors' => $validator->errors()
            ]);
        }

        $productType->update([
            'name' => $request->input('name'),
            'description' => $request->input('description')
        ]);

        return response(['data' => $productType->id], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductType $productType)
    {
        //
    }
}
