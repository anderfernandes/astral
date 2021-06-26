<?php

namespace App\Http\Controllers\Api\Cashier;

use App\{ User, Setting };
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

      $settings = Setting::find(1);
        
      $allCustomers = $settings->cashier_customer_dropdown
        ? User::where('membership_id', '!=', 1)->orWhere('id', 1)->get()
        : User::all();

      if ($settings->cashier_customer_dropdown)
        $customers = $allCustomers->map(function ($item) {
          $extra = "";
          if ($item->membership_id != 1) {
            $membership = $item->membership;
            $extra = $membership->primary_id == $item->id ? "(P)" : "(S)";
            $end = $membership->end->diffForHumans();
            $word = $membership->expired ? "expired" : "expires";
            $extra = "{$extra} ({$word} {$end})";
          }
          if ($item['id'] == 1)
            $data = $item['fullname'];
          else
            $data = "{$item['membership_number']} {$item['fullname']}";
          return [ 
            'id' => $item['id'],
            'fullname' => "{$data} {$extra}",
          ];
      });
      else
        $customers = $allCustomers->map(function ($item) {
          $extra = "";
          if ($item->membership_id != 1) {
            $membership = $item->membership;
            $extra = $membership->primary_id == $item->id ? "({$item->membership_number}) (P)" : "({$item->membership_number}) (S)";
            $end = $membership->end->diffForHumans();
            $word = $membership->expired ? "expired" : "expires";
            $extra = " {$extra} ({$word} {$end})";
          }
          return [ 
            'id' => $item['id'],
            'fullname' => $item['fullname'] . $extra,
          ];
        });

        return response()->json([
          'data' => $customers->all(),
        ]);
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
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
