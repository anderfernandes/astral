<?php
  $ticket_width = \App\Setting::find(1)->ticket_width;
  $ticket_height = \App\Setting::find(1)->ticket_height;
?>
<div id="ticket" style="width:{{ $ticket_width }}in !important; height:{{ $ticket_height }} in !important">

  <p>
    # {{ $ticket->id }} | Sale # {{ $ticket->sale->id }} |
    {{ $ticket->type->name }} | $ {{ number_format($ticket->type->price, 2, '.', ',') }} </p>

  <h3>{{ $ticket->event->show->name }} | {{ $ticket->event->show->type }}</h3>

  <p>{{ $ticket->event->start->format('l, F j, Y \a\t g:i A') }}</p>

  <p>
    {{ $organization->address }} <br />
    {{ $organization->phone }} | {{ $organization->website }} | Astral
  </p>

  <div style="border-style:dashed"></div>

</div>
