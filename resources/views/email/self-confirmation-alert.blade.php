@component('mail::message')
<img src="{{ asset(\App\Setting::find(1)->logo) }}" style="margin-left:50%; height:48px; margin-bottom:12px" />
<h1 style="text-align:center">Confirm Your Reservation</h1>
<h2 style="text-align:center">{{ \App\Setting::find(1)->organization }}</h2>

Dear {{ $sale->customer->firstname }},

According to our records, you have an **unconfirmed** field trip 
@if($sale->organization->id !== 1) with **{{ $sale->organization->name }}** @endif in our system 
scheduled for the following {{ $sale->events->count() == 1 ? 'date' : 'dates' }}
and {{ $sale->events->count() == 1 ? 'time' : 'times' }}:

@foreach ($sale->events as $event)
- {{ $event->start->format('l, F j, Y \a\t g:i A') }}, {{ $event->show->name }} ({{ $event->show->type }})
@endforeach

Please click the button below to look at all the information we have and confirm it.

@component('mail::button', ['url' => route('sale', $sale) . '?source=' . Hash::make($sale->customer->email)])
Review Reservation
@endcomponent

We are looking forward to have you and your group,<br>
{{ \App\Setting::find(1)->organization }}
@endcomponent
