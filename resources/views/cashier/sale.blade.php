@extends('layout.cashier')

@section('title', 'Sale Information | Sale #'.$sale->id)

@section('icon', 'inbox')

@section('name', 'Sale Information | Sale #'.$sale->id)

@section('content')

  @if ($sale->refund)
  <h2 class="ui red dividing header">
  @else
  <h2 class="ui dividing header">
  @endif
    <i class="dollar icon"></i>
    <div class="content">
      Sale # {{ $sale->id }}
      @if ($sale->refund)
        <div class="ui red label"><i class="refresh icon"></i> Refund</div>
      @endif
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
      <div class="sub header">
        by {{ $sale->creator->firstname }} {{ $sale->creator->lastname }}
        on {{ Date::parse($sale->created_at)->format('l, F j, Y \a\t g:i A') }}
        ({{ Date::parse($sale->created_at)->ago() }})
      </div>
      @if ($sale->refund)
      <div class="sub header">
        <strong>Refunded on {{ Date::parse($sale->updated_at)->format('l, F j, Y \a\t g:i A') }} ({{ Date::parse($sale->updated_at)->diffForHumans() }})</strong>
      </div>
      @endif
    </div>
  </h2>

  @if (!$sale->refund)
  <div class="ui right floated buttons">
    <a href="javascript:$('#refund-modal').modal('show')" class="ui red button"><i class="refresh icon"></i> Refund</a>
  </div>
  @endif
  <div class="ui left floated buttons">
    <a href="javascript:window.close()" class="ui default button">
      <i class="left chevron icon"></i>
      Back
    </a>
    <a href="{{ route('admin.sales.edit', $sale) }}" class="ui primary button"><i class="edit icon"></i>Edit</a>
  </div>

  <br /><br /><br />

  <div class="ui two column grid">
    <div class="column">
      @if ($sale->refund)
      <h2 class="ui red header">
      @else
      <h2 class="ui header">
      @endif
        <div class="sub header">Sale #</div>
        {{ $sale->id }}
      </h2>

      @if ($sale->refund)
      <h2 class="ui red header">
      @else
      <h2 class="ui header">
      @endif
        <div class="sub header">Customer</div>
        {{ $sale->customer->firstname.' '.$sale->customer->lastname }}
      </h2>

      @if ($sale->refund)
      <h2 class="ui red header">
      @else
      <h2 class="ui header">
      @endif
        <div class="sub header">Organization</div>
        {{ $sale->organization->name }}
      </h2>

      @if ($sale->refund)
      <h2 class="ui red header">
      @else
      <h2 class="ui header">
      @endif
        <div class="sub header">Source</div>
        {{ $sale->source }}
      </h2>

      @if ($sale->refund)
      <h2 class="ui red header">
      @else
      <h2 class="ui header">
      @endif
        <div class="sub header">Created on</div>
        {{ Date::parse($sale->created_at)->format('l, F j, Y \a\t g:i A') }}
        ({{ Date::parse($sale->created_at)->diffForHumans() }})
      </h2>

      @if ($sale->refund)
      <h2 class="ui red header">
      @else
      <h2 class="ui header">
      @endif
        <div class="sub header">Updated on</div>
        {{ Date::parse($sale->updated_at)->format('l, F j, Y \a\t g:i A') }}
        ({{ Date::parse($sale->updated_at)->diffForHumans() }})
      </h2>

      @if ($sale->refund)
      <h3 class="ui red header">
      @else
      <h3 class="ui header">
      @endif
        <div class="sub header">Number of Tickets Sold</div>
        {{ count($sale->tickets) }}
      </h3>

    </div>
    <div class="column">
      @if ($sale->reference)
        @if ($sale->refund)
        <h2 class="ui red header">
        @else
        <h2 class="ui header">
        @endif
        <div class="sub header">Reference</div>
        {{ $sale->reference }}
      </h2>
      @endif

      @if ($sale->refund)
      <h2 class="ui red header">
      @else
      <h2 class="ui header">
      @endif
        <div class="sub header">Subtotal</div>
        $ {{ number_format($sale->subtotal, 2) }}
      </h2>

      @if ($sale->refund)
      <h2 class="ui red header">
      @else
      <h2 class="ui header">
      @endif
        <div class="sub header">Tax</div>
        $ {{ number_format($sale->total - $sale->subtotal, 2) }}
      </h2>

      @if ($sale->refund)
      <h2 class="ui red header">
      @else
      <h2 class="ui header">
      @endif
        <div class="sub header">Total</div>
        $ {{ number_format($sale->total, 2) }}
      </h2>

      @if ($sale->refund)
      <h2 class="ui red header">
      @else
      <h2 class="ui header">
      @endif
        <div class="sub header">Balance</div>
        @if (number_format($sale->total - $sale->payments->sum('tendered'), 2) > 2)
          $ {{ number_format($sale->total - $sale->payments->sum('tendered'), 2) }}
        @else
          $ 0.00
        @endif
      </h2>

      @if ($sale->refund)
      <h2 class="ui red header">
      @else
      <h2 class="ui header">
      @endif
        <div class="sub header">Paid</div>
        $ {{ number_format($sale->payments->sum('tendered'), 2) }}
      </h2>

      <table class="ui selectable single line table">
        <thead>
          <tr>
            <th>#</th>
            <th>Method</th>
            <th>Amount Paid</th>
            <th>Date</th>
            <th>Cashier</th>
          </tr>
        </thead>
        <tbody>
          @if(count($sale->payments) > 0)
            @foreach($sale->payments as $payment)
              <tr>
                <td><div class="ui header">{{ $payment->id }}</div></td>
                <td>{{ $payment->method->name }}</td>
                <td>{{ number_format($payment->tendered, 2) }}</td>
                <td>{{ Date::parse($payment->created_at)->format('l, F j, Y \a\t g:i A') }}</td>
                <td>{{ $payment->cashier->firstname }}</td>
              </tr>
            @endforeach
          @else
            <tr class="warning center aligned">
              <td colspan="5"><i class="info circle icon"></i> No payments have been received so far</td>
            </tr>
          @endif
        </tbody>
      </table>

    </div>

    @if (isset($sale->memo))
    <div class="column">
      @if ($sale->refund)
      <h3 class="ui red header">
      @else
      <h3 class="ui header">
      @endif
        <div class="sub header">Memo</div>
        {{ $sale->memo }}
      </h3>
    </div>
    @endif

  </div>

  <div class="ui horizontal divider header">
    <i class="ticket icon"></i>
    Tickets
  </div>

  <div class="ui basic segment">
    @if ($sale->refund)
    <table class="ui celled selectable inverted red padded striped table">
    @else
    <table class="ui celled selectable padded striped table">
    @endif
      <thead>
        <tr>
          <th class="single line">Ticket Number</th>
          <th>Type</th>
          <th>Show Name</th>
          <th>Show Date</th>
          <th>Sale #</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($sale->tickets as $ticket)
        <tr>
          @if ($sale->refund)
            <th><h3 class="ui inverted center aligned header">{{ $ticket->id }}</h3></th>
          @else
            <th><h3 class="ui center aligned header">{{ $ticket->id }}</h3></th>
          @endif
          <th>{{ $ticket->type->name }}</th>
          <th>{{ $ticket->event->show->name }}</th>
          <th>{{ Date::parse($ticket->event->start)->format('l, F j, Y \a\t g:i A') }}</th>
          <th>{{ $sale->id }}</th>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <!-- Refund Modal -->
  <div class="ui basic modal" id="refund-modal">
    <div class="ui icon header">
      <i class="refresh icon"></i>
      Refund
      <div class="sub header" style="color:white">Please confirm sale information</div>
    </div>
    <div class="content">
      {!! Form::open(['route' => ['admin.sales.refund', $sale], 'class' => 'ui form', 'id' => 'refund']) !!}
      <div class="inverted segment">
        @if ($sale->reference)
        <div class="four fields">
        @else
        <div class="three fields">
        @endif
          <div class="field">
            {!! Form::label('id', 'Sale Number') !!}
            {!! Form::text('id', null, ['placeholder' => 'Sale Number']) !!}
          </div>
          <div class="field">
            {!! Form::label('total', 'Sale Total') !!}
            <div class="ui labeled input">
              <div class="ui label">$</div>
              {!! Form::text('total', null, ['placeholder' => 'Sale Total']) !!}
            </div>

          </div>
          <div class="field">
            {!! Form::label('payment_method', 'Sale Payment Method') !!}
            <div class="ui selection dropdown">
              {!! Form::hidden('payment_method', null, ['id' => 'payment_method']) !!}
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
          @if ($sale->reference)
          <div class="field">
            {!! Form::label('reference', 'Reference') !!}
            {!! Form::text('reference', null, ['placeholder' => 'Check or Credit Card #']) !!}
          </div>
          @endif
        </div>
        <div class="field">
          {!! Form::label('memo', 'Memo') !!}
          {!! Form::textarea('memo', null, ['placeholder' => 'Explain why you had to give a refund']) !!}
        </div>
      </div>
    </div>
    <div class="actions">
      <div class="ui blue inverted button" onclick="$('#refund-modal').modal('hide')">
        <i class="cancel icon"></i>
        Close
      </div>
      <div class="ui standard inverted button" onclick="$('form').form('clear')">
        <i class="eraser icon"></i>
        Clear Form
      </div>
      {!! Form::button('<i class="refresh icon"></i> Refund', ['type' => 'submit', 'class' => 'ui red inverted button', 'id' => 'submit-refund']) !!}
    </div>
    {!! Form::close() !!}
  </div>

  <script>

  $('button#submit-refund').click(function() {
    $('#refund.ui.form')
      .form({
        fields: {
          id             : ['is[{{ $sale->id }}]', 'empty'],
          total          : ['is[{{ $sale->total }}]', 'empty'],
          payment_method : ['is[{{ $sale->payment_method }}]', 'empty'],
          @if ($sale->reference)
          reference      : ['is[{{ $sale->reference }}]', 'empty'],
          @endif
          memo           : ['minLength[10]', 'empty']
        }
    });
  });
  </script>

@endsection
