<?php

namespace App\Http\Controllers;

use App\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SaleController extends Controller
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
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Sale  $sale
   * @return \Illuminate\Http\Response
   */
  public function show(Request $request, Sale $sale)
  {
    $setting = \App\Setting::find(1);
    if (Hash::check($sale->customer->email, $request->query('source')))
      return view('sale')->withSale($sale)->withSetting($setting);
    else return abort(404);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Sale  $sale
   * @return \Illuminate\Http\Response
   */
  public function edit(Sale $sale)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Sale  $sale
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Sale $sale)
  {
    // Confirm Sale
    $sale->status = 'confirmed';
    // Leave automatic memo indicating self confirmation
    $sale->memo()->create([
      'author_id' => $sale->customer->id,
      'message'   => 'I have confirmed this sale myself on ' . now()->format('l, F j, Y \a\t g:i A') . '.',
      'sale_id'   => $sale->id,
    ]);
    $sale->save();
    // Send confirmation letter to sale creator and customer

    // Return thank you view
    $setting = \App\Setting::find(1);
    if (Hash::check($sale->customer->email, $request->query('source')))
      return view('sale-thank-you')->withSale($sale)->withSetting($setting);
    else abort(404);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Sale  $sale
   * @return \Illuminate\Http\Response
   */
  public function destroy(Sale $sale)
  {
    //
  }
}
