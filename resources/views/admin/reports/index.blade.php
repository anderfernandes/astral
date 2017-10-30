@extends('layout.admin')

@section('title', 'Reports')

@section ('subtitle', 'Reports')

@section ('icon', 'file text outline')

@section('content')


  <div class="ui button huge black"><i class="file text icon outline"></i> Closeout</div>
  <div class="ui button huge black"><i class="file text icon"></i> Transaction Detail</div>

  <div class="ui basic modal" id="closeout">
  <div class="ui icon header">
    <i class="archive icon"></i>
    Closeout Report
  </div>
  <div class="content">
    <p>Select the payment user:</p>
  </div>
  <div class="content">
    <p>Select the payment range:</p>
  </div>

  <div class="actions">
    <div class="ui red basic cancel inverted button">
      <i class="remove icon"></i>
      No
    </div>
    <div class="ui green ok inverted button">
      <i class="checkmark icon"></i>
      Yes
    </div>
  </div>
</div>

@endsection
