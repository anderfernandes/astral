@extends('layout.cashier')

@section('title', 'Member Information')

@section ('name', $member->users[0]->firstname.' '.$member->users[0]->lastname)

@section ('icon', 'address card')

@section('content')

  @include('partial.members._show')

@endsection
