@extends('layout.admin')

@section('title', 'Edit Ticket Type')

@section('subtitle', 'Edit Ticket Type ' . $ticketType->name)

@section('icon', 'ticket')

@section('content')

  @include('admin.partial.ticket-types._edit')

@endsection
