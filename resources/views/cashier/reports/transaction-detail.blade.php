@extends('layout.report')

@section('title', Auth::user()->firstname.' '.Auth::user()->lastname.'s Payment Transaction Detail Report')

@section('content')

<style>
  table, .sub.header {font-size: 12px !important}
</style>

<div class="ui small centered aligned header">
  {{ App\Setting::find(1)->organization }}
  <div class="sub header">Payment Transaction Detail</div>
</div>

<p style="float:right; font-size: 12px !important">Run: {{ Date::now()->format('m/d/Y H:i:s A') }}</p>

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
    @foreach ($payments as $payment)

      <tr>
        <td>{{ $payment->created_at->format('m/d/Y H:i:s a') }}</td>
        <td>{{ $payment->sale->id }}</td>
        <td>{{ $payment->sale->customer->firstname }} {{ $payment->sale->customer->lastname }}</td>
        <td>{{ $payment->method->name }}</td>
        <td>{{ $payment->reference }}</td>
        <td>$ {{ number_format($payment->tendered, 2) }}</td>
        <td>$ {{ number_format($payment->change_due, 2) }}</td>
        <td>$ {{ number_format($payment->total, 2) }}</td>
      </tr>

    @if ($payment->sale->refund)
    <tr class="negative">
      <td>{{ $payment->created_at->format('m/d/Y H:i:s a') }}</td>
      <td>{{ $payment->sale->id }}</td>
      <td>{{ $payment->sale->customer->firstname }} {{ $payment->sale->customer->lastname }}</td>
      <td>{{ $payment->method->name }}</td>
      <td>{{ $payment->reference }}</td>
      <td>$ {{ number_format($payment->tendered, 2) }}</td>
      <td>$ {{ number_format($payment->change_due, 2) }}</td>
      <td>($ {{ number_format($payment->total, 2) }})</td>
    </tr>
    @endif

    </tr>
    @endforeach
  </tbody>
  <tfoot>
    <tr>
      <th colspan="8" class="right aligned">
        <strong>Totals for {{ Auth::user()->firstname }}: $ {{ $totals }}</strong>
      </th>
    </tr>
  </tfoot>
</table>

@endsection
