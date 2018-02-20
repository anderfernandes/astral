<?php

namespace App\Http\Controllers\Cashier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use App\Event;
use Jenssegers\Date\Date;
use App\Sale;
use App\Ticket;
use App\Payment;
use App\PaymentMethod;
use App\User;


class ReportController extends Controller
{

  public function reports($type)
  {
    $today = Date::now()->startOfDay();

    $sales = Sale::where([
      ['updated_at', '>=', $today],
      ['refund', '=', false],
    ])->orderBy('created_at', 'asc')->get();

    // Get Card Sales IDs
    $salesIds = array_pluck($sales, 'id');
    // Find all payments for the IDs we retrieved
    $payments = Payment::where('cashier_id', Auth::user()->id)->whereIn('sale_id', $salesIds)->get();

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

      return view('cashier.reports.closeout')->with('cashPayments', $cashPayments)
                                             ->with('cardPayments', $cardPayments)
                                             ->with('checkPayments', $checkPayments)
                                             ->with('otherPayments', $otherPayments);
    }
    if ($type == 'transaction-detail')
    {

      $totals = 0;
      foreach ($payments as $payment) {
        if ($payment->sale->refund == false)
          $totals += $payment['tendered'] - $payment['change_due'];
      }

      $totals = number_format($totals, 2);

      return view('cashier.reports.transaction-detail')->withPayments($payments)->withTotals($totals);
    }
  }
}
