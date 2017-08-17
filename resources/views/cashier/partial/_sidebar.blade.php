<div class="ui sidebar vertical menu">
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
    <i class="dollar icon"></i> Cashier
  </a>
  <a class="item" href="javascript:$('#find-sale-modal').modal('show')">
    <i class="search icon"></i> Find Sale
  </a>
  <a class="item" href="{{ route('cashier.reports', 'closeout') }}" target="_blank">
    <i class="file text icon"></i> Closeout Report
  </a>
  <a class="item" href="{{ route('cashier.reports', 'transaction-detail') }}" target="_blank">
    <i class="file text outline icon"></i> Transaction Detail Report
  </a>
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
            <input type="hidden" name="query_payment_method">
            <i class="dropdown icon"></i>
            <div class="default text">Payment Method</div>
            <div class="menu">
              <div class="item" data-value="cash"><i class="money icon"></i>Cash</div>
              <div class="item" data-value="visa"><i class="visa icon"></i>Visa</div>
              <div class="item" data-value="mastercard"><i class="mastercard icon"></i>Mastercard</div>
              <div class="item" data-value="discover"><i class="discover icon"></i>Discover</div>
              <div class="item" data-value="american express"><i class="american express icon"></i>American Express</div>
              <div class="item" data-value="check"><i class="check icon"></i>Check</div>
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
