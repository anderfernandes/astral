@extends('layout.email')

@section('content')

<style>
  table, th, td { border: 1px solid; }
</style>

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

<br>

<p>Note: This schedule is not final, as it may change to accommodate new, updated or canceled events.</p>

<br>

<table style="border: 1px solid">
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
        <th>Employee</th>
        <th>Time</th>
      @endforeach
    </tr>
  </thead>
  <tbody>
    <tr>
      @foreach ($schedule->shifts as $shift)
      <td colspan="2">
        <table style="border: 0">
          @foreach ($shift->employees as $employee)
          <tr>
            <td style="border: 0; text-align: center">
              {{ $employee->firstname }} <br>
              {{ $shift->positions[$loop->index]->name }}
            </td>
            <td style="border: 0; text-align: center">
              {{ $shift->start->format('g:i A') }} - {{ $shift->end->format('g:i A') }}
            </td>
          </tr>
          @endforeach
        </table>
      </td>
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
      <td colspan="2" style="text-align:center">
        @foreach ($shift->events as $event)
      <p>#{{ $event->id }} - {{ $event->show->name }}, {{ $event->start->format('g:i A') }}</p>
        @endforeach
      </td>
      @endforeach
    </tr>
  </tbody>
</table>

<br><br>

<p>
  {{ auth()->user()->fullname }}     <br />
  {{ auth()->user()->role->name }}   <br />
  {{ auth()->user()->organization->name }} <br />
</p>
<p></p>

@endsection
