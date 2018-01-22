@extends('layout.admin')

@section('title', 'Organizations')

@section('subtitle', $organization->name)

@section('icon', 'university')

@section('content')

  <div class="ui buttons">
    <a href="javascript:window.history.back()" class="ui default button">
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

  <h2 class="ui dividing header">
    {{ $organization->name }} <span class="ui label">{{ $organization->type->name }}</span>
  </h2>


  <div class="ui three column doubling grid">

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
      @if ($organization->email)
      <h3 class="ui header">
        {{ $organization->email }}
        <div class="sub header">
          email
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























@endsection
