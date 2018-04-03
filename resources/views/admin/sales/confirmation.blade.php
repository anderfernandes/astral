@extends('layout.report')

<?php

$title = $sale->organization->name != $sale->customer->fullname ? $sale->organization->name . '\'s' : $sale->organization->name . '\'s ' . $sale->customer->fullname

?>

@section('title', $title . ' Reservation Confirmation')

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
    <div class="content">Reservation Confirmation</div>
  </h2>

  <h4 class="ui header">
    {{ Date::now()->format('l, F j, Y') }}
  </h4>

  <div class="ui clearing basic segment" style="padding:0 0 0 0">
    <h4 class="ui right floated header">
      Sale # {{ $sale->id }}
    </h4>

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
        {{ $sale->customer->address }} </br>
        {{ $sale->customer->city }}, {{ $sale->customer->state }} {{ $sale->customer->zip }}
      @endif
    </h4>
  </div>

  <p>Dear {{ $sale->customer->fullname }},</p>

  <p>
    Welcome to the {{ App\Setting::find(1)->organization }}. We are pleased to confirm your reservation as follows:
  </p>

  <table class="ui very basic compact unstackable table">
    <thead>
      <tr class="right aligned">
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
              <tr class="right aligned">
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
      <tr class="right aligned">
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
              <tr class="right aligned">
                <td>{{ number_format($sale->subtotal, 2) }}</td>
              </tr>
              <tr class="right aligned">
                <td>$ {{ number_format($sale->tax, 2) }}</td>
              </tr>
              <tr class="right aligned">
                <td>$ {{ number_format($sale->total, 2) }}</td>
              </tr>
              <tr class="right aligned">
                <td style="color:#cf3534"><strong>-$ {{ number_format($sale->payments->sum('tendered'), 2) }}</strong></td>
              </tr>
              <tr class="right aligned">
                <td>$ {{ number_format($sale->payments->sum('change_due'), 2) }}</td>
              </tr>
              <tr class="right aligned">
                <td><strong>{{ '$ ' . number_format($sale->total - ($sale->payments->sum('tendered') - $sale->payments->sum('change_due')), 2) }}</strong></td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
    </tbody>
  </table>



  {!! \Illuminate\Mail\Markdown::parse(App\Setting::find(1)->confirmation_text) !!}

  <?php

    //$events = $sale->events->count();
    $numberOfEvents = 0;

    // Loop through all events
    foreach ($sale->events as $event) {
      // Add one to $numberOfEvents if eventis not "No Show"
      if ($event->id != '1') $numberOfEvents++;
    }

  ?>

  <ul>
    <li>
      We reserved {{ $numberOfEvents == 1 ? $sale->tickets->count() : $sale->tickets->count() / $numberOfEvents }} seats per show for you. If more than {{ $numberOfEvents == 1 ? $sale->tickets->count() : $sale->tickets->count() / $numberOfEvents }} people show up,
      we admit them space available (up to our capacity of {{ App\Setting::find(1)->seats }}) for the same price you paid. You may
      choose, include them in your payment or they may buy their own tickets at show time.
    </li>
  </ul>

  <p>
    Please visit our website for directions, parking and other valuable info. We sincerely hope you enjoy your visit. Do not hesitate
    to call or email us with any questions regarding your visit. Thank you a have a great day.
  </p>

  <p>Sincerely,</p>

  <p>Visitor Services <br /> {{ App\Setting::find(1)->organization }}</p>

  <h4 class="ui center aligned header">
    <div class="content">
      {{ App\Setting::find(1)->organization }} <br /> {{ App\Setting::find(1)->address }}
      <div class="sub header">
        {{ App\Setting::find(1)->phone }} |
        {{ App\Setting::find(1)->email }} |
        <a href="http://{{ App\Setting::find(1)->website }}" target="_blank">{{ App\Setting::find(1)->website }}</a> |
        <a href="http://astral.anderfernandes.com">Astral</a>
      </div>
    </div>
  </h4>

@endsection
