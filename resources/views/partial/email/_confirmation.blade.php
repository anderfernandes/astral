<center>
  <img src="http://www.starsatnight.org/sciencetheater/includes/themes/MuraBootstrap3/images/logo-new.png" alt="" class="ui centered mini image">
  <h2>Reservation Confirmation</h2>
</center>

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
    <tr class="right aligned" style="text-align:right !important">
      <th>Date and Time</th>
      <th>Show</th>
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
                <strong>
                  {{ Date::parse($event->start)->format('l, F j, Y \a\t g:i A') }}
                </strong>
              </td>
              <td>
                <strong>
                  {{ $event->show->name }}
                </strong>
              </td>
              <td>{{ $ticket->type->name }}</td>
              <td>$ {{ number_format($ticket->type->price, 2) }}</td>
              <td>{{ $sale->tickets->where('event_id', $event->id)->where('ticket_type_id', $ticket->type->id)->count() }}</td>
              <td>$ {{ number_format($ticket->type->price * $sale->tickets->where('event_id', $event->id)->where('ticket_type_id', $ticket->type->id)->count(), 2) }}</td>
            </tr>
        @endforeach
      @endif
    @endforeach
    @foreach($sale->products->unique('id') as $product)
      <tr class="right aligned">
        <td>
          <h4 class="ui header"></h4>
        </td>
        <td>
          <h4 class="ui header">
            <div class="content">{{ $product->name }}</div>
          </h4>
        </td>
        <td>{{ $product->type->name }}</td>
        <td>${{ number_format($product->price, 2, '.', '') }}</td>
        <td>{{ $sale->products->where('id', $product->id)->count() }}</td>
        <td>$ {{ number_format($product->price * $sale->products->where('id', $product->id)->count(), 2, '.' , ',') }}</td>
      </tr>
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
              <td><strong>Subtotal</strong></td>
            </tr>
            <tr>
              <td><strong>Tax</strong></td>
            </tr>
            <tr>
              <td><strong>Total</strong></td>
            </tr>
            <tr>
              <td><strong>Amount Paid</strong></td>
            </tr>
            <tr>
              <td><strong>Change</strong></td>
            </tr>
            <tr>
              <td><strong>Balance</strong></td>
            </tr>
          </tbody>
        </table>
      </td>
      <td class="right aligned">
        <table style="width:100%">
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

<br>

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

@if ($sale->tickets->count() != 0)
<ul>
  <li>
    We reserved {{ $numberOfEvents == 1 ? $sale->tickets->count() : $sale->tickets->count() / $numberOfEvents }} seats per show for you. If more than {{ $numberOfEvents == 1 ? $sale->tickets->count() : $sale->tickets->count() / $numberOfEvents }} people show up,
    we admit them space available (up to our capacity of {{ App\Setting::find(1)->seats }}) for the same price you paid. You may
    choose, include them in your payment or they may buy their own tickets at show time.
  </li>
</ul>
@endif

<br>

<p>
  Please visit our website for directions, parking and other valuable info. We sincerely hope you enjoy your visit. Do not hesitate
  to call or email us with any questions regarding your visit. Thank you a have a great day.
</p>

<p>Sincerely,</p>

<p>Visitor Services <br /> {{ App\Setting::find(1)->organization }}</p>

<h4 class="ui center aligned header" style="text-align: center">
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
