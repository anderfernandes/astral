@extends('layout.admin')

@section('title', 'Settings')

@section('subtitle', 'Change global values')

@section('icon', 'setting')

@section('content')

<div class="ui grid">
  <div class="three wide column">
    <div class="ui vertical fluid tabular menu">
      <a class="item active" data-tab="general"><i class="setting icon"></i>General</a>
      <a class="item" data-tab="announcements"><i class="announcement icon"></i>Announcements</a>
      <a class="item" data-tab="organization-types"><i class="university icon"></i>Organizations</a>
      <a class="item" data-tab="ticket-types"><i class="ticket icon"></i>Tickets</a>
      <a class="item" data-tab="payment-methods"><i class="money icon"></i>Payments</a>
      <a class="item" data-tab="event-types"><i class="calendar icon"></i>Events</a>
      <a class="item" data-tab="user-roles"><i class="users icon"></i>Users</a>
      <a class="item" data-tab="member-types"><i class="address card outline icon"></i>Membership</a>
      <a class="item" data-tab="bulletin"><i class="comments outline icon"></i>Bulletin</a>
      <a class="item" data-tab="product-types"><i class="box icon"></i>Products</a>
      <a class="item" data-tab="grade"><i class="book icon"></i>Grades</a>
    </div>
  </div>

  <div class="thirteen wide streched column">

    {{-- General --}}
    @include('admin.settings._general')

    {{-- Announcements --}}
    @include('admin.settings._announcements')

    {{-- Organization Types --}}
    @include('admin.settings._organization')

    {{-- Ticket Types --}}
    @include('admin.settings._ticket')

    {{-- Payment Methods --}}
    @include('admin.settings._payment')

    {{-- Event Types --}}
    @include('admin.settings._event')

    {{-- User Roles --}}
    @include('admin.settings._roles')

    {{-- Member Types --}}
    @include('admin.settings._member')

    {{-- Bulletin --}}
    @include('admin.settings._bulletin')

    {{-- Product Types --}}
    @include('admin.settings._product')

    {{-- Grades --}}
    @include('admin.settings._grade')

</div>

<script>
  $('.menu .item').tab({ history: true });

  $('#general').form({
    on: 'blur',
    inline: true,
    fields: {
      organization : ['empty'],
      seats        : ['number', 'empty'],
      tax          : ['number', 'empty'],
      logo         : ['empty'],
      cover        : ['empty'],
    }
  })

  $('#organizations').form({
    on: 'blur',
    inline: true,
    fields: {
      name: ['empty'],
      taxable: ['empty'],
      description: ['empty'],
    }
  })

  $('#payment_methods').form({
    on: 'blur',
    inline: true,
    fields: {
      name        : ['empty'],
      icon        : ['empty'],
      type        : ['empty'],
      description : ['empty'],
    }
  })

  $('#users').form({
    on: 'blur',
    inline: true,
    fields: {
      name        : 'empty',
      staff       : 'empty',
      description : 'empty',
    }
  })

  $('#memberships').form({
    on: 'blur',
    inline: true,
    fields: {
      name            : 'empty',
      description     : 'empty',
      price           : ['number', 'empty'],
      duration        : ['number', 'empty'],
      max_secondaries : ['number', 'empty'],
    }
  })

  $('#bulletin').form({
    on: 'blur',
    inline: true,
    fields: {
      name        : 'empty',
      description : 'empty',
    }
  })

  var hideIcons = ["quote", "image", "guide"]

  var simplemde = new SimpleMDE({
    element: document.getElementById('membership_text'),
    hideIcons: hideIcons
  })

  var simplemde = new SimpleMDE({
    element: document.getElementById('confirmation_text'),
    hideIcons: hideIcons
  })

  var simplemde = new SimpleMDE({
    element: document.getElementById('invoice_text'),
    hideIcons: hideIcons
  })

  var tel = document.querySelectorAll('[type="tel"]');
  for (var i = 0; i < tel.length; i++) {
    tel[i].addEventListener('input', function(e) {
      var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
      e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
    })
  }
</script>

@endsection
