@extends('layout.pdf')

@section('title', "Astral - " . App\Setting::find(1)->organization . " - Confirmation #$sale->id")

@section('content')

  <center>
    <img src="{{ (App\Setting::find(1)->logo == '/logo.png') ? substr(App\Setting::find(1)->logo, 1) : substr(Storage::url(App\Setting::find(1)->logo), 1) }}" style="width:35px; height:auto">
    <h3>Reservation Confirmation</h3>
  </center>

  <div class="ui clearing basic segment" style="padding:0 0 0 0">

    <h4 class="ui left floated header" style="text-align:left">
      Date: {{ Date::now()->format('l, F j, Y') }}
    </h4>

    <h4 class="ui right floated header" style="text-align:right">
      Sale # {{ $sale->id }}
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
        {{ $sale->organization->name }}<br />
        {{ $sale->customer->address }} <br />
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
                      {{ $event->show_id == 1 ? $event->memo : $event->show->name }}
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
    Please visit our <a href="{{ App\Setting::find(1)->website }}" target="_blank">website</a> for directions, parking and other valuable info. We sincerely hope you enjoy your visit. Do not hesitate
    to call or email us with any questions regarding your visit. Thank you a have a great day.
  </p>

  <p>Sincerely,</p>

  <p>Visitor Services <br /> {{ App\Setting::find(1)->organization }}</p>

  <h4 class="ui center aligned header">
    <div class="content">
      <center>{{ App\Setting::find(1)->organization }} <br /> {{ App\Setting::find(1)->address }}</center>

      <div class="sub header">
        <center>
          {{ App\Setting::find(1)->phone }} |
          {{ App\Setting::find(1)->email }} |
          <a href="http://{{ App\Setting::find(1)->website }}" target="_blank">{{ App\Setting::find(1)->website }}</a> |
          <img src="astral-logo-dark.png" style="width:10px"> Astral
        </center>
      </div>
    </div>
  </h4>

@endsection
