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

<table class="ui selectable striped single line very compact table">
  <thead>
    <tr>
      <th>Sale #</th>
      <th>Customer</th>
      <th>Total</th>
      <th>Balance</th>
      <th>Status</th>
      <th>Created by</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    @foreach($sales as $sale)
      @if($sale->refund)
        <tr class="negative">
      @else
        <tr>
      @endif
        <td><h3 class="ui center aligned header">{{ $sale->id }}</h3></td>
        <td>
          <h4 class="ui header">
            @if ($sale->customer->firstname == "Walk-up" or $sale->customer->firstname == $sale->organization->name)
              {{ $sale->customer->firstname }}
            @else
              @if ($sale->sell_to_organization)
                {{ $sale->customer->fullname }}
                @if ($sale->organization->id != 1)
                <div class="sub header">
                  {{ $sale->organization->name }}
                </div>
                @endif
              @else
                {{ $sale->customer->fullname }}
              @endif

            @endif
          </h3>
        </td>
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
          @if($sale->refund)
            <span class="ui red label"><i class="reply icon"></i>refund</span>
          @endif
        </td>
        <td>{{ $sale->creator->firstname }}</td>
        <td>
          <div class="ui icon buttons">
            <a href="{{ route('admin.sales.show', $sale) }}" class="ui secondary button"><i class="eye icon"></i></a>
            <a href="{{ route('admin.sales.edit', $sale) }}" class="ui primary button"><i class="edit icon"></i></a>
            <div class="ui icon top left pointing dropdown secondary button">
              <i class="copy icon"></i>
              <div class="menu">
                @if ($sale->events->count() > 0)
                  @if ($sale->status != "canceled")
                    <a class="item" target="_blank" href="{{ route('admin.sales.confirmation', $sale) }}">Reservation Confirmation</a>
                    <a class="item" target="_blank" href="{{ route('admin.sales.invoice', $sale) }}">Invoice</a>
                    <a class="item" target="_blank" href="{{ route('admin.sales.receipt', $sale) }}">Receipt</a>
                  @else
                    <a class="item" target="_blank" href="{{ route('admin.sales.cancelation', $sale) }}">Cancelation Receipt</a>
                  @endif
                @else
                  <a class="item" href="{{ route('cashier.members.receipt', $sale->customer->member) }}" target="_blank">Membership Receipt</a>
                @endif

              </div>
            </div>

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

<br /><br />

<div class="ui centered grid">
  {{ $sales->links('vendor.pagination.semantic-ui') }}
</div>

<br /> <br />

@endsection
