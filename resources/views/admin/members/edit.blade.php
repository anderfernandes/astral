@extends('layout.admin')

@section('title', 'Renew Membership')

@section('subtitle', $member->users[0]->firstname . ' ' . $member->users[0]->lastname)

@section('icon', 'address card')

@section('content')

  <div class="sixteen wide column">
    {{ Session::flash('info',
      'Make sure you make the right changes here. Pay very close attention to free and non-free secondaries as well as membership start/end dates and membership type!')
    }}

  @include('admin.members._form')

@endsection
