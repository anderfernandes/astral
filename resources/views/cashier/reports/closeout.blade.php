@extends('layout.report')

@section('title', Auth::user()->firstname.' '.Auth::user()->lastname.'s Closeout Report')

@section('content')

  <style>
    table, .sub.header {font-size: 12px !important}
  </style>

  <div class="ui small header">
    Closeout Report
    <div class="sub header">Run: {{ Date::now()->format('l, F j, Y \a\t g:i:s A') }}</div>
    <div class="sub header">Payment Date: {{ Date::now()->format('l, F j, Y') }}</div>
    <div class="sub header">Payment User: {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</div>
  </div>

  <table class="ui very basic collapsing celled table">
  @if (count($cashPayments) > 0)

      <tr>
        <td><strong>Quantity</strong></td>
        <td><strong>Method</strong></td>
        <td><strong>Amount</strong></td>
      </tr>

      <tr>
        <td>{{ count($cashPayments) }}</td>
        <td>Cash</td>
        <td class="right aligned">$
          <?php
            $cashPaymentsTotal = 0;
            foreach ($cashPayments as $cashPayment)
            {
              $cashPaymentsTotal += $cashPayment['tendered'] - $cashPayment['change_due'];
            }
            echo number_format($cashPaymentsTotal, 2)
            ?>
        </td>
      </tr>

      <tr>
        <td colspan="3">
          <strong>Cash Totals: <span style="float:right">$ {{ number_format($cashPaymentsTotal, 2) }}</span></strong>
        </td>
      </tr>

      <tr>
        <td colspan="3">
          Transactions: {{ count($cashPayments) }}
        </td>
      </tr>
  @else
      <?php $cashPaymentsTotal = 0 ?>
  @endif

  @if (count($cardPayments) > 0)

      <tr>
        <td><strong>Quantity</strong></td>
        <td><strong>Method</strong></td>
        <td><strong>Amount</strong></td>
      </tr>

      <tr>
        <td>{{ count($cardPayments) }}</td>
        <td>Credit Card</td>
        <td class="right aligned">$
          <?php
            $cardPaymentsTotal = 0;
            foreach ($cardPayments as $cardPayment)
            {
              $cardPaymentsTotal += $cardPayment['tendered'] - $cardPayment['change_due'];
            }
            echo number_format($cardPaymentsTotal, 2)
            ?>
        </td>
      </tr>

      <tr>
        <td colspan="3">
          <strong>Card Totals: <span style="float:right">$ {{ number_format($cardPaymentsTotal, 2) }}</span></strong>
        </td>
      </tr>
      <tr>
        <td colspan="3">
          Transactions: {{ count($cardPayments) }}
        </td>
      </tr>
  @else
      <?php $cardPaymentsTotal = 0 ?>
  @endif

  @if (count($checkPayments) > 0)

      <tr>
        <td><strong>Quantity</strong></td>
        <td><strong>Method</strong></td>
        <td><strong>Amount</strong></td>
      </tr>

      <tr>
        <td>{{ count($checkPayments) }}</td>
        <td>Check</td>
        <td>$
          <?php
            $checkPaymentsTotal = 0;
            foreach ($checkPayments as $checkPayment)
            {
              $checkPaymentsTotal += $checkPayment['tendered'] - $checkPayment['change_due'];
            }
            echo number_format($checkPaymentsTotal, 2)
          ?>
        </td>
      </tr>

      <tr>
        <td colspan="3">
          Check Totals: <span style="float:right">$ {{ number_format($checkPaymentsTotal, 2) }}</span>
        </td>
      </tr>

      <tr>
        <td colspan="3">
          Transactions: {{ count($checkPayments) }}
        </td>
      </tr>
  @else
    <?php $checkPaymentsTotal = 0 ?>
  @endif

      <tr>
        <td colspan="3">
          {{ Date::now()->format('m/d/Y') }}
          Totals: <span style="float:right">$ {{ number_format($cashPaymentsTotal + $cardPaymentsTotal + $checkPaymentsTotal, 2) }}
        </td>
      </tr>

  </table>

  <p>End of Report</p>

@endsection
