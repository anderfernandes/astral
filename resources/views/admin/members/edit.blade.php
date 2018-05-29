@extends('layout.admin')

@section('title', 'Renew Membership')

@section('subtitle', $member->users[0]->firstname . ' ' . $member->users[0]->lastname)

@section('icon', 'address card')

@section('content')

  <div class="sixteen wide column">
    <div class="ui info icon message">
      <i class="info circle icon"></i>
      <i class="close icon"></i>
      <div class="content">
        <div class="header">
          Make sure you make the right person a member!
        </div>
        <p>A sale will be created for the person. Membership status will only be granted upon payment.</p>
      </div>
    </div>
  </div>

  <br />

  @include('admin.members._form')

@endsection
