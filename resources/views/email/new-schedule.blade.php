@extends('layout.email')

@section('content')

<h4 class="ui header">
  {{ now()->format('l, F j, Y') }}
</h4>

<p>Dear {{ $user->firstname }},</p>

<br>

@if (isset($schedule->memo))
  <p>{{ $schedule->memo }}</p>
@else
  <p>A new work schedule has been posted:</p>
@endif

<p>Note: This schedule is not final, as it may change to accommodate new, updated or canceled events.</p>

<br>

<div class="ui very basic compact unstackable table">
  <thead>
    <tr>
      <th colspan="{{ $schedule->shifts->count() * 2 }}">
        Schedule #{{ $schedule->id }} | Created by {{ $schedule->creator->firstname }}
      </th>
    </tr>
    <tr>
      @foreach ($schedule->shifts as $shift)
        <th colspan="2">{{ $shift->start->format('l, F j') }}</th>
      @endforeach
    </tr>
    <tr>
      @foreach ($schedule->shifts as $shift)
        <th colspan="2"></th>
      @endforeach
    </tr>
    <tr>
      @foreach ($schedule->shifts as $shift)
        <th>Employee</th>
        <th>Time</th>
      @endforeach
    </tr>
  </thead>
  <tbody>
    <tr>
      @foreach($schedule->shifts as $shift)
        @foreach ($shift->employees as $employee)
        <th style="text-align: center">
          {{ $employee->firstname }} <br>
          {{ $shift->positions[$loop->index]->name }}
        </th>
        <th>
          {{ $shift->start->format('g:i A') }} - {{ $shift->end->format('g:i A') }}
        </th>
        @endforeach
      @endforeach
    </tr>
    <tr>
      @foreach ($schedule->shifts as $shift)
        @if ($shift->events->count() > 0)
        <th colspan="2">Events</th>
        @endif
      @endforeach
    </tr>
    <tr>
      @foreach ($schedule->shifts as $shift)
        @if ($shift->events->count() > 0)
        <th colspan="2">
          {{ $event->start->format('g:i A') }} | {{ $event->type->name }} <br>
          {{ $event->tickets->count() }} 
          {{ $event->tickets->count() == 1 ? "seat" : "seats" }} reserved |
          {{ $event->sales->count() }} {{ $event->sales->count() == 1 ? "sale" : "sales" }}
        </th>
        @endif
      @endforeach
    </tr>
  </tbody>
</div>

<p>
  {{ auth()->user()->fullname }}     <br />
  {{ auth()->user()->role->name }}   <br />
  {{ auth()->user()->organization->name }} <br />
</p>
<p></p>

@endsection
