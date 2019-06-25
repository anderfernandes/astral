@extends('layout.email')

@section('content')

<p>Dear {{ $user->firstname }},</p>

<p>
  Shift {{ $shift->id }} has been <strong>updated</strong> an you have been added to it. 
  The shift is described in the table below.
</p>

<div class="ui dividing header">
  Shift #{{ $shift->id }}
  <div class="sub header">
    {{ $shift->start->format('l, F j, Y') }} |
    {{ $shift->start->format('h:i A') }} - {{ $shift->end->format('h:i A') }}
  </div>
</div>

<table class="ui single line struped table">
  <thead>
    <tr class="right aligned" style="text-align:right !important">
      <th>Employee</th>
      <th>Position</th>
      <th>From</th>
      <th>To</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($shift->employees as $employee)
    @if ($employee->id == $user->id) 
    <tr style="font-weight: bold !important">
    @else
    <tr>
    @endif
      <td>{{ $employee->name }}</td>
      <td>{{ $shift->positions[$loop->index]->name }}</td>
      <td>{{ $shift->start->format('h:i A') }}</td>
      <td>{{ $shift->end->format('h:i A') }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection
