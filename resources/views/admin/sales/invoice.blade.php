@extends('layout.report')

<?php

$title = $sale->organization->name != $sale->customer->fullname ? $sale->organization->name . '\'s' : $sale->organization->name . '\'s ' . $sale->customer->fullname

?>

@section('title', $title . ' Invoice')

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

  <div class="ui icon right floated buttons">
    <div onclick="window.print()" class="ui primary button"><i class="print icon"></i></div>
    <div onclick="window.close()" class="ui secondary button"><i class="close icon"></i></div>
  </div>

  <img src="{{ asset(App\Setting::find(1)->logo) }}" alt="" class="ui centered mini image">

  <h2 class="ui center aligned icon header" style="margin-top:8px">
    <div class="content">Invoice # {{ $sale->id }}</div>
  </h2>

  <div class="ui clearing basic segment" style="padding:0 0 0 0">

    <h4 class="ui left floated header">
      Date: {{ Date::now()->format('l, F j, Y') }}
    </h4>

    <h4 class="ui right floated header">
      Terms: Due at showtime
    </h4>

  </div>

  <div class="ui clearing basic segment" style="padding:0 0 0 0">

    <h4 class="ui left floated header">
      Bill to: <br />
      {{ $sale->organization->name }}<br />
      {{ $sale->customer->fullname }}<br />
      {{ $sale->customer->address }} </br>
      {{ $sale->customer->city }}, {{ $sale->customer->state }} {{ $sale->customer->zip }}
    </h4>

    <h4 class="ui left floated header">
      Sold to:<br />
      {{ $sale->customer->fullname }}<br />
      {{ $sale->organization->name }}
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
                <td>$ {{ number_format($ticket->type->price * $sale->tickets->where('event_id', $event->id)->where('ticket_type_id', $ticket->type->id)->count(), 2) }}</td>
              </tr>
          @endforeach
        @endif
      @endforeach
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>
          <table class="ui very basic compact collapsing unstackable table" style="margin-left:auto; margin-right:0; width:auto">
            <tbody>
              <tr>
                <td class="right aligned"><strong>Subtotal</strong></td>
              </tr>
              <tr>
                <td class="right aligned"><strong>Tax</strong></td>
              </tr>
              <tr>
                <td class="right aligned"><strong>Total</strong></td>
              </tr>
              <tr>
                <td class="right aligned"><strong>Amount Paid</strong></td>
              </tr>
              <tr>
                <td class="right aligned"><strong>Change</strong></td>
              </tr>
              <tr>
                <td class="right aligned"><strong>Balance</strong></td>
              </tr>
            </tbody>
          </table>
        </td>
        <td>
          <table class="ui very basic compact unstackable table">
            <tbody>
              <tr>
                <td>{{ number_format($sale->subtotal, 2) }}</td>
              </tr>
              <tr>
                <td>$ {{ number_format($sale->tax, 2) }}</td>
              </tr>
              <tr>
                <td>$ {{ number_format($sale->total, 2) }}</td>
              </tr>
              <tr>
                <td style="color:#cf3534"><strong>-$ {{ number_format($sale->payments->sum('tendered'), 2) }}</strong></td>
              </tr>
              <tr>
                <td>$ {{ number_format($sale->payments->sum('change_due'), 2) }}</td>
              </tr>
              <tr>
                <td><strong>{{ '$ ' . number_format($sale->total - ($sale->payments->sum('tendered') - $sale->payments->sum('change_due')), 2) }}</strong></td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
      <tr>
        <td colspan="6" class="active right aligned">
          <strong>
            Please pay this amount:
            <span>
              {{ '$ ' . number_format($sale->total - ($sale->payments->sum('tendered') - $sale->payments->sum('change_due')), 2) }}
              &nbsp;
            </span>
          </strong>
        </td>
      </tr>
    </tbody>
  </table>



  {!! \Illuminate\Mail\Markdown::parse(App\Setting::find(1)->invoice_text) !!}

  <p>
    Thank you very much for choosing us. We sincerely appreciate your patronage and hope you enjoy our shows.
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
