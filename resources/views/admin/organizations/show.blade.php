@extends('layout.admin')

@section('title', 'Organizations')

@section('subtitle', $organization->name)

@section('icon', 'university')

@section('content')

  <div class="ui buttons">
    <a href="{{ route('admin.organizations.index') }}" class="ui default button">
      <i class="left chevron icon"></i> Back
    </a>
    <a href="{{ route('admin.organizations.edit', $organization) }}" class="ui primary button">
      <i class="edit icon"></i> Edit This Organization
    </a>
    <a href="{{ route('admin.organizations.create') }}" class="ui secondary button">
      <i class="calendar plus icon"></i> Add Another Organization
    </a>
    {!! Form::open(['route' => ['admin.events.destroy', $organization], 'method' => 'DELETE']) !!}
      {!! Form::button('<i class="trash icon"></i> Delete Organization', ['type' => 'submit', 'class' => 'ui negative button']) !!}
    {!! Form::close() !!}
  </div>

  <div class="ui large dividing header">
      <i class="university icon"></i>
      <div class="content">
        {{ $organization->name }} <div class="ui label" style="margin-left:0">{{ $organization->type->name }}</div>
        <div class="sub header">
          Created on {{ Date::parse($organization->created_at)->format('l, F j, Y \a\t h:i:s A') }} ({{ Date::parse($organization->created_at)->diffForHumans() }})
        </div>
      </div>
  </div>
  <div class="ui three column stackable grid">
    <div class="column">
      <h3 class="ui header">
        {{ $organization->address }}
        <div class="sub header">Address</div>
      </h3>
      <h3 class="ui header">
        {{ $organization->country }}
        <div class="sub header">
          Country
        </div>
      </h3>
      <h3 class="ui header">
        {{ $organization->phone }}
        <div class="sub header">
          Phone
        </div>
      </h3>
    </div>
    <div class="column">
      <h3 class="ui header">
        {{ $organization->city }}
        <div class="sub header">
          City
        </div>
      </h3>
      <h3 class="ui header">
        {{ $organization->zip }}
        <div class="sub header">
          ZIP
        </div>
      </h3>
      @if ($organization->fax)
      <h3 class="ui header">
        {{ $organization->fax }}
        <div class="sub header">
          Fax
        </div>
      </h3>
      @endif
      @if ($organization->website)
      <h3 class="ui header">
        <a href="http://{{ $organization->website }}" target="_blank">http://{{ $organization->website }} <i class="external link icon"></i></a>
        <div class="sub header">
          website
        </div>
      </h3>
      @endif
    </div>
    <div class="column">
      <h3 class="ui header">
        {{ $organization->state }}
        <div class="sub header">
          State
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

@endsection
