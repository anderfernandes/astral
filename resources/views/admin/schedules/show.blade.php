@extends('layout.admin')

@section('title', 'Shifts')

@section ('subtitle', 'Employee Scheduling')

@section ('icon', 'clock outline')

@section('content')

  <div class="ui container">

    <div class="ui dividing header">
      <i class="clock icon"></i>
      <div class="content">
        Schedule #{{ $schedule->id }}
        <div class="sub header">
          <i class="user circle icon"></i> {{ $schedule->creator->firstname }} |
          <i class="pencil icon"></i> {{ $schedule->created_at->format('l, F j, Y \a\t g:i A') }}
          @if (isset($schedule->updated_at) && $schedule->updated_at != $schedule->created_at )
          | <i class="edit icon"></i> {{ $schedule->updated_at->format('l, F j, Y \a\t g:i A') }}
          @endif
          | {{ $schedule->shifts->count() }} 
          {{ $schedule->shifts->count() == 1 ? "shift" : "shifts" }} 
        </div>
      </div>
    </div>

    <a href="{{ route('admin.shifts.index') }}#/schedules" class="ui basic black button">
      <i class="left chevron icon"></i>
      Back
    </a>

    <div class="ui yellow labeled icon button" onclick="$('#schedule').modal('toggle')">
      <i class="edit icon"></i>
      Edit
    </div>

    <a href="{{ route('admin.schedules.mail', $schedule) }}" class="ui positive labeled icon button">
      <i class="mail icon"></i>
      Email
    </a>

    <br><br>

    <div class="ui three raised doubling link cards">
      @foreach ($schedule->shifts as $shift)
      <div class="card">
        <div class="content">
          <a href="{{ route('admin.shifts.show', $shift) }}" class="header">
            #{{ $shift->id }} - {{ $shift->start->format('l, F j, Y') }}
          </a>
          <div class="meta">
            <i class="clock icon"></i>
            {{ $shift->start->format('g:i A') }} - {{ $shift->end->format('g:i A') }}
            ({{ $shift->end->diffInMinutes($shift->start) / 60 }} hours)
          </div>
          <div class="description">
            <div class="ui sub header">Staff</div>
            @foreach ($shift->employees as $employee) 
            <div class="ui fluid black label" style="margin-bottom:0.5rem">
              <i class="user circle icon"></i>
              {{ $employee->firstname }}
              <div class="detail">{{ $shift->positions[$loop->index]->name }}</div>
            </div>
            @endforeach
            <div class="ui comments">
              <div class="ui sub header">Events</div>
              @foreach ($shift->events as $event)
                <div class="comment">
                  
                  <div class="content">
                    <div class="author">
                      {{ $event->show->name }}
                      <div class="ui tiny black basic label">{{ $event->show->type }}</div>
                    </div>
                    <div class="metadata">
                      <span class="date">
                        {{ $event->start->format('g:i A') }} | 
                        {{ $event->type->name }} |
                        {{ $event->tickets->count() }} 
                        {{ $event->tickets->count() == 1 ? "seat" : "seats" }} reserved |
                        {{ $event->sales->count() }} {{ $event->sales->count() == 1 ? "sale" : "sales" }}
                      </span>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        </div>
        <div class="extra content">
        <a href="{{ route('admin.shifts.edit', $shift) }}" class="ui yellow fluid button">
            <i class="edit icon"></i> Edit
          </a>
        </div>
      </div>
      @endforeach
    </div>

    <!-- Memo -->
    <div class="ui comments">
      <h3 class="ui dividing header">Memo</h3>
      <div class="comment">
        <div class="avatar">
          <i class="big user circle icon"></i>
        </div>
        <div class="content">
          <div class="author">
            {{ $schedule->creator->firstname }} 
            <div class="ui black label">{{ $schedule->creator->role->name }}</div>
            <div class="metadata">
              <span class="date">{{ $schedule->created_at->format('l, F j, Y \a\t g:i A') }}</span>
            </div>
          </div>
          
          <div class="text">
            {{ $schedule->memo }}
          </div>
        </div>
      </div>
    </div>

    <div class="ui basic modal" id="schedule">
      <div class="ui icon header">
        <i class="edit icon"></i>
        Edit Schedule
      </div>
      <div class="content">
        <p>Select the shifts to be added to a schedule:</p>
        <form action="{{ route('admin.schedules.update', $schedule) }}"  
              method="post"
              class="ui form">
          {{ method_field('PUT') }}
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
          <br>
          <div class="field">
            <label style="color: white">Memo</label>
            <textarea name="memo" placeholder="Write any important information about the shift. This message will go along the schedule when emailed">{{ $schedule->memo }}</textarea>
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

  </div>

  <script>

  @isset($shift)
    $(document).ready(function() {
      $('.ui.fluid.dropdown')
      .dropdown({ useLabels : false })
      .dropdown('set exactly', {!! $schedule->shifts->pluck('id')->map(function($id) { return (string)$id; }) !!})
      
    })
  
  @endif

  </script>

@endsection