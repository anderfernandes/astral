@extends('layout.admin')

@section('title', 'Shifts')

@section ('subtitle', 'Employee Scheduling')

@section ('icon', 'clock outline')

@section('content')

  <div class="ui container">

    <a class="ui black button" href="{{ route('admin.shifts.create') }}">
      <i class="pencil icon"></i>
      Create New Shift
    </a>

    @if ($shifts->count() > 0)
    <div class="ui black button" onclick="$('#schedule').modal('toggle')">
      <i class="pencil icon"></i>
      Create New Schedule
    </div>
    @endif

    <!--- Modal --->
    <div class="ui basic modal" id="schedule">
      <div class="ui icon header">
        <i class="clock icon"></i>
        Select shifts
      </div>
      <div class="content">
        <p>Select the shifts to be added to a schedule:</p>
        <form action="{{ route('admin.schedules.store') }}"  
              method="post"
              class="ui form">
          {{ csrf_field() }}
          <div class="ui multiple fluid selection dropdown">
            <input type="hidden" name="shifts">
            <i class="dropdown icon"></i>
            <div class="default text">Select the shifts to be added to a schedule</div>
            <div class="menu">
              @foreach ($shifts as $shift)
              <div class="item" data-value="{{ $shift->id }}">
                Shift #{{ $shift->id }} - {{ $shift->start->format('l, F j, Y') }} ({{ $shift->start->format('g:i A') }} - {{ $shift->end->format('g:i A') }})
              </div>
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

    <div class="ui top attached tabular menu">
      <a class="active item" data-tab="shifts">Shifts</a>
      <a class="item" data-tab="schedules">Schedules</a>
    </div>

    <!-- Shifts --->
    <div class="ui bottom attached active tab segment" data-tab="shifts">
      @if ($shifts->count() > 0)
    
        @foreach ($shifts as $shift)
        <div class="ui segment">
          <div class="ui items">
            <div class="item">
              <div class="content">
                <div class="header">Shift #{{ $shift->id }}</div>
                <div class="meta">
                  <i class="calendar alternate outline icon"></i>
                  {{ $shift->start->format('l, F j, Y') }} |
                  {{ $shift->start->format('g:i A') }} - {{ $shift->end->format('g:i A') }} |
                  {{ $shift->events->count() }} {{ $shift->events->count() == 1 ? "event" : "events" }}
                </div>
                <div class="description">
                  @foreach($shift->employees as $employee)
                  <div class="ui black label">
                    <i class="user circle icon"></i>{{ $employee->firstname }}
                    <div class="detail">{{ $shift->positions[$loop->index]->name }}</div>
                  </div>
                  @endforeach
                </div>
                <div class="extra">
                  <a class="ui right floated red labeled icon button" href="#">
                    <i class="trash icon"></i> Delete
                  </a>
                  <a class="ui right floated yellow labeled icon button" href="{{ route('admin.shifts.edit', $shift) }}">
                    <i class="edit icon"></i> Edit
                  </a>
                  <a class="ui right floated blue labeled icon button" href="{{ route('admin.shifts.show', $shift) }}">
                    <i class="eye icon"></i> Details
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      
      @else

      <div class="ui icon message">
        <i class="info circle icon"></i>
        <div class="content">
          <div class="header">No shifts</div>
          <p>No future shifts to display.</p>
        </div>
      </div>

      @endif
    </div>
    
    <!--- Schedules --->
    <div class="ui bottom attached tab segment" data-tab="schedules">
      
      @if ($schedules->count() > 0)

      @foreach ($schedules as $schedule)
        <div class="ui segment">
          <div class="ui items">
            <div class="item">
              <div class="content">
              <a href="{{ route('admin.schedules.show', $schedule) }}" class="header">Schedule #{{ $schedule->id }}</a>
                <div class="meta">
                  <i class="user circle icon"></i> {{ $schedule->creator->firstname }} |
                  <i class="pencil icon"></i> {{ $schedule->created_at->format('l, F j, Y \a\t g:i A') }}
                  @if (isset($schedule->updated_at) && $schedule->updated_at != $schedule->created_at )
                  <i class="edit icon"></i> {{ $schedule->updated_at->format('l, F j, Y \a\t g:i A') }}
                  @endif
                  | <i class="clock icon"></i> {{ $schedule->shifts->count() }} |
                  <i class="envelope icon"></i> {{ $schedule->emailed }}
                </div>
                <div class="description">
                  @foreach($schedule->shifts as $shift)
                  <a href="{{ route('admin.shifts.show', $shift) }}" class="ui black label">
                    <i class="clock icon"></i>Shift #{{ $shift->id }}
                    <div class="detail">
                      {{ $shift->start->format('l, F j, Y') }} 
                      ({{ $shift->start->format('g:i A') }} - {{ $shift->end->format('g:i A') }})
                    </div>
                  </a>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>
        @endforeach

      @else

      <div class="ui icon message">
        <i class="info circle icon"></i>
        <div class="content">
          <div class="header">No schedules</div>
          <p>No future schedules to display.</p>
        </div>
      </div>
      
      @endif
    </div>

  </div>

  <script>
    $(document).ready(function() {
      $('.ui.fluid.dropdown').dropdown({ useLabels : false })
      $('.menu .item').tab({ history: true });
    })
  </script>

@endsection
