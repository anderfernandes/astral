@extends('layout.report')

@section('title', Auth::user()->firstname.' '.Auth::user()->lastname.'s Closeout Report')

@section('content')

  <div class="ui header">
    Closeout Report
    <div class="sub header">Run: {{ Date::now()->format('l, F j, Y \a\t g:i:s A') }}</div>
    <div class="sub header">Payment Date: {{ Date::now()->format('l, F j, Y') }}</div>
    <div class="sub header">Payment User: {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</div>
  </div>

  <table class="ui very basic collapsing celled table">
  @if (count($cashSales) > 0)

      <tr>
        <td><strong>Quantity</strong></td>
        <td><strong>Method</strong></td>
        <td><strong>Amount</strong></td>
      </tr>

      <tr>
        <td>{{ count($cashSales) }}</td>
        <td>Cash</td>
        <td class="right aligned">$
          <?php
            $cashSalesTotal = 0;
            foreach ($cashSales as $cashSale)
            {
              $cashSalesTotal += $cashSale['total'];
            }
            echo number_format($cashSalesTotal, 2)
            ?>
        </td>
      </tr>

      <tr>
        <td colspan="3">
          <strong>User Totals: <span style="float:right">$ {{ number_format($cashSalesTotal, 2) }}</span></strong>
        </td>
      </tr>

      <tr>
        <td colspan="3">
          Transactions: {{ count($cashSales) }}
        </td>
      </tr>
  @else
      <?php $cashSalesTotal = 0 ?>
  @endif

  @if (count($cardSales) > 0)

      <tr>
        <td><strong>Quantity</strong></td>
        <td><strong>Method</strong></td>
        <td><strong>Amount</strong></td>
      </tr>

      <tr>
        <td>{{ count($cardSales) }}</td>
        <td>Credit Card</td>
        <td class="right aligned">$
          <?php
            $cardSalesTotal = 0;
            foreach ($cardSales as $cardSale)
            {
              $cardSalesTotal += $cardSale['total'];
            }
            echo number_format($cardSalesTotal, 2)
            ?>
        </td>
      </tr>

      <tr>
        <td colspan="3">
          <strong>User Totals: <span style="float:right">$ {{ number_format($cardSalesTotal, 2) }}</span></strong>
        </td>
      </tr>
      <tr>
        <td colspan="3">
          Transactions: {{ count($cardSales) }}
        </td>
      </tr>
  @else
      <?php $cardSalesTotal = 0 ?>
  @endif

  @if (count($checkSales) > 0)

      <tr>
        <td><strong>Quantity</strong></td>
        <td><strong>Method</strong></td>
        <td><strong>Amount</strong></td>
      </tr>

      <tr>
        <td>{{ count($checkSales) }}</td>
        <td>Check</td>
        <td>$
          <?php
            $checkSalesTotal = 0;
            foreach ($checkSales as $checkSale)
            {
              $checkSalesTotal += $checkSale['total'];
            }
            echo number_format($checkSalesTotal, 2)
          ?>
        </td>
      </tr>

      <tr>
        <td colspan="3">
          User Totals: <span style="float:right">$ {{ number_format($checkSalesTotal, 2) }}</span>
        </td>
      </tr>

      <tr>
        <td colspan="3">
          Transactions: {{ count($checkSales) }}
        </td>
      </tr>
  @else
    <?php $checkSalesTotal = 0 ?>
  @endif

      <tr>
        <td colspan="3">
          {{ Date::now()->format('m/d/Y') }}
          Totals: <span style="float:right">$ {{ $cashSalesTotal + $cardSalesTotal + $checkSalesTotal }}
        </td>
      </tr>

  </table>

  <p>End of Report</p>

@endsection
