@extends('layout.cashier')

@section('title', 'Members')

@section ('name', 'Members')

@section ('icon', 'address card')

@section('content')

  <a class="ui secondary button" href="{{ route('cashier.members.create') }}">
    <i class="plus icon"></i> Add Member
  </a>

  <!--<div class="ui right icon input">
    <input type="text" placeholder="Search...">
    <i class="search link icon"></i>
  </div>-->

  <br /><br />

  @if (!isset($members) || count($members) > 0)
    <div class="ui four doubling link cards">
      @foreach($members as $member)
      <div class="card">
        <div class="content">
          <img src="/{{ App\Setting::find(1)->logo }}" alt="" class="left floated mini ui image">
          <div class="header"># {{ $member->id }}</div>
          <div class="header">{{ $member->users[0]->firstname }} {{ $member->users[0]->lastname }}</div>
          <div class="meta">
            <div class="ui label">{{ $member->type->name }}</div>
          </div>
          <div class="meta">
            <i class="checked calendar icon"></i>
            Expires {{ Date::parse($member->end)->format('l, F j, Y') }}
          </div>
          <div class="meta">
            <i class="mail icon"></i> {{ $member->users[0]->email }}
          </div>
        </div>
        <div class="ui secondary bottom attached button">
          <i class="edit icon"></i> Edit
        </div>
      </div>
      @endforeach
    </div>
  @else
    <div class="sixteen wide column">
      <div class="ui info icon message">
        <i class="info circle icon"></i>
        <i class="close icon"></i>
        <div class="content">
          <div class="header">
            No members!
          </div>
          <p>It looks like there are no members in the database.</p>
        </div>
      </div>
    </div>
  @endif

@endsection
