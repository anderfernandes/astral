@extends('layout.report')

@section('title', 'Closeout Report')

@section('content')

  <div class="ui header">
    Closeout Report
    <div class="sub header">Run: {{ Date::now()->format('l, F j, Y \a\t g:i:s A') }}</div>
    <div class="sub header">Payment Date: {{ Date::parse($date)->format('l, F j, Y') }}</div>
    @if ($paymentUser->count() == 1)
      <div class="sub header">Payment User: {{ $paymentUser[0]->fullname }}</div>
    @else
      <div class="sub header">Payment Users:
        @foreach ($paymentUser as $user)
          @if ($loop->first)
            {{ $user->fullname }}
          @elseif ($loop->last)
            and {{ $user->fullname }}
          @else
            , {{ $user->fullname }}
          @endif
        @endforeach
      </div>
    @endif
  </div>

  @foreach ($paymentUser as $user)
    @if ($paymentUser->count() > 1)
      <h5 class="ui header">Payment User: {{ $user->fullname }}</h5>
    @endif
    <table class="ui very basic collapsing celled table">
      {{-- Cash Payments --}}
      @if ($cashPayments->where('cashier_id', $user->id)->count() > 0)
        <thead>
          <tr>
            <th>Method</th>
            <th>Transactions</th>
            <th>Amount</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Cash</td>
            <td>{{ $cashPayments->where('cashier_id', $user->id)->count() }}</td>
            <td class="right aligned">$
              <?php
              $cashPaymentsTotal = 0;
              foreach ($cashPayments->where('cashier_id', $user->id) as $cashPayment)
              {
                $cashPaymentsTotal += $cashPayment->tendered - $cashPayment->change_due;
              }
              echo number_format($cashPaymentsTotal, 2)
              ?>
            </td>
          </tr>
        @else
          <?php $cashPaymentsTotal = 0 ?>
        @endif
        {{-- Cash Refunds --}}
        @if ($cashRefunds->where('cashier_id', $user->id)->count() > 0)
          <tr>
            <td>Cash Refunds</td>
            <td>{{ $cashRefunds->where('cashier_id', $user->id)->count() }}</td>
            <td class="right aligned">$
              <?php
              $cashRefundsTotal = 0;
              foreach ($cashRefunds as $cashRefund)
              {
                $cashRefundsTotal += $cashRefund->tendered - $cashRefund->change_due;
              }
              echo '(' . number_format($cashRefundsTotal, 2) .')'
              ?>
            </td>
          </tr>
        @else
          <?php $cashRefundsTotal = 0 ?>
        @endif
        {{-- Card Payments --}}
        @if ($cardPayments->where('cashier_id', $user->id)->count() > 0)
          <tr>
            <td>Credit Card</td>
            <td>{{ $cardPayments->where('cashier_id', $user->id)->count() }}</td>
            <td class="right aligned">$
              <?php
              $cardPaymentsTotal = 0;
              foreach ($cardPayments->where('cashier_id', $user->id) as $cardPayment)
              {
                $cardPaymentsTotal += $cardPayment->tendered - $cardPayment->change_due;
              }
              echo number_format($cardPaymentsTotal, 2)
              ?>
            </td>
          </tr>
        @else
          <?php $cardPaymentsTotal = 0 ?>
        @endif
        {{-- Card Refunds --}}
        @if ($cardRefunds->where('cashier_id', $user->id)->count() > 0)
          <tr>
            <td>Credit Card Refunds</td>
            <td>{{ $cardRefunds->where('cashier_id', $user->id)->count() }}</td>
            <td class="right aligned">$
              <?php
              $cardRefundsTotal = 0;
              foreach ($cardRefunds->where('cashier_id', $user->id) as $cardRefund)
              {
                $cardRefundsTotal += $cardRefund->tendered - $cardRefund->change_due;
              }
              echo '(' . number_format($cardRefundsTotal, 2) .')'
              ?>
            </td>
          </tr>
        @else
          <?php $cardRefundsTotal = 0 ?>
        @endif
        {{-- Check Payments --}}
        @if ($checkPayments->where('cashier_id', $user->id)->count() > 0)
          <tr>
            <td>Check</td>
            <td>{{ $checkPayments->where('cashier_id', $user->id)->count() }}</td>
            <td>$
              <?php
              $checkPaymentsTotal = 0;
              foreach ($checkPayments->where('cashier_id', $user->id) as $checkPayment)
              {
                $checkPaymentsTotal += $checkPayment->tendered - $checkPayment->change_due;
              }
              echo number_format($checkPaymentsTotal, 2)
              ?>
            </td>
          </tr>
        @else
          <?php $checkPaymentsTotal = 0 ?>
        @endif
        {{-- Check Refunds --}}
        @if ($checkRefunds->where('cashier_id', $user->id)->count() > 0)
          <tr>
            <td>Check Refunds</td>
            <td>{{ $checkRefunds->where('cashier_id', $user->id)->count() }}</td>
            <td class="right aligned">$
              <?php
              $checkRefundsTotal = 0;
              foreach ($checkRefunds->where('cashier_id', $user->id) as $checkRefund)
              {
                $checkRefundsTotal += $checkRefund->tendered - $checkRefund->change_due;
              }
              echo '(' . number_format($checkRefundsTotal, 2) .')'
              ?>
            </td>
          </tr>
        </tbody>
      @else
        <?php $checkRefundsTotal = 0 ?>
      @endif
      {{-- Other Payments --}}
      {{-- Other Refunds --}}
      {{-- User Totals --}}
      @if ($paymentUser->count() > 1)
        <tr>
          <td colspan="3">
            {{ Date::parse($date)->format('m/d/Y') }}
            {{ $user->firstname }}'s Transactions: <span style="float:right">
              {{
                ($cashPayments->where('cashier_id', $user->id)->count()) +
                ($cashRefunds->where('cashier_id', $user->id)->count()) +
                ($cardPayments->where('cashier_id', $user->id)->count()) +
                ($cardRefunds->where('cashier_id', $user->id)->count()) +
                ($checkPayments->where('cashier_id', $user->id)->count()) +
                ($checkRefunds->where('cashier_id', $user->id)->count())
              }}
            </td>
          </tr>
          <tr>
            <td colspan="3">
              {{ Date::parse($date)->format('m/d/Y') }}
              {{ $user->firstname }}'s' Totals: <span style="float:right">
                $ {{ number_format($cashPaymentsTotal + $cashRefundsTotal + $cardPaymentsTotal + $cardRefundsTotal + $checkPaymentsTotal + $checkRefundsTotal, 2) }}
              </td>
            </tr>
          @endif
        </table>
      @endforeach
      <table class="ui very basic collapsing table">
        <tbody>
          <tr>
            <td colspan="2">
              <strong>
                {{ Date::parse($date)->format('m/d/Y') }}
                Transactions:
              </strong>
            </td>
            <td></td>
            <td class="right aligned">
              <strong>
                {{ count($cashPayments) + count($cashRefunds) + count($cardPayments) + count($cardRefunds) + count($checkPayments) + count($checkRefunds) }}
              </strong>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <strong>
                {{ Date::parse($date)->format('m/d/Y') }}
                Totals:
              </strong>
            </td>
            <td></td>
            <td class="right aligned">
              <strong>
                $ {{ number_format($totals, 2) }}
              </strong>
            </td>
          </tr>
        </tbody>
      </table>

      <p>End of Report</p>

    @endsection
