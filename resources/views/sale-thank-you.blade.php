@extends('layout.astral')

@section('title', "Field Trip Confirmed!")

@section('content')

<div class="ui container">
  
  <img src="{{ $setting->logo }}" alt="{{ $setting->organization }}" class="ui centered tiny image">

  <div class="ui icon blue message">
    <i class="thumbs up icon"></i>
    <div class="content">
      <div class="header">
        Your field trip has been confirmed, {{ $sale->customer->firstname }}!
      </div>
      <p>We hope you and group have a great field trip!</p>
    </div>
  </div>
  <a class="ui massive fluid blue button" href="http://{{ $setting->website }}">
    Back to {{ $setting->organization }}'s website
  </a>

  <h4 class="ui center aligned header">
    <div class="content">
      {{ $setting->organization }} <br /> {{ $setting->address }}
      <div class="sub header">
        <i class="phone icon"></i>{{ $setting->phone }} |
        <i class="at icon"></i>{{ $setting->email }} |
        <i class="globe icon"></i><a href="http://{{ App\Setting::find(1)->website }}" target="_blank">{{ $setting->website }}</a> | 
        <a href="https://astral.anderfernandes.com" class="ui black tiny image label" target="_blank">
          <img src="https://astral.anderfernandes.com/assets/astral-logo-light.png" alt="Astral" />
          Powered by Astral
        </a>
      </div>
    </div>
  </h4>

</div>

@endsection