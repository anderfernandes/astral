@extends('layout.admin')

@section('title', 'Shifts')

@section ('subtitle', 'Create New Shift')

@section ('icon', 'clock outline')

@section('content')

  <div class="ui container">

    <a href="{{ route('admin.shifts.index') }}" class="ui basic black button">
      <i class="left chevron icon"></i>
      Back
    </a>

    <a href="{{ route('admin.shifts.edit', $shift) }}" class="ui yellow left labeled icon button">
      <i class="edit icon"></i> Edit
    </a>

    <a href="{{ route('admin.shifts.create') }}" class="ui black button">
      <i class="pencil icon"></i> Create Another Shift
    </a>
  
    <div class="ui dividing header">
      <i class="clock alternate icon"></i>
      <div class="content">
        Shift #{{ $shift->id }}
        <div class="sub header">
          {{ $shift->start->format('l, F j, Y') }} |
          {{ $shift->start->format('h:i A') }} - {{ $shift->end->format('h:i A') }}
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

    @foreach ($shift->employees as $employee)
    <div class="ui black label">
      <i class="user circle icon"></i>
      {{ $employee->firstname }}
      <div class="detail">
        {{ $shift->positions[$loop->index]->name }}
      </div>
    </div>
    @endforeach

  </div>

@endsection
