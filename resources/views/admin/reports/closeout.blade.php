@extends('layout.report')

@section('title', $paymentUser->fullname . '\'s Closeout Report')

@section('content')

  <div class="ui header">
    Closeout Report
    <div class="sub header">Run: {{ Date::now()->format('l, F j, Y \a\t g:i:s A') }}</div>
    <div class="sub header">Payment Date: {{ Date::parse($date)->format('l, F j, Y') }}</div>
    <div class="sub header">Payment User: {{ $paymentUser->firstname }} {{ $paymentUser->lastname }}</div>
  </div>

  <table class="ui very basic collapsing celled table">
  @if (count($cashPayments) > 0)

      <tr>
        <td><strong>Method</strong></td>
        <td><strong>Transactions</strong></td>
        <td><strong>Amount</strong></td>
      </tr>

      <tr>
        <td>Cash</td>
        <td>{{ count($cashPayments) }}</td>
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

  @else
      <?php $cashPaymentsTotal = 0 ?>
  @endif

  @if (count($cashRefunds) > 0)

      <tr>
        <td><strong>Method</strong></td>
        <td><strong>Transactions</strong></td>
        <td><strong>Amount</strong></td>
      </tr>

      <tr>
        <td>Cash</td>
        <td>{{ count($cashRefunds) }}</td>
        <td class="right aligned">$
          <?php
            $cashRefundsTotal = 0;
            foreach ($cashRefunds as $cashRefund)
            {
              $cashRefundsTotal += $cashRefund['tendered'] - $cashRefund['change_due'];
            }
            echo '(' . number_format($cashRefundsTotal, 2) .')'
            ?>
        </td>
      </tr>

      <tr>
        <td colspan="3">
          <strong>Cash Totals: <span style="float:right">$ ({{ number_format($cashRefundsTotal, 2) }})</span></strong>
        </td>
      </tr>

  @else
      <?php $cashRefundsTotal = 0 ?>
  @endif

  @if (count($cardPayments) > 0)

      <tr>
        <td><strong>Method</strong></td>
        <td><strong>Transactions</strong></td>
        <td><strong>Amount</strong></td>
      </tr>

      <tr>
        <td>Credit Card</td>
        <td>{{ count($cardPayments) }}</td>
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

  @else
      <?php $cardPaymentsTotal = 0 ?>
  @endif

  @if (count($cardRefunds) > 0)

      <tr>
        <td><strong>Method</strong></td>
        <td><strong>Transactions</strong></td>
        <td><strong>Amount</strong></td>
      </tr>

      <tr>
        <td>Credit Card</td>
        <td>{{ count($cardRefunds) }}</td>
        <td class="right aligned">$
          <?php
            $cardRefundsTotal = 0;
            foreach ($cardRefunds as $cardRefund)
            {
              $cardRefundsTotal += $cardRefund['tendered'] - $cardRefund['change_due'];
            }
            echo '(' . number_format($cardRefundsTotal, 2) .')'
            ?>
        </td>
      </tr>

      <tr>
        <td colspan="3">
          <strong>Card Totals: <span style="float:right">$ ({{ number_format($cardRefundsTotal, 2) }})</span></strong>
        </td>
      </tr>

  @else
      <?php $cardRefundsTotal = 0 ?>
  @endif

  @if (count($checkPayments) > 0)

      <tr>
        <td><strong>Method</strong></td>
        <td><strong>Transactions</strong></td>
        <td><strong>Amount</strong></td>
      </tr>

      <tr>
        <td>Check</td>
        <td>{{ count($checkPayments) }}</td>
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

  @else
    <?php $checkPaymentsTotal = 0 ?>
  @endif
  {{-- Check refunds --}}
  @if (count($checkRefunds) > 0)

      <tr>
        <td><strong>Method</strong></td>
        <td><strong>Transactions</strong></td>
        <td><strong>Amount</strong></td>
      </tr>

      <tr>
        <td>Check</td>
        <td>{{ count($checkRefunds) }}</td>
        <td class="right aligned">$
          <?php
            $checkRefundsTotal = 0;
            foreach ($checkRefunds as $checkRefund)
            {
              $checkRefundsTotal += $checkRefund['tendered'] - $checkRefund['change_due'];
            }
            echo '(' . number_format($checkRefundsTotal, 2) .')'
            ?>
        </td>
      </tr>

      <tr>
        <td colspan="3">
          <strong>Check Totals: <span style="float:right">$ ({{ number_format($checkRefundsTotal, 2) }})</span></strong>
        </td>
      </tr>

  @else
      <?php $checkRefundsTotal = 0 ?>
  @endif

      <tr>
        <td colspan="3">
          {{ Date::parse($date)->format('m/d/Y') }}
          Totals: <span style="float:right">
            $ {{ number_format($cashPaymentsTotal + $cashRefundsTotal + $cardPaymentsTotal + $cardRefundsTotal + $checkPaymentsTotal + $checkRefundsTotal, 2) }}
        </td>
      </tr>

  </table>

  <p>End of Report</p>

@endsection
