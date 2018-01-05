@extends('layout.admin')

@section('title', 'Sales')

@section ('subtitle', 'Manage Sale')

@section ('icon', 'dollar')

@section('content')


  <div class="ui floating secondary dropdown button">
    <i class="plus icon"></i> New Sale<i class="dropdown icon"></i>
    <div class="menu">
      @foreach ($eventTypes as $eventType)
        <a href={{ route('admin.sales.create', $eventType) }} class="item">{{ $eventType->name }}</a>
      @endforeach
    </div>
  </div>


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


@if (!isset($sales) || count($sales) > 0)
<br /><br />
<table class="ui selectable striped single line table">
  <thead>
    <tr>
      <th>Sale #</th>
      <th>Customer</th>
      <th>Total</th>
      <th>Balance</th>
      <th>Status</th>
      <th>Created On</th>
      <th>Event</th>
      <th>Created By</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    @foreach($sales as $sale)
      <tr>
        <td><h3 class="ui center aligned header">{{ $sale->id }}</h3></td>
        @if ($sale->customer->firstname == "Walk-up")
        <td>{{ $sale->customer->firstname }}</td>
        @else
        <td>{{ $sale->customer->firstname }} {{ $sale->customer->lastname }}</td>
        @endif

        <td>$ {{ number_format($sale->total, 2) }}</td>
        <td>
          @if (number_format($sale->total - $sale->payments->sum('tendered'), 2) > 2)
            $ {{ number_format($sale->total - $sale->payments->sum('tendered'), 2) }}
          @else
            $ 0.00
          @endif
        </td>
        <td>
          @if ($sale->status == 'complete')
            <span class="ui green label"><i class="checkmark icon"></i>
          @elseif ($sale->status == 'no show')
            <span class="ui orange label"><i class="thumbs outline down icon"></i>
          @elseif ($sale->status == 'open')
            <span class="ui violet label"><i class="unlock icon"></i>
          @elseif ($sale->status == 'tentative')
            <span class="ui yellow label"><i class="help icon"></i>
          @elseif ($sale->status == 'canceled')
            <span class="ui red label"><i class="remove icon"></i>
          @else
            <span class="ui label">
          @endif
          {{ $sale->status }}</span>
        </td>
        <td>{{ Date::parse($sale->created_at)->format('l, F j, Y \a\t g:i A') }}</td>
        <td>
          @foreach($sale->events as $event)
            @if($event->show->id != 1)
            <h4 class="ui header">
              <img src="{{ $event->show->cover }}" alt="" class="ui mini image">
              <div class="content">
                {{ $event->show->name }} <div class="ui black circular label">{{ $event->type->name }}</div>
                <div class="sub header">
                  {{ Date::parse($event->start)->format('l, F j, Y \a\t g:i A') }}
                </div>
              </div>
            </h4>
            @endif
          @endforeach
        </td>
        <td>{{ $sale->creator->firstname }}</td>
        <td>
          <div class="ui icon buttons">
            <a href="{{ route('admin.sales.show', $sale) }}" class="ui secondary button"><i class="eye icon"></i></a>
            <a href="{{ route('admin.sales.edit', $sale) }}" class="ui primary button"><i class="edit icon"></i></a>
          </div>
        </td>
      </tr>
    @endforeach
  </tbody>

</table>
@else
  <div class="ui info icon message">
    <i class="info circle icon"></i>
    <i class="close icon"></i>
    <div class="content">
      <div class="header">
        No sales!
      </div>
      <p>It looks like there are no sales in the database.</p>
    </div>
  </div>
@endif

<br />

<div class="ui centered grid">
  {{ $sales->links('vendor.pagination.semantic-ui') }}
</div>

<br /> <br />

@endsection
