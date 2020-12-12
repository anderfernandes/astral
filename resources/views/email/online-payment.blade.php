@component('vendor.mail.markdown.message')
  <p style="text-align:center">
    <img src="{{ asset(\App\Setting::find(1)->logo) }}" width="36" height="48" align="center" style="margin-bottom:12px" />
  </p>
  <h1 style="text-align:center">Proof of Online Purchase</h1>
  <h2 style="text-align:center">{{ \App\Setting::find(1)->organization }}</h2>

  Dear {{ $sale->customer->firstname }},

  Thank you for buying tickets to the {{ \App\Setting::find(1)->organization }}! Here you go:

  <p style="text-align:center">
  <?php 

    $generator = new Picqer\Barcode\BarcodeGeneratorSVG();
    echo $generator->getBarcode($sale->id, $generator::TYPE_UPC_A);

  ?>
  </center>
  </p>

@foreach ($sale->events as $event)
  @component('mail::panel')
  <strong>{{ $event->show->name }} ({{ $event->type->name }}, {{ $event->show->type }})</strong><br>
  <em>{{ $event->start->format('l, F j, Y \@ g:i A') }} ({{ $event->start->diffForHumans() }})</em>
  @component('mail::table')
  | Ticket Type               | Quantity                    | Price                       |
  |:--------------------------|:---------------------------:|----------------------------:|
  @foreach($event->tickets->where('sale_id', $sale->id)->unique('ticket_type_id') as $ticket)
  | {{ $ticket->type->name }} | {{ $event->tickets->where('sale_id', $sale->id)->where('ticket_type_id', $ticket->type->id)->count() }} |$ {{ number_format($ticket->type->price, 2)  }}|
  @endforeach
  @endcomponent
  @endcomponent
@endforeach

  Attached to this email you will also find your receipt and a printable version of your tickets. 
  Show this to our ticket desk staff and you will be good to go. Enjoy and don't forget to visit
  us again soon! 
  
  PS: <strong>Don't forget to ask our staff about memberships</strong>. You could save big on tickets!

  We are looking forward to have you and your family. Have a great day!<br>

  Regards,

  {{ \App\Setting::find(1)->organization }}
@endcomponent
