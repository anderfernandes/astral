@extends('layout.report')

@section('title','Payment Transaction Detail Report')

@section('content')

  <style>
    table, .sub.header {font-size: 12px !important}
  </style>

  <div class="ui small centered aligned header">
    {{ App\Setting::find(1)->organization }}
    <div class="sub header">Payment Transaction Detail</div>
  </div>

  <p style="float:right; font-size: 12px !important">Run: {{ Date::now()->format('m/d/Y H:i:s A') }}</p>

  @foreach ($paymentUser as $user)
    @if ($paymentUser->count() > 1)
    <h5 class="ui header">Payment User: {{ $user->fullname }}</h5>
    @endif
    <table class="ui single line table">
    <thead>
      <tr>
        <th>Payment Date and Time</td>
        <th>Sale #</th>
        <th>Customer</th>
        <th>Payment Method</th>
        <th>Reference</th>
        <th>Tendered</th>
        <th>Change</th>
        <th>Amount</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($payments->where('cashier_id', $user->id) as $payment)
        @if ($payment->total < 0)
        <tr class="negative">
        @else
        <tr>
        @endif
          <td>{{ $payment->created_at->format('m/d/Y H:i:s a') }}</td>
          <td>{{ $payment->sale->id }}</td>
          <td>
            {{ $payment->sale->customer->fullname }}
            @if ($payment->sale->sell_to_organization and $payment->sale->customer->firstname != $payment->sale->organization->name)
              ({{ $payment->sale->organization->name }})
            @endif
          </td>
          <td>{{ $payment->method->name }}</td>
          <td>{{ $payment->reference }}</td>
          <td>$ {{ number_format($payment->tendered, 2) }}</td>
          <td>$ {{ number_format($payment->change_due, 2) }}</td>
          <td>$ {{ number_format($payment->tendered - $payment->change_due, 2) }}</td>
        </tr>
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <th colspan="8" class="right aligned">
          <strong>
            Totals for {{ $paymentUser[$loop->index]->firstname }}:
            $ {{ number_format($payments->where('cashier_id', $user->id)->sum('tendered') - $payments->where('cashier_id', $user->id)->sum('change_due'),2) }}
          </strong>
        </th>
      </tr>
    </tfoot>
  </table>
  @endforeach

  @if ($paymentUser->count() > 1)
  <table class="ui single line table">
    <tfoot>
      <tr>
        <th colspan="8" class="right aligned">
          <strong>
            Totals for
            @foreach ($paymentUser as $user)
              @if ($loop->first)
                {{ $user->fullname }}
              @elseif ($loop->last)
                and {{ $user->fullname }}
              @else
                , {{ $user->fullname }}
              @endif
            @endforeach
            : $ {{ $totals }}
          </strong>
        </th>
      </tr>
    </tfoot>
  </table>
  @endif
@endsection
