@extends('layout.admin')

@section('title', 'Event Information')

@section('subtitle', $event->show->name)

@section('icon', 'calendar check')

@section('content')

  <div class="ui buttons">
    <a href="{{ route('admin.events.index') }}" class="ui default button">
      <i class="left chevron icon"></i> Back
    </a>
    <a href="javascript:$('#edit-event').modal('show')" class="ui primary button">
      <i class="edit icon"></i> Edit This Event
    </a>
    <a href="{{ route('admin.events.create') }}" class="ui secondary button">
      <i class="calendar plus icon"></i> Create Another Event
    </a>
    {!! Form::open(['route' => ['admin.events.destroy', $event], 'method' => 'DELETE']) !!}
      {!! Form::button('<i class="trash icon"></i> Delete Event', ['type' => 'submit', 'class' => 'ui negative button']) !!}
    {!! Form::close() !!}
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
          @if ($event->sales->count() > 0)
          <h4 class="ui horizontal divider header">
            <i class="dollar icon"></i> Sales
          </h4>
          @foreach ($event->sales as $sale)
            @if (!$sale->refund and $sale->customer->id != 1)
            <h3 class="ui dividing header">
              <div class="content">
                <div class="sub header">Sale # {{ $sale->id }}</div>
                <a href="{{ route('admin.sales.show', $sale->id) }}">{{ $sale->organization->name }}
                  @if (!($sale->organization->name == $sale->customer->firstname))
                  | {{ $sale->customer->fullname }}
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
          @endif
          @endforeach
          @endif
        </div>
      </div>
    </div>
  </div>

  @include('admin.partial.events._edit')

@endsection
