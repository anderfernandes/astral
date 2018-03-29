@extends('layout.admin')

@section('title', 'User Information')

@section('subtitle', $user->fullname)

@section('icon', 'user')

@section('content')

  <div class="ui buttons">
    <a href="{{ route('admin.users.index') }}" class="ui default button">
      <i class="left chevron icon"></i> Back
    </a>
    <a href="javascript:$('#edit-user').modal('show')" class="ui primary button">
      <i class="edit icon"></i> Edit User
    </a>
    <a href="{{ route('admin.users.create') }}" class="ui secondary button"><i class="add user icon"></i> Add User</a>
    {!! Form::open(['route' => ['admin.users.destroy', $user], 'method' => 'DELETE']) !!}
      {!! Form::button('<i class="trash icon"></i> Delete User', ['type' => 'submit', 'class' => 'ui negative button']) !!}
    {!! Form::close() !!}
  </div>

  <div class="ui large dividing header">
    <i class="user circle icon"></i>
    <div class="content">
      {{ $user->fullname }}
      @if ($user->staff) <i style="display:inline-block" class="star icon"></i>@endif
      <div class="ui label" style="margin-left:0">{{ $user->role->name }}</div>
      @if ($user->organization_id != 1)
        <a href="{{ route('admin.organizations.show', $user->organization) }}" target="_blank" class="ui label" style="margin-left:0">{{ $user->organization->name }}</a>
      @endif
      <div class="sub header">
        {{-- Display creator only if it is a no user --}}
        @if ($user->creator_id == 1)
          Created on {{ Date::parse($user->created_at)->format('l, F j, Y \a\t g:i:s A') }} ({{ Date::parse($user->created_at)->diffForHumans()}})
        @else
          Created by <strong>{{ $user->creator->fullname }}</strong> on {{ Date::parse($user->created_at)->format('l, F j, Y \a\t g:i:s A') }} ({{ Date::parse($organization->created_at)->diffForHumans()}})
        @endif
      </div>
    </div>
  </div>
  <div class="ui three column stackable grid">
    <div class="column">
      <h3 class="ui header">
        {{ $user->address }}
        <div class="sub header">Address</div>
      </h3>
      <h3 class="ui header">
        {{ $user->country }}
        <div class="sub header">
          Country
        </div>
      </h3>
      <h3 class="ui header">
        {{ $user->phone }}
        <div class="sub header">
          Phone
        </div>
      </h3>
    </div>
    <div class="column">
      <h3 class="ui header">
        {{ $user->city }}
        <div class="sub header">
          City
        </div>
      </h3>
      <h3 class="ui header">
        {{ $user->zip }}
        <div class="sub header">
          ZIP
        </div>
      </h3>
      @if ($user->fax)
      <h3 class="ui header">
        {{ $user->fax }}
        <div class="sub header">
          Fax
        </div>
      </h3>
      @endif
    </div>
    <div class="column">
      <h3 class="ui header">
        {{ $user->state }}
        <div class="sub header">
          State
        </div>
      </h3>
      <h3 class="ui header">
        {{ $user->email }}
        <div class="sub header">
          Email
        </div>
      </h3>
    </div>
  </div>

  @if ($sales->count() > 0)
    <div class="ui dividing header">
      <div class="content">
        Visits
        <div class="sub header">Total Events Attended: {{ $sales->count() }}</div>
      </div>
    </div>
    @foreach ($sales as $sale)
      <div class="ui horizontal divided list">
        @foreach($sale->events as $event)
          <div class="item">
          @if($event->show->id != 1)
            @if ($sale->refund)
              <h3 class="ui red header">
            @endif
          <h3 class="ui header">
            <img src="{{ $event->show->cover }}" alt="{{ $event->show->name }}" class="image">
            <div class="content">
              <div class="sub header">
                {{ Date::parse($event->start)->format('l, F j, Y \a\t g:i A') }}
                <div class="ui black circular label">{{ $event->type->name }}</div>
              </div>
              <a href="{{ route('admin.events.edit', $event) }}" target="_blank">{{ $event->show->name }}</a>
              <div class="sub header">
                @foreach($sale->tickets->unique('ticket_type_id') as $ticket)
                  <div class="ui black label" style="margin-left:0">
                    <i class="ticket icon"></i>
                    {{ $sale->tickets->where('event_id', $event->id)->where('ticket_type_id', $ticket->type->id)->count() }}
                    <div class="detail">
                      {{ $ticket->type->name }}
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </h3>
          @endif
        </div>
        @endforeach
      </div>
    @endforeach
  @endif

  @include('admin.partial.users._edit')

@endsection
