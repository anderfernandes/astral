<div class="ui sidebar vertical menu" style="overflow: visible !important">
  <div class="item" style="text-align:center">
    <h1 class="ui icon header"><i class="user circle outline large icon"></i></h1>
    <br />
    {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}
    <br /><br />
    <div class="ui tiny buttons">
      <a href="{{ route('account') }}" class="ui secondary button"><i class="user icon"> </i>Account</a>
      {!! Form::open(['route' => ['logout'], 'method' => 'POST']) !!}
        {{ csrf_field() }}
        {!! Form::button('<i class="sign out icon"></i> Logout',
          ['type' => 'submit', 'class' => 'ui button'])
        !!}
      {!! Form::close() !!}
    </div>
  </div>
  <!-- Pending loop to automatically pull all menu items -->
  <a class="{{ Request::routeIs('cashier.index') ? "active " : ""}}item" href="{{ route('cashier.index') }}">
    <i class="inbox icon"></i> Cashier
  </a>
  <div class="ui dropdown item">
    <i class="right chevron icon"></i>
    Reports
    <div class="menu">
      <a class="item" href="{{ route('cashier.reports', 'closeout') }}" target="_blank">
        <i class="file text icon"></i> Closeout Report
      </a>
      <a class="item" href="{{ route('cashier.reports', 'transaction-detail') }}" target="_blank">
        <i class="file text outline icon"></i> Transaction Detail Report
      </a>
    </div>
  </div>
  <div class="ui dropdown item">
    <i class="right chevron icon"></i>
    Sales
    <div class="menu">
      <a href="{{ route('cashier.sales.index') }}" class="item">
        <i class="dollar icon"></i> All Sales</a>
      <a class="item" href="javascript:$('#find-sale-modal').modal('show')">
        <i class="search icon"></i> Find
      </a>
    </div>
  </div>
  <a href="{{ route('cashier.members.index') }}" class="item"> <i class="address card icon"></i> Members</a>
</div>

<!-- Find Sale Modal -->
<div class="ui basic modal" id="find-sale-modal">
  <div class="ui icon header">
    <i class="search icon"></i>
    Find Sale
    <div class="sub header" style="color:white">Fill out at least one field to find a sale</div>
  </div>
  <div class="content">
    {!! Form::open(['route' => 'cashier.query', 'class' => 'ui form', 'id' => 'find-sale']) !!}
    <div class="inverted segment">
      <div class="four fields">
        <div class="field">
          {!! Form::label('query_id', 'Sale Number') !!}
          {!! Form::text('query_id', null, ['placeholder' => 'Sale Number']) !!}
        </div>
        <div class="field">
          {!! Form::label('query_total', 'Sale Total') !!}
          <div class="ui labeled input">
            <div class="ui label">$</div>
            {!! Form::text('query_total', null, ['placeholder' => 'Sale Total']) !!}
          </div>

        </div>
        <div class="field">
          {!! Form::label('query_payment_method', 'Sale Payment Method') !!}
          <div class="ui selection dropdown">
            <input type="hidden" name="query_payment_method" >
            <i class="dropdown icon"></i>
            <div class="default text">Payment Method</div>
            <div class="menu">
              @foreach (App\PaymentMethod::all() as $paymentMethod)
                <div class="item" data-value="{{ $paymentMethod->id}}"><i class="{{ $paymentMethod->icon }} icon"></i>{{ $paymentMethod->name }}</div>
              @endforeach
            </div>
          </div>
        </div>
        <div class="field">
          {!! Form::label('query_reference', 'Reference') !!}
          {!! Form::text('query_reference', null, ['placeholder' => 'Check or Credit Card #']) !!}
        </div>
      </div>
    </div>
  </div>
  <div class="actions">
    <div class="ui blue inverted button" onclick="$('#find-sale-modal').modal('hide')">
      <i class="cancel icon"></i>
      Close
    </div>
    <div class="ui standard inverted button">
      <i class="eraser icon"></i>
      Clear Form
    </div>
    {!! Form::button('<i class="search icon"></i> Find Sale', ['type' => 'submit', 'class' => 'ui green ok inverted button']) !!}
  </div>
  {!! Form::close() !!}
</div>
