<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    private array $rules = [
        'name' => ['required', 'string', 'min:3', 'max:63'],
        'price' => ['required', 'numeric'],
        'description' => ['required', 'string', 'min:3', 'max:255'],
        'inventory' => ['nullable'],
        'stock' => ['integer'],
        'cover' => ['file', 'max:2048', 'nullable'],
        'is_active' => ['nullable'],
        'is_public' => ['nullable'],
        'in_cashier' => ['nullable']
    ];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $products = (new Product())->with(['type']);

        if ($request->has('in_cashier')) {
            $products = $products->where('in_cashier', true);
        }

        if ($request->has('public')) {
            $products = $products->where('is_public', true);
        }

        return response(['data' => $products->get()], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Response
    {
        $validator = Validator::make($request->input(), $this->rules);

        if ($validator->fails()) {
            return new Response([
                "errors" => $validator->errors()
            ], 422);
        }

        $type = (new \App\Models\ProductType())->find($request->input('type_id'));

        if ($type == null) {
            return new Response(["message" => "Invalid product type"], 422);
        }

        $cover = $request->has('cover') && $request->file('cover') != null && $request->file('cover')->getSize() > 0
            ? $request->file('cover')->store('products', 'public')
            : '/storage/default.png';

        $product = (new Product)->create([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'description' => $request->input('description'),
            'type_id' => $request->input('type_id'),
            'creator_id' => $request->user()->id,
            'inventory' => $request->has('inventory'),
            'stock' => $request->has('inventory') ? $request->input('stock') : 0,
            'cover' => $cover,
            'is_active' => $request->has('is_active'),
            'is_public' => $request->has('is_public'),
            'in_cashier' => $request->has('in_cashier'),
        ]);

        return response(['data' => $product->id], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): Response
    {
        return response($product->load(['type']), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product): Response
    {
        $validator = Validator::make($request->input(), $this->rules);

        if ($validator->fails()) {
            return new Response([
                "errors" => $validator->errors()
            ], 422);
        }

        $type = (new \App\Models\ProductType())->find($request->input('type_id'));

        if ($type == null) {
            return response(["message" => "Invalid product type"], 422);
        }

        if ($request->has('cover') && $request->file('cover') != null && $request->file('cover')->getSize() > 0) {
            $product['cover'] = $request->file('cover')->store('products', 'public');
        }

        $product->update([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'description' => $request->input('description'),
            'type_id' => $request->input('type_id'),
            'inventory' => $request->has('inventory'),
            'stock' => $request->has('inventory') ? $request->input('stock') : 0,
            'is_active' => $request->has('is_active'),
            'is_public' => $request->has('is_public'),
            'in_cashier' => $request->has('in_cashier'),
        ]);

        return response(["data" => $product->id], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
