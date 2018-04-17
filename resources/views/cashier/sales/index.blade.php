@extends('layout.cashier')

@section('title', 'Sales')

@section ('name', 'Manage Sales')

@section ('icon', 'dollar')

@section('content')

  <div class="ui floating secondary dropdown button">
    <i class="plus icon"></i> New Sale<i class="dropdown icon"></i>
    <div class="menu">
      @foreach (App\EventType::where('id', '!=', 1)->get() as $eventType)
        <a href="{{ route('cashier.sales.create') }}?eventType={{ $eventType->id }}" class="item">{{ $eventType->name }}</a>
      @endforeach
    </div>
  </div>


  <!--
  <div class="ui right icon input">
    <input type="text" name="search" placeholder="Sale Number">
    <i class="search link icon"></i>
  </div>
  <select name="payment_type" id="payment_type" class="ui dropdown">
    <option value="">All Payment Types</option>
    <option value="Cash">Cash</option>
    <option value="Visa">Visa</option>
  </select>
  <div class="ui selection dropdown">
    <input type="hidden" id="status" name="status">
    <i class="dropdown icon"></i>
    <div class="default text">All Sale Status</div>
    <div class="menu">
      <div class="item" data-value="open"><i class="unlock icon"></i>Open</div>
      <div class="item" data-value="complete"><i class="checkmark icon"></i>Complete</div>
      <div class="item" data-value="canceled"><i class="remove icon"></i>Canceled</div>
      <div class="item" data-value="tentative"><i class="help icon"></i>Tentative</div>
      <div class="item" data-value="no show"><i class="thumbs outline down icon"></i>No Show</div>
    </div>
  </div>
  -->


@include('partial.sales._index')

@include('cashier.partial._spinner')

@endsection
