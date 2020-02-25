@component('vendor.mail.markdown.message')
  <p style="text-align:center">
    <img src="{{ asset(\App\Setting::find(1)->logo) }}" width="36" height="48" align="center" style="margin-bottom:12px" />
  </p>
  <h1 style="text-align:center">Confirm Your Reservation</h1>
  <h2 style="text-align:center">{{ \App\Setting::find(1)->organization }}</h2>

  Dear {{ $sale->customer->firstname }},

  According to our records, you have an **unconfirmed {{ $sale->events->first()->type->name }} reservation**
  @if($sale->organization->id !== 1) with **{{ $sale->organization->name }}** @endif in our system 
  you scheduled with us for the following {{ $sale->events->count() == 1 ? 'date' : 'dates' }}
  and {{ $sale->events->count() == 1 ? 'time' : 'times' }}:

  <ul>
  @foreach ($sale->events as $event)
  <li>{{ $event->start->format('l, F j, Y \@ g:i A') }}, {{ $event->show->name }} ({{ $event->show->type }})</li>
  @endforeach
  </ul>

  Please click the button below to look at all the information we have and confirm it.

  @component('mail::button', ['url' => route('sale', $sale) . '?source=' . Hash::make($sale->customer->email)])
  Review Reservation
  @endcomponent

  We are looking forward to have you and your group. Have a great day!<br>

  Regards,

  {{ \App\Setting::find(1)->organization }}
@endcomponent
