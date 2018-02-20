@extends('layout.admin')

@section('title', 'Sales')

@section ('subtitle', 'Manage Sale')

@section ('icon', 'dollar')

@section('content')

  {!! Form::open(['route' => 'admin.sales.index', 'class' => 'ui form', 'method' => 'get']) !!}
  <div class="seven fields">
    <div class="field">
      <div class="ui secondary dropdown button">
        <i class="plus icon"></i> New Sale<i class="dropdown icon"></i>
        <div class="menu">
          @foreach ($eventTypes as $eventType)
            <a href={{ route('admin.sales.create', $eventType) }} class="item">{{ $eventType->name }}</a>
          @endforeach
        </div>
      </div>
    </div>
    <div class="field">
      <div class="ui input">
        <input type="text" value="{{ $request->saleNumber ? $request->saleNumber : "" }}" name="saleNumber" id="saleNumber" placeholder="Sale Number">
      </div>
    </div>
    <div class="field">
      <div class="ui selection search dropdown" id="sale-customer">
        <input type="hidden" id="saleCustomer" name="saleCustomer">
        <i class="dropdown icon"></i>
          <div class="default text">All Customers</div>
        <div class="menu">
          <div class="item" data-value="">All Customers</div>
          @foreach (App\User::where('staff', false)->get() as $customer)
            <div class="item" data-value="{{ $customer->id }}">
              {{ $customer->fullname }}
            </div>
          @endforeach
        </div>
      </div>
    </div>
    <div class="field">
      <div class="ui labeled input">
        <div class="ui label">$</div>
        <input type="text" value="{{ $request->saleTotal ? $request->saleTotal : "" }}" name="saleTotal" id="saleTotal" placeholder="Sale Total">
      </div>
    </div>
    <div class="field">
      <div class="ui selection search dropdown" id="payment-user">
        <input type="hidden" id="paymentUser" name="paymentUser">
        <i class="dropdown icon"></i>
        <div class="default text">All Cashiers</div>
        <div class="menu">
          <div class="item" data-value="">All Cashiers</div>
          @foreach (App\User::where('staff', true)->get() as $paymentUser)
            <div class="item" data-value="{{ $paymentUser->id }}">
              {{ $paymentUser->firstname }}
            </div>
          @endforeach
        </div>
      </div>
    </div>
    <div class="field">
      <div class="ui selection dropdown" id="sale-status">
        <input type="hidden" id="saleStatus" name="saleStatus">
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
    </div>
    <div class="field">
      {!! Form::button('<i class="search icon"></i> Search', ['type' => 'submit', 'class' => 'ui secondary button']) !!}
    </div>
  </div>

  {!! Form::close() !!}


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
          @if (number_format($sale->total - $sale->payments->sum('tendered'), 2) > 0)
            $ {{ number_format($sale->total - $sale->payments->sum('tendered'), 2) }}
          @else
            $ 0.00
          @endif
        </td>
        <td>
          @if ($sale->refund)
            <span class="ui red label"><i class="reply icon"></i>refund</span>
          @else
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
      <p>It looks like we couldn't find what you were looking for or there are no sales in the database.</p>
    </div>
  </div>
@endif

<br /><br />

<div class="ui centered grid">
  {{ $sales->links('vendor.pagination.semantic-ui') }}
</div>

<br /> <br />

<script>
  @if ($request->saleCustomer)
    $('#sale-customer').dropdown('set exactly', {{ $request->saleCustomer }})
  @endif
  @if ($request->paymentUser)
    $('#payment-user').dropdown('set exactly', {{ $request->paymentUser }})
  @endif
  @if ($request->saleStatus)
    $('#sale-status').dropdown('set exactly', "{{ $request->saleStatus }}")
  @endif
</script>

@endsection
