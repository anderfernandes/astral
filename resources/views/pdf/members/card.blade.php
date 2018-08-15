@extends('layout.pdf')

@section('title', $member->users[0]->fullname .'\'s Membership Card')

@section('content')


  <div class="ui segment">
    <div class="ui huge header">
      <img src="{{ (App\Setting::find(1)->logo == '/logo.png') ? "logo.png" : Storage::url(App\Setting::find(1)->logo) }}" alt="" class="ui image">
      <div class="content">
        {{ $member->users[0]->fullname }}
        <div class="sub header">#{{ $member->id }}</div>
      </div>
    </div>
  </div>



@endsection
