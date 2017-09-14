@extends('layout.admin')

@section('title', 'Sales')

@section ('subtitle', 'New Sales')

@section ('icon', 'dollar')

@section('content')

{!! Form::open(['route' => 'admin.sales.store', 'class' => 'ui form']) !!}
<div class="field">
  <div class="ui buttons">
    <a href="{{ route('admin.sales.index') }}" class="ui default button"><i class="left chevron icon"></i> Back</a>
    {!! Form::button('<i class="save icon"></i> Save', ['type' => 'submit', 'class' => 'ui secondary button']) !!}
  </div>
</div>
<div class="two fields">
  <div class="field">
    {!! Form::label('customer_id', 'Customer') !!}
    {!! Form::select('customer_id', $customers, null,
      [
        'placeholder' => 'Select a customer or organization',
        'class'       => 'ui search dropdown'
      ])
    !!}
  </div>
  <div class="field">
    {!! Form::label('status', 'Status') !!}
    {!! Form::select('status',
      [
        'open'      => 'Open',
        'tentative' => 'Tentative',
        'no show'   => 'No Show',
        'complete'  => 'Complete',
        'canceled'  => 'Canceled'
      ],
      null,
      ['placeholder' => 'Sales status', 'class' => 'ui dropdown'])
    !!}
  </div>
</div>
<div class="two fields">
  <div class="field">
    {!! Form::label('event_id', 'First Show') !!}
    {!! Form::select('event_id', $events, null,
      [
        'placeholder' => 'Select the event',
        'class'       => 'ui search dropdown'
      ])
    !!}
  </div>
  <div class="field">
    {!! Form::label('event_id', 'Second Event') !!}
    {!! Form::select('event_id', $events, null,
      [
        'placeholder' => 'Leave blank if they are watching only one show',
        'class'       => 'ui search dropdown'
      ])
    !!}
  </div>
</div>
<div class="ui two column doubling grid">
    <div class="column">
      <table class="ui selectable single line very compact table">
        <thead>
          <tr>
            <th>Ticket Type</th>
            <th>Amount / Price</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($ticketTypes as $ticketType)
          <tr>
            <td>
              <h4 class="ui header">
                <i class="ticket icon"></i>
                <div class="content">
                  {{ $ticketType->name }}
                  <div class="sub header">{{ $ticketType->description }}</div>
                </div>
              </h4>
            </td>
            <td>
              <div class="ui right labeled input">
                {!! Form::text('ticket['. $ticketType->id .']', 0, ['placeholder' => 'Amount of '. $ticketType->name . ' tickets', 'size' => 1]) !!}
                <div class="ui tag label">$ {{ number_format($ticketType->price, 2) }} each</div>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="column">
      <div class="three fields">
        <div class="field">
          {!! Form::label('payment_method_id', 'Payment Method') !!}
          <div class="ui fluid selection dropdown">
            <input type="hidden" name="payment_method_id">
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
          {!! Form::label('tendered') !!}
          <div class="ui labeled input">
            <div class="ui label">$ </div>
            {!! Form::text('tendered', null, ['placeholder' => 'Tendered']) !!}
          </div>
        </div>
        <div class="field">
          {!! Form::label('reference', 'Reference') !!}
          {!! Form::text('reference', null, ['placeholder' => 'Credit Card or Check reference.']) !!}
        </div>
      </div>
      <div class="field">
        {!! Form::label('memo', 'Memo') !!}
        {!! Form::textarea('memo', null, ['placeholder' => 'Write a memo here']) !!}
      </div>
    </div>
  </div>
{!! Form::close() !!}

@endsection
