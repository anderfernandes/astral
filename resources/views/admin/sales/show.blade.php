@extends('layout.admin')

@section('title', 'Sale Information | Sale #'.$sale->id)

@section('content')

  <h2 class="ui dividing header">
    <i class="dollar icon"></i>
    <div class="content">
      Sale # {{ $sale->id }}
      <div class="sub header">
        by {{ $sale->cashier->firstname }} {{ $sale->cashier->lastname }}
        on {{ Date::parse($sale->created_at)->format('l, F j, Y \a\t g:i A') }}
        ({{ Date::parse($sale->created_at)->diffForHumans() }})
      </div>
    </div>
  </h2>

  <div class="ui two column grid">
    <div class="column">
      <h2 class="ui header">
        <div class="sub header">Sale #</div>
        {{ $sale->id }}
      </h2>

      <h2 class="ui header">
        <div class="sub header">Source</div>
        {{ $sale->source }}
      </h2>

      <h2 class="ui header">
        <div class="sub header">Created on</div>
        {{ Date::parse($sale->created_at)->format('l, F j, Y \a\t g:i A') }}
        ({{ Date::parse($sale->created_at)->diffForHumans() }})
      </h2>

      <h2 class="ui header">
        <div class="sub header">Updated on</div>
        {{ Date::parse($sale->updated_at)->format('l, F j, Y \a\t g:i A') }}
        ({{ Date::parse($sale->updated_at)->diffForHumans() }})
      </h2>
    </div>
    <div class="column">
      <h2 class="ui header">
        <div class="sub header">Payment Method</div>
        @if ($sale->payment_method == 'visa')
          <i class="visa icon"></i>
        @elseif ($sale->payment_method == 'mastercard')
          <i class="mastercard icon"></i>
        @elseif ($sale->payment_method == 'discover')
          <i class="discover icon"></i>
        @elseif ($sale->payment_method == 'american express')
          <i class="american express icon"></i>
        @else
          <i class="money icon"></i>
        @endif
      </h2>
      @if ($sale->reference)
      <h2 class="ui header">
        <div class="sub header">Reference</div>
        {{ $sale->reference }}
      </h2>
      @endif

      <h2 class="ui header">
        <div class="sub header">Subtotal</div>
        $ {{ number_format($sale->subtotal, 2) }}
      </h2>

      <h2 class="ui header">
        <div class="sub header">Tax</div>
        $ {{ number_format($sale->total - $sale->subtotal, 2) }}
      </h2>

      <h2 class="ui header">
        <div class="sub header">Total</div>
        $ {{ number_format($sale->total, 2) }}
      </h2>
    </div>
  </div>

  <table class="ui celled padded table">
    <thead>
      <tr>
        <th class="single line">Ticket Number</th>
        <th>Type</th>
        <th>Show Name</th>
        <th>Show Date</th>
        <th>Sale #</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($sale->tickets as $ticket)
      <tr>
        <th>{{ $ticket->id }}</th>
        <th>{{ $ticket->type }}</th>
        <th>{{ App\Event::find($ticket->event_id)->show->name }}</th>
        <th>{{ Date::parse($ticket->created_at)->format('l, F j, Y \a\t g:i A') }}</th>
        <th>{{ $sale->id }}</th>
      </tr>
      @endforeach
    </tbody>
  </table>

@endsection
