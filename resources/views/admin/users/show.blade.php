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
      <div class="ui label" style="margin-left:0">
        {{ $pastSales->count() + $futureSales->count() }}
        {{ $pastSales->count() + $futureSales->count() == 1 ? 'visit' : 'visits'}}
      </div>
      <div class="sub header">
        {{-- Display creator only if it is a no user --}}
        @if ($user->creator_id == 1)
          Created on {{ Date::parse($user->created_at)->format('l, F j, Y \a\t g:i:s A') }} ({{ Date::parse($user->created_at)->diffForHumans()}})
        @else
          Created by <strong>{{ $user->creator->fullname }}</strong> on {{ Date::parse($user->created_at)->format('l, F j, Y \a\t g:i:s A') }} ({{ Date::parse($user->created_at)->diffForHumans()}})
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

  @if ($futureSales->count() > 0)
    <div class="ui dividing header">
      <div class="content">
        Future Visits
        <div class="sub header">Total Events Attended: {{ $futureSales->count() }}</div>
      </div>
    </div>
    <div class="ui four column grid">
      @foreach ($futureSales as $sale)
          @foreach($sale->events as $event)
            @if($event->show->id != 1)
            <div class="column">
              <div class="ui items">
                <div class="item">
                  <div class="ui tiny image"><img src="{{ $event->show->cover }}" alt="{{ $event->show->name }}"></div>
                  <div class="content">
                    <div class="meta">
                      <div class="ui label" style="background-color: {{ $event->type->color }}; color: rgba(255, 255, 255, 0.8)">{{ $event->type->name }}</div>
                    </div>
                    <div class="header">{{ $event->show->name }}</div>
                    <div class="meta">
                      {{ Date::parse($event->start)->format('l, F j, Y \a\t g:i A') }}
                    </div>
                    <a href="{{ route('admin.sales.show', $sale) }}" target="_blank" class="extra">Sale #{{ $sale->id }}</a>
                  </div>
                </div>
              </div>
            </div>
            @endif
          @endforeach
      @endforeach
    </div>
  @endif

  @if ($pastSales->count() > 0)
    <div class="ui dividing header">
      <div class="content">
        Past Visits
        <div class="sub header">Total Events Attended: {{ $pastSales->count() }}</div>
      </div>
    </div>
    <div class="ui four column grid">
      @foreach ($pastSales as $sale)
          @foreach($sale->events as $event)
            @if($event->show->id != 1)
            <div class="column">
              <div class="ui items">
                <div class="item">
                  <div class="ui tiny image"><img src="{{ $event->show->cover }}" alt="{{ $event->show->name }}"></div>
                  <div class="content">
                    <div class="meta">
                      <div class="ui label" style="background-color: {{ $event->type->color }}; color: rgba(255, 255, 255, 0.8)">{{ $event->type->name }}</div>
                    </div>
                    <div class="header">{{ $event->show->name }}</div>
                    <div class="meta">
                      {{ Date::parse($event->start)->format('l, F j, Y \a\t g:i A') }}
                    </div>
                    <a href="{{ route('admin.sales.show', $sale) }}" target="_blank" class="extra">Sale #{{ $sale->id }}</a>
                  </div>
                </div>
              </div>
            </div>
            @endif
          @endforeach
      @endforeach
    </div>
  @endif

  @include('admin.partial.users._edit')

@endsection
