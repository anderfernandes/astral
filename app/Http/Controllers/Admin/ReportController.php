<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use App\Event;
use Jenssegers\Date\Date;
use App\Sale;
use App\Ticket;
use App\Payment;
use App\PaymentMethod;
use App\User;
use Session;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.reports.index');
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

    public function reports($type, $id, $date)
    {
      $user = User::find($id);
      $date = new Date($date);
      $date = $date->toDateTimeString();
      $today = Date::now()->startOfDay();

      $sales = Sale::where([
        ['updated_at', '>=', $date],
        ['refund', '=', false],
      ])->orderBy('created_at', 'asc')->get();

      // Get Card Sales IDs
      $salesIds = array_pluck($sales, 'id');
      // Find all payments for the IDs we retrieved
      $payments = Payment::where('cashier_id', $id)->whereIn('sale_id', $salesIds)->get();

      if ($type == 'closeout')
      {

        $cashPayments = [];
        $cardPayments = [];
        $checkPayments = [];
        $otherPayments = [];

        // Get payments of a particular payment_method type
        foreach ($payments as $payment) {
          if ($payment->method->type == 'cash')
            array_unshift($cashPayments, $payment);
          else if ($payment->method->type == 'card')
            array_unshift($cardPayments, $payment);
          else if ($payment->method->type == 'check')
            array_unshift($checkPayments, $payment);
          else
            array_unshift($otherPayments, $payment);
        }

        return view('admin.reports.closeout')->with('cashPayments', $cashPayments)
                                             ->with('cardPayments', $cardPayments)
                                             ->with('checkPayments', $checkPayments)
                                             ->with('otherPayments', $otherPayments)
                                             ->with('paymentUser', $user)
                                             ->withDate($date);
      }
      if ($type == 'transaction-detail')
      {

        $totals = 0;
        foreach ($payments as $payment) {
          if ($payment->sale->refund == false)
            $totals += $payment['tendered'] - $payment['change_due'];
        }

        $totals = number_format($totals, 2);

        return view('admin.reports.transaction-detail')->withPayments($payments)
                                                       ->withTotals($totals)
                                                       ->withPaymentUser($user)
                                                       ->withDate($date);
      }
    }
}
