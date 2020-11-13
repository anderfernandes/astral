@component('vendor.mail.markdown.message')
  <p style="text-align:center">
    <img src="{{ asset(\App\Setting::find(1)->logo) }}" width="36" height="48" align="center" style="margin-bottom:12px" />
  </p>
  <h1 style="text-align:center">Proof of Purchase</h1>
  <h2 style="text-align:center">{{ \App\Setting::find(1)->organization }}</h2>

  Dear {{ $sale->customer->firstname }},

  Thank you for buying tickets to the {{ \App\Setting::find(1)->organization }}!
  
  Attached to this email you will find your receipt, and your tickets are right below. Show this to our 
  ticket desk staff and you will be good to go. Enjoy and please come back. <strong>Don't forget to ask 
  our staff about memberships</strong>. You could save big on tickets! Take care!

  <ul>
  @foreach ($sale->events as $event)
  <li>{{ $event->start->format('l, F j, Y \@ g:i A') }}, {{ $event->show->name }} ({{ $event->show->type }})</li>
  @endforeach
  </ul>

  We are looking forward to have you and your family. Have a great day!<br>

  Regards,

  {{ \App\Setting::find(1)->organization }}
@endcomponent
