@extends('layout.admin')

@section('title', 'Event Information')

@section('subtitle', $event->show->name)

@section('icon', 'calendar check')

@section('content')

  <div class="ui buttons">
    <a href="{{ route('admin.calendar.index') }}/?type=events" class="ui default button">
      <i class="left chevron icon"></i> Back
    </a>
    <a href="javascript:$('#edit-event').modal('show')" class="ui primary button">
      <i class="edit icon"></i> Edit This Event
    </a>
    <a href="{{ route('admin.events.create') }}" class="ui secondary button">
      <i class="calendar plus icon"></i> Create Another Event
    </a>
    {{--
    {!! Form::open(['route' => ['admin.events.destroy', $event], 'method' => 'DELETE']) !!}
      {!! Form::button('<i class="trash icon"></i> Delete Event', ['type' => 'submit', 'class' => 'ui negative button']) !!}
    {!! Form::close() !!}
    --}}
  </div>

  <div class="ui items">
    <div class="item">
      <div class="ui rounded image">
        <img src="{{ $event->show->cover }}" alt="">
      </div>
      <div class="content">
        <div class="meta">
          <div class="ui label">{{ $event->type->name }}</div>
          <div class="ui label">{{ App\Show::find($event->show_id)->type }}</div>
          <div class="ui label">{{ App\Show::find($event->show_id)->duration }} minutes</div>
          <div class="ui label">{{ App\Ticket::where('event_id', $event->id)->count() }} tickets sold</div>
        </div>
        <h1 class="ui large header">
          {{ App\Show::find($event->show_id)->name }}
          <div class="sub header">
            <i class="calendar icon"></i>
            {{ Date::parse($event->start)->format('l, F j, Y \a\t g:i A') }}
          </div>
        </h1>
        <div class="extra">
          <p>Created by {{ $event->creator->firstname }} {{ $event->creator->lastname }} on {{ Date::parse($event->created_at)->format('l, F j, Y \a\t g:i:s A') }} ({{ Date::parse($event->created_at)->diffForHumans()}})</p>
          <p>Updated on {{ Date::parse($event->updated_at)->format('l, F j, Y \a\t g:i:s A') }} ({{ Date::parse($event->updated_at)->diffForHumans()}})</p>
        </div>
        <div class="extra">
          @if ($event->memo)
            <h3>Memo</h3>
            {{ $event->memo }}
          @endif
        </div>
        <div class="extra">
          <h4 class="ui horizontal divider header">
            <i class="dollar icon"></i> Sales
          </h4>
          @if ($event->sales->where('customer_id', '!=', 1)->count() > 0)
            @foreach ($event->sales->where('customer_id', '!=', 1) as $sale)
              <h3 class="ui dividing header">
                <div class="content">
                  <a class="sub header" href="{{ route('admin.sales.show', $sale) }}">Sale # {{ $sale->id }}</a>
                    @if ($sale->organization_id != 1)
                      <a href="{{ route('admin.organizations.show', $sale->organization) }}">{{ $sale->organization->name }}</a>
                    @endif
                    @if (!($sale->organization->name == $sale->customer->firstname))
                      | <a href="{{ route('admin.users.show', $sale->customer) }}">{{ $sale->customer->fullname }}</a>
                    @endif
                  </a>
                  <div class="sub header">
                    <div class="ui green tag label">$ {{ number_format($sale->total, 2) }}</div>
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
            @endforeach
          @else
            <div class="ui info icon message">
              <i class="info circle icon"></i>
              <i class="close icon"></i>
              <div class="content">
                <div class="header">
                  No Group Sales!
                </div>
                <p>
                  There are no group sales for this show.
                  @if (App\Ticket::where('event_id', $event->id)->count() > 0)
                    There are, however, {{ App\Ticket::where('event_id', $event->id)->count() }} tickets solds to this event.
                  @endif
                </p>
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>

  @include('admin.partial.events._edit')

@endsection
