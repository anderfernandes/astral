@extends('layout.admin')

@section('title', 'Event Information')

@section('subtitle', $event->show->name)

@section('icon', 'calendar check')

@section('content')

  <div class="ui buttons">
    <a href="{{ route('admin.calendar.index') }}?type=events{{ isSet($request->date) ? '&date=' . $request->date : null }}" class="ui default button">
      <i class="left chevron icon"></i> Back
    </a>
    <a href="javascript:$('#edit-event').modal('show')" class="ui yellow button">
      <i class="edit icon"></i> Edit This Event
    </a>
    <a href="{{ route('admin.events.create') }}" class="ui secondary button">
      <i class="calendar plus icon"></i> Create Another Event
    </a>
    @if ($event->sales->count() <= 0)
    {!! Form::open(['route' => ['admin.events.destroy', $event], 'method' => 'DELETE']) !!}
      {!! Form::button('<i class="trash icon"></i> Delete Event', ['type' => 'submit', 'class' => 'ui negative button']) !!}
    {!! Form::close() !!}
    @endif
  </div>

  <div class="ui items">
    <div class="item">
      <div class="ui medium rounded image">
        <img src="{{ $event->show->cover }}" alt="">
      </div>
      <div class="content">
        <div class="meta">
          <div class="ui label" style="background-color: {{ $event->type->color }}; color: rgba(255, 255, 255, 0.8)">{{ $event->type->name }}</div>
          @if ($event->show->type != 'system')
            <div class="ui label">{{ $event->show->type }}</div>
          @endif
          <div class="ui label">{{ $event->show->duration }} minutes</div>
          <div class="ui label">{{ App\Ticket::where('event_id', $event->id)->count() }} tickets sold</div>
          <div class="ui basic label">{{ $event->public ? 'Public' : 'Private' }}</div>
        </div>
        <h1 class="ui large header">
          {{ $event->show->name }}
          <div class="sub header">
            <i class="calendar alternate icon"></i>
            {{ Date::parse($event->start)->format('l, F j, Y \a\t g:i A') }}
          </div>
        </h1>
        <div class="extra">
          {{-- Display creator only if it is a no user --}}
          @if ($event->creator_id == 1)
            <p>Created on {{ Date::parse($event->created_at)->format('l, F j, Y \a\t g:i:s A') }} ({{ Date::parse($event->created_at)->diffForHumans()}})</p>
          @else
            <p>Created by <i class="user circle icon"></i> {{ $event->creator->fullname }} on {{ Date::parse($event->created_at)->format('l, F j, Y \a\t g:i:s A') }} ({{ Date::parse($event->created_at)->diffForHumans()}})</p>
          @endif

          <p>Updated on {{ Date::parse($event->updated_at)->format('l, F j, Y \a\t g:i:s A') }} ({{ Date::parse($event->updated_at)->diffForHumans()}})</p>
        </div>
        <div class="extra">
          @if ($event->memo)
            <h3>Memo</h3>
            {{ $event->memo }}
          @endif
        </div>
      </div>
    </div>
  </div>

  {{-- Memos --}}
    <h4 class="ui horizontal divider header">
      <i class="comment outline icon"></i> Memo
    </h4>

    @if ($event->memos->count() > 0)
    <div class="ui comments">
      @foreach($event->memos as $memo)
        <div class="comment">
          <div class="avatar"><i class="user circle big icon"></i></div>
          <div class="content">
            <div class="author">
              {{ $memo->author->fullname }}
              <div class="ui tiny black label">{{ $memo->author->role->name }}</div>
              <div class="metadata">
                <span class="date">{{ Date::parse($memo->created_at)->format('l, F j, Y \a\t g:i A') }} ({{ Date::parse($memo->created_at)->diffForHumans() }})</span>
              </div>
            </div>
            <div class="text">
              {{ $memo->message }}
            </div>
          </div>
        </div>
      @endforeach
    </div>
    @else
    <div class="ui info icon message">
      <i class="info circle icon"></i>
      <i class="close icon"></i>
      <div class="content">
        <div class="header">
          No Memos!
        </div>
        <p>This sale has no memos so far.</p>
      </div>
    </div>
    @endif

    {{-- Sales in this event --}}
    <h4 class="ui horizontal divider header">
      <i class="dollar icon"></i> Sales
    </h4>
    @if ($event->sales->where('customer_id', '!=', 1)->where('status', '!=', 'canceled')->count() > 0)
      @foreach ($event->sales->where('customer_id', '!=', 1)->where('status', '!=', 'canceled') as $sale)
        <h3 class="ui dividing header">
          <div class="content">
            <a class="sub header" href="{{ route('admin.sales.show', $sale) }}">
              Sale # {{ $sale->id }}
              @if ($sale->status == 'complete')
                <span class="ui tiny green label"><i class="checkmark icon"></i>
              @elseif ($sale->status == 'no show')
                <span class="ui tiny orange label"><i class="thumbs outline down icon"></i>
              @elseif ($sale->status == 'open')
                <span class="ui tiny violet label"><i class="unlock icon"></i>
              @elseif ($sale->status == 'tentative')
                <span class="ui tiny yellow label"><i class="help icon"></i>
              @elseif ($sale->status == 'canceled')
                <span class="ui tiny red label"><i class="remove icon"></i>
              @else
                <span class="ui tiny label">
              @endif
              {{ $sale->status }}</span>
            </a>
              @if ($sale->organization_id != 1)
                <a href="{{ route('admin.organizations.show', $sale->organization) }}">{{ $sale->organization->name }}</a> |
              @endif
              @if ($sale->organization->name != $sale->customer->firstname)
                <a href="{{ route('admin.users.show', $sale->customer) }}">{{ $sale->customer->fullname }}</a>
              @endif
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
            There are no group sales for this event.
            @if (App\Ticket::where('event_id', $event->id)->count() > 0)
              There are, however, {{ App\Ticket::where('event_id', $event->id)->count() }} tickets solds to this event.
            @endif
          </p>
        </div>
      </div>
    @endif

  @include('admin.partial.events._edit')

@endsection
