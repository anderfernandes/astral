<div id="ticket" style="height:20vh !important">

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
