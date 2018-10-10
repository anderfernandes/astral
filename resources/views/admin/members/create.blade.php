@extends('layout.admin')

@section('title', 'Members')

@section('subtitle', 'Add Member')

@section('icon', 'address card')

@section('content')

  {{ Session::flash('info',
    'Make sure you make the right person a member. Membership status will only be granted upon payment')
  }}

  @include('admin.members._form')

@endsection
