<?php

namespace App\Http\Controllers\Admin;

use App\ProductType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Session;
use Jenssegers\Date\Date;
Use Illuminate\Support\Facades\Auth;

class ProductTypeController extends Controller
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
          'name'        => 'required|min:2|unique:product_types,name',
          'description' => 'required',
        ]);

        $productType = new ProductType;

        $productType->name        = $request->name;
        $productType->description = $request->description;
        $productType->creator_id  = Auth::user()->id;

        $productType->save();

        Session::flash('success', "Product Type <strong>{$productType->name}</strong> added successfully!");

        return redirect()->to(route('admin.settings.index').'#product-types');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductType  $productType
     * @return \Illuminate\Http\Response
     */
    public function show(ProductType $productType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductType  $productType
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductType $productType)
    {
        return view('admin.product-types.edit')->withProductType($productType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductType  $productType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductType $productType)
    {
        $this->validate($request, [
          'name'        => 'required|min:2',
          'description' => 'required',
        ]);

        $productType->name        = $request->name;
        $productType->description = $request->description;

        $productType->save();

        Session::flash('success', "Product Type <strong>{$productType->name}</strong> edited successfully!");

        return redirect()->to(route('admin.settings.index').'#product-types');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductType  $productType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductType $productType)
    {
        //
    }
}
