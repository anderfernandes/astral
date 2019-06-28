@extends('layout.admin')

@section('title', 'Shifts')

@section ('subtitle', 'Employee Scheduling')

@section ('icon', 'clock outline')

@section('content')

  <div class="ui text container">

    <a class="ui black button" href="{{ route('admin.shifts.create') }}">
      <i class="pencil icon"></i>
      Create New Shift
    </a>

    <div class="ui right floated labeled icon blue button" onclick="$('#mail').modal('toggle')">
      <i class="mail icon"></i>
      Email
    </div>

    <div class="ui basic modal" id="mail">
      <div class="ui icon header">
        <i class="clock icon"></i>
        Select shifts
      </div>
      <div class="content">
        <p>Select the shifts to be emailed:</p>
        <form action="{{ route('admin.shifts.overview') }}"  
              method="post"
              class="ui form">
          {{ csrf_field() }}
          <div class="ui multiple fluid selection dropdown">
            <input type="hidden" name="shifts">
            <i class="dropdown icon"></i>
            <div class="default text">Select the shifts to be email</div>
            <div class="menu">
              @foreach ($shifts as $shift)
              <div class="item" data-value="{{ $shift->id }}">Shift #{{ $shift->id }}</div>
              @endforeach
            </div>
          </div>    
        </form>
      </div>
      <div class="actions">
        <div class="ui red basic cancel inverted button">
          <i class="remove icon"></i>
          Cancel
        </div>
        <div class="ui green ok positive inverted button" onclick="$('form').submit()">
          <i class="checkmark icon"></i>
          OK
        </div>
      </div>
    </div>

    @if ($shifts->count() > 0)
    
      @foreach ($shifts as $shift)
      <div class="ui inverted segment">
          
        <div class="ui top left attached black label">
          <div class="detail">Shift #{{ $shift->id }}</div>
          &nbsp;
          <i class="clock icon"></i> 
          {{ $shift->start->format('l, F j, Y') }} |
          {{ $shift->start->format('h:i A') }} - {{ $shift->end->format('h:i A') }} |
          {{ $shift->events->count() }} {{ $shift->events->count() == 1 ? "event" : "events" }}
        </div>
        <div class="ui top right attached black label">
          <a href="{{ route('admin.shifts.show', $shift) }}">
            <i class="eye icon"></i>
          </a>
          <a href="{{ route('admin.shifts.edit', $shift) }}">
            <i class="edit icon"></i>
          </a>
          <a href="#">
            <i class="trash icon"></i>
          </a>
        </div>
        <br>
        @foreach($shift->employees as $employee)
        <div class="ui label" style="background-color:white">
          <i class="user circle icon"></i>{{ $employee->firstname }}
          <div class="detail">{{ $shift->positions[$loop->index]->name }}</div>
        </div>
        @endforeach
      </div>
      @endforeach
    
    @else

    <div class="ui icon message">
      <i class="info circle icon"></i>
      <div class="content">
        <div class="header">No shifts</div>
        <p>No shifts to display</p>
      </div>
    </div>

    @endif

  </div>

@endsection
