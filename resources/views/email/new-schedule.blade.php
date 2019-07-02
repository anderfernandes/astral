@extends('layout.email-semantic')

@section('content')

<p>Dear {{ $user->firstname }},</p>

<br>

@if (isset($schedule->memo))
  <p>{{ $schedule->memo }}</p>
@else
  <p>A new work schedule has been posted:</p>
@endif

<p>Note: This schedule is not final, as it may change to accommodate new, updated or canceled events.</p>

<br>

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
  </div>
  @endforeach
</div>

<p>
  {{ auth()->user()->fullname }}     <br />
  {{ auth()->user()->role->name }}   <br />
  {{ auth()->user()->organization }} <br />
</p>
<p></p>

@endsection
