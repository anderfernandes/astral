@extends('layout.admin')

@section('title', 'Organizations')

@section('subtitle', 'Manage Organizations')

@section('icon', 'university')

@section('content')

  <a class="ui secondary button" href="{{ route('admin.organizations.create') }}">
    <i class="plus icon"></i> Add Organization
  </a>

  <div class="ui right icon input">
    <input type="text" placeholder="Search...">
    <i class="search link icon"></i>
  </div>

@if (!isset($organizations) || count($organizations) > 0)
  <br /><br />
  <div class="ui four doubling link cards">
    @foreach($organizations as $organization)
    <div class="card">
      <div class="content">
        <i class="university huge right floated icon"></i>
        <div class="header">{{ $organization->name }}</div>
        <div class="meta">
          <div class="ui label">{{ $organization->type->name }}</div>
        </div>
        <div class="meta">
          <i class="phone icon"></i> {{ $organization->phone }}
        </div>
        <div class="meta">
          <i class="mail icon"></i> {{ $organization->email }}
        </div>
        <div class="meta">
          <i class="globe icon"></i>
          <a href="http://{{ $organization->website }}" target="_blank"> {{ $organization->website }}</a>
        </div>
      </div>
      <div class="ui two bottom attached buttons">
        <a href="{{ route('admin.organizations.show', $organization) }}" class="ui black button">
          <i class="book icon"></i> View
        </a>
        <a href="{{ route('admin.organizations.edit', $organization ) }}" class="ui blue button">
          <i class="edit icon"></i> Edit
        </a>
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
        No organizations!
      </div>
      <p>It looks like there are no organizations in the database.</p>
    </div>
  </div>
@endif


@endsection
