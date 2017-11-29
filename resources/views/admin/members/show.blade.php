@extends('layout.admin')

@section('title', 'Member Information')

@section('subtitle', $member->users[0]->firstname.' '.$member->users[0]->lastname)

@section('icon', 'user')

@section('content')

  <div class="ui buttons">
    <a href="{{ route('admin.members.index') }}" class="ui default button">
      <i class="left chevron icon"></i> Back
    </a>
    <a href="{{ route('admin.members.edit', $member) }}" class="ui primary button">
      <i class="edit icon"></i> Edit Member
    </a>
    <a href="{{ route('admin.members.create') }}" class="ui secondary button"><i class="plus icon"></i> Add Another Member</a>
    {!! Form::open(['route' => ['admin.members.destroy', $member], 'method' => 'DELETE']) !!}
      {!! Form::button('<i class="close icon"></i> Cancel Membership', ['type' => 'submit', 'class' => 'ui negative button']) !!}
    {!! Form::close() !!}
  </div>

  <div class="ui unstackable items">
    <div class="item">
      <i class="address card massive icon"></i>
      <div class="content">
        <h1 class="ui huge header">
          {{ $member->users[0]->firstname }} {{ $member->users[0]->lastname }}
          <div class="sub header"># {{ $member->id }}</div>
          <div class="sub header">{{ $member->users[0]->email }}</div>
        </h1>
        <div class="meta">
          <div class="ui label">{{ $member->type->name }}</div>
        </div>
        <div class="meta">
          <i class="checked calendar icon"></i>
          Expires {{ Date::parse($member->end)->format('l, F j, Y') }}
        </div>
        <div class="description">
          <p>Created on {{ Date::parse($member->created_at)->format('l, F j, Y \a\t h:i:s A') }} ({{ Date::parse($member->created_at)->diffForHumans()}})</p>
          <p>Updated on {{ Date::parse($member->updated_at)->format('l, F j, Y \a\t h:i:s A') }} ({{ Date::parse($member->updated_at)->diffForHumans()}})</p>
        </div>
        <div class="extra"></div>
      </div>
    </div>
  </div>

  <div class="ui buttons">
    <a href="{{ route('admin.members.index') }}" class="ui default button">
      <i class="plus icon"></i> Add a Dependent
    </a>
    <a href="{{ route('admin.members.edit', $member) }}" class="ui primary button">
      <i class="refresh icon"></i> Renew Membership
    </a>
    <a href="{{ route('admin.members.receipt', $member) }}" target="_blank" class="ui secondary button">
      <i class="file text icon"></i> View Membership Receipt
      <i class="right chevron icon"></i>
    </a>
    <a href="{{ route('admin.members.card', $member) }}" target="_blank" class="ui yellow button">
      <i class="address card icon"></i> View Card
      <i class="right chevron icon"></i>
    </a>
  </div>

  <table class="ui very basic unstackable table">
    <thead>
      <tr>
        <th>Name</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        @foreach($member->users as $user)
        <td>
          <h4 class="ui header">
            <i class="address card icon"></i>
            <div class="content">
              {{ $user->firstname . ' ' . $user->lastname }}
              <div class="sub header">{{ $member->type->name }}</div>
            </div>
          </h4>
        </td>
        @endforeach
      </tr>
    </tbody>
  </table>

@endsection
