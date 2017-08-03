@extends('layout.cashier')

@section('title', 'Cashier')

@section('icon', 'dollar')

@section('name', 'Cashier | Query | '.Auth::user()->firstname.' '.Auth::user()->lastname)

@section('content')

  @if (count($results) < 1)
    <div class="ui info icon message">
      <i class="info circle icon"></i>
      <i class="close icon"></i>
      <div class="content">
        <div class="header">
          No results!
        </div>
        <p>Your search has returned no results.</p>
      </div>
    </div>
  @else
  <table class="ui celled padded table">
    <thead>
      <tr>
        <th class="single line">Sale Number</th>
        <th>Sale Payment Method</th>
        <th>Sale Reference</th>
        <th>Sale Total</th>
        <th>Sale Source</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
    @foreach($results as $result)
      <tr>
        <td>
          <h2 class="ui center aligned header">{{ $result->id }}</h2>
        </td>
        <td class="single line">
          {{ $result->payment_method }}
        </td>
        <td>
          {{ $result->reference }}
        </td>
        <td class="right aligned">
          $ {{ number_format($result->total, 2) }}
        </td>
        <td>{{ $result->source }}</td>
        <td><a href="#" class="ui secondary button"><i class="cancel icon"></i> Refund</a></td>
      </tr>
    @endforeach
    </tbody>
  </table>
  @endif

  @endsection
