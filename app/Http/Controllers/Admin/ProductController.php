<?php

namespace App\Http\Controllers\Admin;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Session;
use Jenssegers\Date\Date;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\ProductType;

class ProductController extends Controller
{
    /**
     * Display the index of Products, 10 per page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $productTypes = ProductType::all();

        if (count($request->all()) > 0)
        {

          $products = Product::take(500);

          $products = $request->product_name ? $products->where('id', $request->product_name) : $products;

          $products = $request->product_type ? $products->where('type_id', $request->product_type) : $products;

          $products = $request->product_price ? $products->where('price', $request->product_price) : $products;

          $products = $products->orderBy('name', 'asc')->paginate(10);

        }
        else
        {
          $products = Product::orderBy('name', 'asc')->paginate(10);
        }

        return view('admin.products.index')->withRequest($request)
                                           ->withProducts($products)
                                           ->withProductTypes($productTypes);
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
     * Store a newly created Product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
          'name'  => 'required|unique:products,name',
          'price' => 'required|numeric',
          'type_id' => 'required|integer',
        ]);

        $product = new Product;

        $product->name        = $request->name;
        $product->description = $request->description;
        $product->price       = $request->price;
        $product->type_id     = $request->type_id;
        $product->creator_id  = Auth::user()->id;

        $product->cover = $request->cover == null ? '/default.png' : $request->file('cover')->store('products');

        $product->save();

        Session::flash('success', "Product <strong>{$product->name}</strong> created successfully!");

        return redirect()->route('admin.products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $productTypes = ProductType::all();
        return view('admin.products.edit')->withProduct($product)
                                          ->withProductTypes($productTypes);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $this->validate($request, [
          'name'    => 'required|min:2',
          'price'   => 'required|numeric',
          'type_id' => 'required|integer',
        ]);

        $product->name        = $request->name;
        $product->description = $request->description;
        $product->price       = $request->price;
        $product->type_id     = $request->type_id;

        // Delete previous uploaded file and store new one
        if ($request->cover == null)
        {
          $product->cover = '/default.png';
        }
        else
        {
          Storage::delete($product->cover);
          $product->cover = $request->cover->store('products', 'public');
        }

        $product->save();

        Session::flash('success', "Product <strong>{$product->name}</strong> updated successfully!");

        return redirect()->route('admin.products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
