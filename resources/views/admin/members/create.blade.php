@extends('layout.admin')

@section('title', 'Members')

@section('subtitle', 'Add Member')

@section('icon', 'address card')

@section('content')

  <div class="sixteen wide column">
    <div class="ui info icon message">
      <i class="info circle icon"></i>
      <i class="close icon"></i>
      <div class="content">
        <div class="header">
          Make sure you make the right person a member!
        </div>
        <p>A sale will be created for the person. Membership status will only be granted upon payment.</p>
      </div>
    </div>
  </div>

  <br />

  {!! Form::open(['route' => 'admin.members.store', 'class' => 'ui form']) !!}
  <div class="five fields">
    <div class="field">
      {!! Form::label('subtotal', 'Subtotal' ) !!}
      <div class="ui labeled input">
        <div class="ui label">$ </div>
        {!! Form::text('subtotal', number_format(0, 2), ['placeholder' => 'Subtotal', 'readonly' => true]) !!}
      </div>
    </div>
    <div class="field">
      {!! Form::label('tax', 'Tax ('. App\Setting::find(1)->tax .'%)') !!}
      <div class="ui labeled input">
        <div class="ui label">$ </div>
        {!! Form::text('tax', number_format(0, 2), ['placeholder' => 'Tax', 'readonly' => true]) !!}
      </div>
    </div>
    <div class="field">
      {!! Form::label('total', 'Total') !!}
      <div class="ui labeled input">
        <div class="ui label">$ </div>
        {!! Form::text('total', number_format(0, 2), ['placeholder' => 'Total', 'readonly' => true]) !!}
      </div>
    </div>
    <div class="field">
      <label for="paid">Paid</label>
      <div class="ui labeled input">
        <div class="ui label">$ </div>
        <input type="text" id="paid" name="paid" value="{{ number_format(0, 2) }}" readonly>
      </div>
    </div>
    <div class="field">
      <label for="paid">Balance</label>
      <div class="ui labeled input">
        <div class="ui label">$ </div>
        <input type="text" id="balance" name="balance" value="{{ number_format(0, 2) }}" readonly>
      </div>
    </div>
  </div>
  <div class="ui two column grid">
    <div class="column">
      <div class="field">
        {!! Form::label('user_id', 'Name') !!}
        {!! Form::select('user_id', $users, null, ['placeholder' => 'Who do you want to turn into a member?', 'class' => 'ui search dropdown']) !!}
      </div>
      <div class="field">
        {!! Form::label('member_type_id', 'Membership Type') !!}
        {!! Form::select('member_type_id', $memberTypes, null, ['placeholder' => 'What membership type?', 'class' => 'ui search dropdown']) !!}
      </div>
    </div>
    <div class="column">
      <div class="three fields">
        <div class="field">
          {!! Form::label('payment_method_id', 'Payment Method') !!}
          <div class="ui fluid selection dropdown">
            <input type="hidden" id="payment_method_id" name="payment_method_id" value="{{ old('payment_method_id') }}">
            <i class="dropdown icon"></i>
            <div class="default text">Select Payment Method</div>
            <div class="menu">
              @foreach ($paymentMethods as $paymentMethod)
              <div class="item" data-value="{{ $paymentMethod->id }}">
                <i class="{{ $paymentMethod->icon }} icon"></i> {{ $paymentMethod->name }}
              </div>
              @endforeach
            </div>
          </div>
        </div>
        <div class="field">
          {!! Form::label('tendered', 'Tendered') !!}
          <div class="ui labeled input">
            <div class="ui label">$ </div>
            {!! Form::text('tendered', number_format(0, 2), ['placeholder' => 'Tendered']) !!}
          </div>
        </div>
        <div class="field">
          {!! Form::label('change_due', 'Change Due') !!}
          <div class="ui labeled input">
            <div class="ui label">$ </div>
            {!! Form::text('change_due', number_format(0, 2), ['placeholder' => 'Change due', 'readonly' => true]) !!}
          </div>
        </div>
      </div>
      <div class="field">
        {!! Form::label('reference', 'Reference') !!}
        {!! Form::text('reference', null, ['placeholder' => 'Credit Card or Check reference.']) !!}
      </div>
    </div>
  </div>
  <br /><br />
  <div class="field">
    <div class="ui buttons">
      <a href="{{ route('admin.members.index') }}" class="ui default button"><i class="left chevron icon"></i> Back</a>
      {!! Form::button('<i class="plus icon"></i> Add Member', ['type' => 'submit', 'class' => 'ui secondary button']) !!}
    </div>
  </div>
  {!! Form::close() !!}

  <script>
    $('#member_type_id').change(function() {
      var price = $('#member_type_id option:selected').text()
      price = price.split(" ")
      var indexOfPrice = price.length - 1
      price = parseFloat(price[indexOfPrice])
      priceString = price.toFixed(2)
      var tax = (({{ App\Setting::find(1)->tax }}/100) * price).toFixed(2)
      tax = parseFloat(tax)
      total = price + tax
      $('#subtotal').val(priceString)
      $('#tax').val(tax)
      $('#total').val(total)

    })

    $('#tendered').keyup(function() {
      var totalString = document.querySelector('#total').value
      var total = parseFloat(totalString)
      var balanceString = document.querySelector('#balance').value
      var balance = parseFloat(balanceString)
      var tendered = document.querySelector('#tendered').value
      var tenderedString = parseFloat(tendered)
      balance = (tendered - total).toFixed(2)
      balance = balance <= 0 ? balance : (0).toFixed(2)
      $('#balance').val(balance)

      changeDue = (tendered - total).toFixed(2)
      changeDue = changeDue >= 0 ? changeDue : (0).toFixed(2)

      $('#change_due').val(changeDue)
    })
  </script>

@endsection
