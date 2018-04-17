@extends('layout.admin')

@section('title', 'Organizations')

@section('subtitle', $organization->name)

@section('icon', 'university')

@section('content')

  <div class="ui buttons">
    <a href="{{ route('admin.organizations.index') }}" class="ui default button">
      <i class="left chevron icon"></i> Back
    </a>
    <a href="{{ route('admin.organizations.edit', $organization) }}" class="ui yellow button">
      <i class="edit icon"></i> Edit This Organization
    </a>
    <a href="{{ route('admin.organizations.create') }}" class="ui primary button">
      <i class="calendar plus icon"></i> Add Another Organization
    </a>
  </div>

  <div class="ui large dividing header">
      <i class="university icon"></i>
      <div class="content">
        {{ $organization->name }} <div class="ui label" style="margin-left:0">{{ $organization->type->name }}</div>
        <div class="ui label" style="margin-left:0">
          {{ $pastSales->count() + $futureSales->count() }}
          {{ $pastSales->count() + $futureSales->count() == 1 ? 'visit' : 'visits'}}
        </div>
        <div class="sub header">
          {{-- Display creator only if it is a no user --}}
          @if ($organization->creator_id == 1)
            Created on {{ Date::parse($organization->created_at)->format('l, F j, Y \a\t g:i:s A') }} ({{ Date::parse($organization->created_at)->diffForHumans()}}) <br />
          @else
            Created by <strong>{{ $organization->creator->fullname }}</strong> on {{ Date::parse($organization->created_at)->format('l, F j, Y \a\t g:i:s A') }} ({{ Date::parse($organization->created_at)->diffForHumans()}}) <br />
          @endif
          Updated on {{ Date::parse($organization->updated_at)->format('l, F j, Y \a\t g:i:s A') }} ({{ Date::parse($organization->created_at)->diffForHumans()}})
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

  @if ($organization->users->where('active', true)->count() > 0)
  <div class="ui dividing header">
    <div class="content">
      Users
      <div class="sub header">In this Organization: {{ $organization->users->where('active', true)->count() }}</div>
    </div>
  </div>
  <div class="ui relaxed list">
    @foreach ($organization->users->where('active', true) as $user)
      <div class="item">
        <i class="large user circle icon"></i>
        <div class="content">
          <div class="header">
            <a href="{{ route('admin.users.show', $user) }}" target="_blank">{{ $user->fullname }}</a>
            <div class="ui black label">{{ $user->role->name }}</div>
          </div>
        </div>
      </div>
    @endforeach
  </div>
  @endif



@endsection
