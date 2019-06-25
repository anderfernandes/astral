@extends('layout.email')

@section('content')

<p>Dear {{ $user->firstname }},</p>

<br>

<p>You have been added to the shift described in the table below.</p>

<br>

<h4>
  Shift #{{ $shift->id }}
  <br>
  {{ $shift->start->format('l, F j, Y') }} |
  {{ $shift->start->format('h:i A') }} - {{ $shift->end->format('h:i A') }}
</h4>

<br>

<table class="ui single line striped table">
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
    <tr style="font-weight: bold !; text-align:left !important">
    @else
    <tr style="text-align:left !important">
    @endif
      <td>{{ $employee->firstname }}</td>
      <td>{{ $shift->positions[$loop->index]->name }}</td>
      <td>{{ $shift->start->format('h:i A') }}</td>
      <td>{{ $shift->end->format('h:i A') }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection
