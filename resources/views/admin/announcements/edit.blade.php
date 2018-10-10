@extends('layout.admin')

@section('title', "Edit Announcement")

@section('subtitle', $announcement->title)

@section('icon', 'announcement')

@section('content')

  <div class="ui container">

    @include('admin.announcements._form')

  </div>

@endsection
