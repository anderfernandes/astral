@extends('layout.report')

<?php

$title = $sale->organization->name != $sale->customer->fullname ? $sale->organization->name . '\'s' : $sale->organization->name . '\'s ' . $sale->customer->fullname

?>

@section('title', $title . ' Receipt')

@section('content')

  <style>
    @media print {
      .ui.icon.buttons {
        display: none !important;
      }
      p, h4.ui.header, table, thead, tbody, ul, li, h4.ui.header .sub.header {
        font-size: 0.78rem !important;
      }
    }
  </style>

  <div class="ui icon right floated buttons" style="margin-bottom:5rem">
    <a href="{{ route('admin.sales.receipt', $sale)}}?format=pdf" target="_blank" class="ui basic black button"><i class="file pdf outline icon"></i></a>
    <div onclick="window.print()" class="ui black button"><i class="print icon"></i></div>
    <div onclick="window.close()" class="ui red button"><i class="close icon"></i></div>
  </div>

  <img src="{{ (App\Setting::find(1)->logo == '/logo.png') ? App\Setting::find(1)->logo : Storage::url(App\Setting::find(1)->logo) }}" alt="" class="ui centered mini image">

  <div class="ui center aligned icon header" style="margin-top:8px">
    <div class="content">Receipt</div>
  </div>

  <div class="ui clearing basic segment" style="padding:0 0 0 0">

    <h4 class="ui left floated header">
      Date: {{ Date::now()->format('l, F j, Y') }}
    </h4>

    <h4 class="ui right floated header">
      Receipt # {{ $sale->id }}
    </h4>

  </div>

  <div class="ui clearing basic segment" style="padding:0 0 0 0">

    <h4 class="ui left floated header">
      @if ($sale->sell_to_organization)
        {{ $sale->organization->name }}<br />
        @if (!($sale->organization->name == $sale->customer->firstname))
        {{ $sale->customer->fullname }}<br />
        @endif
        {{ $sale->organization->address }} </br>
        {{ $sale->organization->city }}, {{ $sale->organization->state }} {{ $sale->organization->zip }}
      @else
        {{ $sale->customer->fullname }}<br />
        {{ $sale->customer->address }} <br />
        {{ $sale->customer->city }}, {{ $sale->customer->state }} {{ $sale->customer->zip }}
      @endif
    </h4>
  </div>

  <table class="ui very basic compact unstackable table">
    <thead>
      <tr>
        <th>Date and Time</th>
        <th>Event</th>
        <th>Ticket Type</th>
        <th>Price</th>
        <th>Quantity</th>
        <th></th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      @foreach($sale->events as $event)
        @if ($event->id != 1)
          @foreach($sale->tickets->unique('ticket_type_id') as $ticket)
              <tr>
                <td>
                  <h4 class="ui header">
                    {{ Date::parse($event->start)->format('l, F j, Y \a\t g:i A') }}
                  </h4>
                </td>
                <td>
                  <h4 class="ui header">
                    <div class="content">
                      {{ $event->show->name }}
                    </div>
                  </h4>
                </td>
                <td>{{ $ticket->type->name }}</td>
                <td>$ {{ number_format($ticket->type->price, 2) }}</td>
                <td>{{ $sale->tickets->where('event_id', $event->id)->where('ticket_type_id', $ticket->type->id)->count() }}</td>
                <td class="right aligned">$</td>
                <td class="right aligned">{{ number_format($ticket->type->price * $sale->tickets->where('event_id', $event->id)->where('ticket_type_id', $ticket->type->id)->count(), 2) }}</td>
              </tr>
          @endforeach
        @endif
      @endforeach
      @foreach($sale->products->unique('id') as $product)
        <tr>
          <td>
            <h4 class="ui header"></h4>
          </td>
          <td>
            <h4 class="ui header">
              <div class="content">{{ $product->name }}</div>
            </h4>
          </td>
          <td>{{ $product->type->name }}</td>
          <td>${{ number_format($product->price, 2, '.', ',') }}</td>
          <td>{{ $sale->products->where('id', $product->id)->count() }}</td>
          <td class="right aligned">$</td>
          <td class="right aligned">{{ number_format($product->price * $sale->products->where('id', $product->id)->count(), 2, '.' , ',') }}</td>
        </tr>
      @endforeach
      <tr>
        <td colspan="4" style="border-top: 0"></td>
        <td class="right aligned"><strong>Subtotal</strong></td>
        <td class="right aligned">$</td>
        <td class="right aligned">{{ number_format($sale->subtotal, 2) }}</td>
      </tr>
      <tr>
        <td colspan="4" style="border-top: 0"></td>
        <td class="right aligned"><strong>Tax</strong></td>
        <td class="right aligned">$</td>
        <td class="right aligned">{{ number_format($sale->tax, 2) }}</td>
      </tr>
      <tr>
        <td colspan="4" style="border-top: 0"></td>
        <td class="right aligned"><strong>Total</strong></td>
        <td class="right aligned">$</td>
        <td class="right aligned">{{ number_format($sale->total, 2) }}</td>
      </tr>
      @if ($sale->payments->count() < 2)
      <tr>
        <td colspan="4" style="border-top: 0"></td>
        <td class="right aligned"><strong>Amount Paid</strong></td>
        <td class="right aligned">$</td>
        <td class="right aligned">{{ number_format($sale->payments->sum('tendered'), 2) }}
      </td>
      @else
      @foreach ($sale->payments as $payment)
      <tr>
        <td colspan="4" style="border-top: 0"></td>
        <td class="right aligned"><strong>Payment ({{ Date::parse($payment->created_at)->format('m/d/Y') }}) {{ $payment->method->name }}</strong></td>
        <td class="right aligned">$</td>
        <td class="right aligned">{{ number_format($payment->tendered, 2) }}</td>
      </tr>
      @endforeach
      @endif
      @if ($sale->refund)
      <tr>
        <td colspan="4" style="border-top: 0"></td>
        <td class="right aligned"><strong>Refund</strong></td>
        <td class="right aligned">$</td>
        <td class="right aligned" style="color:#cf3534"><strong>({{ number_format($sale->total, 2) }})</strong></td>
      </tr>
      @endif
      <tr>
        <td colspan="4" style="border-top: 0"></td>
        <td class="right aligned"><strong>Change</strong></td>
        <td class="right aligned">$</td>
        <td class="right aligned">{{ number_format($sale->payments->sum('change_due'), 2) }}</td>
      </tr>
      <tr>
        <td colspan="4" style="border-top: 0"></td>
        <td class="right aligned"><strong>Balance</strong></td>
        <td class="right aligned"><strong>$</strong></td>
        <td class="right aligned"><strong>{{ number_format($sale->total - ($sale->payments->sum('tendered') - $sale->payments->sum('change_due')), 2) }}</strong></td>
      </tr>
    </tbody>
  </table>

  <p>
    Thank you very much for choosing us. We sincerely appreciate your patronage and hope you enjoyed your shows.
  </p>

  <p>Sincerely,</p>

  <p>Visitor Services <br /> {{ App\Setting::find(1)->organization }}</p>

  <h4 class="ui center aligned header">
    <div class="content">
      {{ App\Setting::find(1)->organization }} <br /> {{ App\Setting::find(1)->address }}
      <div class="sub header">
        <i class="phone icon"></i>{{ App\Setting::find(1)->phone }} |
        <i class="at icon"></i>{{ App\Setting::find(1)->email }} |
        <i class="globe icon"></i><a href="http://{{ App\Setting::find(1)->website }}" target="_blank">{{ App\Setting::find(1)->website }}</a> | <i class="sun icon"></i>Astral
      </div>
    </div>
  </h4>

@endsection
