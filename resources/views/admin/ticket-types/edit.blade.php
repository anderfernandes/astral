@extends('layout.admin')

@section('title', 'Edit Ticket Type')

@section('subtitle', 'Edit Ticket Type ' . $ticketType->name)

@section('icon', 'ticket')

@section('content')

  <div class="ui container">

    @include('admin.ticket-types._form', ['ticketType' => $ticketType])

  </div>

@endsection
