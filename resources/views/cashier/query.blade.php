@extends('layout.cashier')

@section('title', 'Cashier')

@section('icon', 'inbox')

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
  <table class="ui celled padded selectable striped table">
    <thead>
      <tr>
        <th class="single line">Sale Number</th>
        <th>Sale Payment Method</th>
        <th>Sale Reference</th>
        <th>Sale Total</th>
        <th>Sale Source</th>
        <th>Cashier</th>
        <th>Date and Time</th>
      </tr>
    </thead>
    <tbody>
    @foreach($results as $result)
      @if ($result->refund)
      <tr class="negative">
      @else
      <tr>
      @endif
        <td class="single line selectable">
          <a href="{{ route ('cashier.sale', $result->id) }}" target="_blank"><h2 class="ui center aligned header">{{ $result->id }}</h2></a>
        </td>
        <td class="selectable">
          @if ($result->payment_method == 'visa')
            <a href="{{ route ('cashier.sale', $result->id) }}" target="_blank"><h2 class="ui center aligned header"><i class="visa icon"></i></h2></a>
          @elseif ($result->payment_method == 'mastercard')
            <a href="{{ route ('cashier.sale', $result->id) }}" target="_blank"><h2 class="ui center aligned header"><i class="mastercard icon"></i></h2></a>
          @elseif ($result->payment_method == 'discover')
            <a href="{{ route ('cashier.sale', $result->id) }}" target="_blank"><h2 class="ui center aligned header"><i class="discover icon"></i></h2></a>
          @elseif ($result->payment_method == 'american express')
            <a href="{{ route ('cashier.sale', $result->id) }}" target="_blank"><h2 class="ui center aligned header"><i class="american express icon"></i></h2></a>
          @elseif ($result->payment_method == 'check')
            <a href="{{ route ('cashier.sale', $result->id) }}" target="_blank"><h2 class="ui center aligned header"><i class="check icon"></i></h2></a>
          @else
            <a href="{{ route ('cashier.sale', $result->id) }}" target="_blank"><h2 class="ui center aligned header"><i class="money icon"></i></h2></a>
          @endif
        </td>
        <td class="selectable">
          <a href="{{ route ('cashier.sale', $result->id) }}" target="_blank">{{ $result->reference }}</a>
        </td>
        <td class="selectable">
          @if ($result->refund == true)
            <a href="{{ route ('cashier.sale', $result->id) }}" target="_blank">($ {{ number_format($result->total, 2) }})</a>
          @else
            <a href="{{ route ('cashier.sale', $result->id) }}" target="_blank">$ {{ number_format($result->total, 2) }}</a>
          @endif
        </td>
        <td class="selectable"><a href="{{ route ('cashier.sale', $result->id) }}" target="_blank">{{ $result->source }}</a></td>
        <td class="selectable"><a href="{{ route ('cashier.sale', $result->id) }}" target="_blank">{{ App\User::find($result->cashier_id)->firstname }} {{ App\User::find($result->cashier_id)->lastname }}</a></td>
        <td class="selectable"><a href="{{ route ('cashier.sale', $result->id) }}" target="_blank">{{ Date::parse($result->created_at)->format('l, F j, Y \a\t g:i A') }}</a></td>
      </tr>
    @endforeach
    </tbody>
  </table>
  @endif

  @endsection
