@extends('layout.report')

@section('title', Auth::user()->firstname.' '.Auth::user()->lastname.'s Payment Transaction Detail Report')

@section('content')

<div class="ui centered aligned header">
  {{ App\Setting::find(1)->organization }}
  <div class="sub header">Payment Transaction Detail</div>
</div>

<p style="float:right">Run: {{ Date::now()->format('m/d/Y H:i:s A') }}</p>

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
    @foreach ($sales as $sale)

    @if ($sale->refund)
    <tr class="negative">
    @else
    <tr>
    @endif
      <td>{{ $sale->created_at->format('m/d/Y H:i:s a') }}</td>
      <td>{{ $sale->id }}</td>
      <td>{{ $sale->customer->firstname }} {{ $sale->customer->lastname }}</td>
      <td>{{ $sale->payment_method }}</td>
      <td>{{ $sale->reference }}</td>
      <td>$ {{ number_format($sale->tendered, 2) }}</td>
      <td>$ {{ number_format($sale->change_due, 2) }}</td>
      <td>$ {{ number_format($sale->total, 2) }}</td>
    </tr>
    @endforeach
  </tbody>
  <tfoot>
    <tr>
      <th colspan="8" class="right aligned">
        <strong>Totals for {{ Auth::user()->firstname }}: $
          <?php $totals = 0; foreach ($sales as $sale) { $totals += $sale['total']; } echo number_format($totals, 2)?>
        </strong>
      </th>
    </tr>
  </tfoot>
</table>

@endsection
