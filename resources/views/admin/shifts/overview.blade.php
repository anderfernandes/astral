@extends('layout.admin')

@section('title', 'Shifts')

@section ('subtitle', 'Employee Scheduling')

@section ('icon', 'clock outline')

@section('content')

  <div class="ui container">

    @foreach ($shifts as $shift)
    
    <div class="ui dividing header">
      <i class="clock alternate icon"></i>
      <div class="content">
        Shift #{{ $shift->id }}
        <div class="sub header">
          {{ $shift->start->format('l, F j, Y') }} |
          {{ $shift->start->format('h:i A') }} - {{ $shift->end->format('h:i A') }}
          ({{ $shift->start->diffForHumans() }})
        </div>
        <div class="sub header">
          <i class="user circle icon"></i> {{ $shift->creator->firstname }} |
          <i class="pencil icon"></i> {{ $shift->created_at->format('l, F j, Y \a\t g:i A') }} 
          ({{ $shift->created_at->diffForHumans() }})
          @if (isset($shift->updated_at) && ($shift->created_at != $shift->updated_at))
            | 
            <i class="edit icon"></i> {{ $shift->updated_at->format('l, F j, Y \a\t g:i A') }} 
            ({{ $shift->created_at->diffForHumans() }})
          @endisset
        </div>
      </div>
    </div>
    <table class="ui celled table">
      <thead>
        <tr>
          <th>Employee</th>
          <th>Position</th>
          <th>Start Time</th>
          <th>End Time</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($shift->employees as $employee)
        <tr>
          <td data-label="employee">{{ $employee->firstname }}</td>
          <td data-label="position">{{ $shift->positions[$loop->index]->name }}</td>
          <td data-label="start">{{ $shift->start->format('g:i A') }}</td>
          <td data-label="end">{{ $shift->end->format('g:i A') }}</td>
        </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <th colspan="3" class="right aligned">
              <strong>Total :</strong>
          </th>
          <th><strong>{{ $shift->end->diffAsCarbonInterval($shift->start)->forHumans() }}</strong></th>
        </tr>
      </tfoot>
    </table>
    @endforeach
    
    <div class="ui positive labeled icon button">
      <i class="mail icon"></i>
      Email Schedule
    </div>

  </div>

@endsection