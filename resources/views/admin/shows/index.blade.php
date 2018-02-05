@extends('layout.admin')

@section('title', 'Shows')

@section ('subtitle', 'Manage Shows')

@section ('icon', 'film')

@section('content')

  <a href="javascript:$('#add-show').modal('show')" href="#" class="ui secondary button">
    <i class="plus icon"></i> Add Show
  </a>

  <div class="ui right icon input">
    <input type="text" placeholder="Show Name">
    <i class="search link icon"></i>
  </div>
  <select name="type" id="" class="ui dropdown">
    <option value="">All Types</option>
    <option value="Planetarium">Planetarium</option>
    <option value="Laser Light">Laser Light</option>
  </select>
  <!--<select name="grade" id="grade" class="ui dropdown">
  <option value="">All Grades</option>
  <option value="Pre-K">Pre-K</option>
  <option value="Kindergarten">Kindergarten</option>
  <option value="Elementary">Elementary</option>
  <option value="Middle School">Middle School</option>
  <option value="High School">High School</option>
  <option value="College">College</option>
</select>-->

@if (!isset($shows) || count($shows) > 0)
  <br /><br />
  <div class="ui five doubling link cards">
    @foreach($shows as $show)
      <div class="card">
        <div class="content">
          <div class="header">
            {{ $show->name }}
          </div>
          <div class="meta">
            <div class="ui label">{{ $show->type }}</div><div class="ui label">{{ $show->duration }} minutes</div>
          </div>
        </div>
        <a href="{{ route('admin.shows.show', $show) }}" class="image">
          <img src="{{ $show->cover }}">
        </a>
      </div>
    @endforeach
  </div>
@else
  <div class="ui info icon message">
    <i class="info circle icon"></i>
    <i class="close icon"></i>
    <div class="content">
      <div class="header">
        No shows!
      </div>
      <p>It looks like there are no shows in the database.</p>
    </div>
  </div>
@endif

<br /><br />

<div class="ui centered grid">
  {{ $shows->links('vendor.pagination.semantic-ui') }}
</div>

{{-- Add Show Modal --}}
@include('admin.partial.shows._create')

@endsection
