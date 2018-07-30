@extends('layout.admin')

@section('title', 'Sales')

@section ('subtitle', 'Manage Sale')

@section ('icon', 'dollar')

@section('content')

  {!! Form::open(['route' => 'admin.sales.index', 'class' => 'ui form', 'method' => 'get']) !!}
  <div class="seven fields">
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
          @foreach (App\User::where('staff', false)->where('type', 'individual')->get() as $customer)
            <div class="item" data-value="{{ $customer->id }}">
              {{ $customer->fullname }}
            </div>
          @endforeach
        </div>
      </div>
    </div>
    <div class="field">
      <div class="ui selection search dropdown" id="sale-organization">
        <input type="hidden" id="saleOrganization" name="saleOrganization">
        <i class="dropdown icon"></i>
          <div class="default text">All Organizations</div>
        <div class="menu">
          <div class="item" data-value="">All Organizations</div>
          @foreach (App\Organization::where('id', '!=', 1)->orderBy('name', 'asc')->get() as $organization)
            <div class="item" data-value="{{ $organization->id }}">
              {{ $organization->name }}
            </div>
          @endforeach
        </div>
      </div>
    </div>
    <div class="field">
      <div class="ui labeled input">
        <div class="ui basic label">$</div>
        <input type="text" value="{{ $request->saleTotal ? $request->saleTotal : "" }}" name="saleTotal" id="saleTotal" placeholder="Sale Total">
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
      {!! Form::button('<i class="search icon"></i> Search', ['type' => 'submit', 'class' => 'ui floated secondary button']) !!}
    </div>
  </div>
  {!! Form::close() !!}

  @if (str_contains(Auth::user()->role->permissions['sales'], "C"))
  <div class="ui secondary dropdown button">
    <i class="ui icons">
      <i class="film icon"></i>
      <i class="inverted corner add icon"></i>
    </i>
    New Sale
    <div class="menu">
      @foreach ($eventTypes as $eventType)
        @if ($eventType->allowedTickets->count() > 0)
        <a href="{{ route('admin.sales.create') }}?eventType={{ $eventType->id }}" class="item">{{ $eventType->name }}</a>
        @endif
      @endforeach
    </div>
  </div>
  @endif


@include('partial.sales._index')

<script>
  @if ($request->saleCustomer)
    $('#sale-customer').dropdown('set exactly', {{ $request->saleCustomer }})
  @endif
  @if ($request->saleOrganization)
    $('#sale-organization').dropdown('set exactly', {{ $request->saleOrganization }})
  @endif
  @if ($request->paymentUser)
    $('#payment-user').dropdown('set exactly', {{ $request->paymentUser }})
  @endif
  @if ($request->saleStatus)
    $('#sale-status').dropdown('set exactly', "{{ $request->saleStatus }}")
  @endif
</script>

@endsection
