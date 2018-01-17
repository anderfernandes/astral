@extends('layout.admin')

@section('title', 'Sale Information')

@section('subtitle', 'Sale #' . $sale->id)

@section('icon', 'dollar')

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
        ({{ Date::parse($sale->created_at)->diffForHumans() }})
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
    <a href="{{ route('admin.sales.index') }}" class="ui default button">
      <i class="left chevron icon"></i>
      Back to Sales
    </a>
    <a href="{{ route('admin.calendar.index') }}" class="ui default button">
      <i class="left chevron icon"></i>
      Back to Calendar
    </a>
    <a href="{{ route('admin.sales.edit', $sale) }}" class="ui primary button"><i class="edit icon"></i>Edit</a>
    <div class="ui floating secondary dropdown button">
      <i class="copy icon"></i> Invoices <i class="dropdown icon"></i>
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
        @foreach($sale->events as $event)
          @if ($event->id != 1)
            @foreach($sale->tickets->unique('ticket_type_id') as $ticket)
              <div class="ui black label">{{ $ticket->type->name }} ({{ $sale->tickets->where('event_id', $event->id)->where('ticket_type_id', $ticket->type->id)->count() }})</div>
            @endforeach
          @endif
        @endforeach
      </h3>

      <h3 class="ui header">
        <div class="sub header">
          Events
        </div>
      </h3>

      @foreach($sale->events as $event)
        @if($event->show->id != 1)
          @if ($sale->refund)
            <h3 class="ui red header">
          @endif
        <h3 class="ui header">
          <img src="{{ $event->show->cover }}" alt="" class="ui mini image">
          <div class="content">
            {{ $event->show->name }} <div class="ui black circular label">{{ $event->type->name }}</div>
            <div class="sub header">
              {{ Date::parse($event->start)->format('l, F j, Y \a\t g:i A') }}
            </div>
          </div>
        </h3>
        @endif
      @endforeach

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
        @if (number_format($sale->total - $sale->payments->sum('tendered'), 2) > 0)
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
        <div class="two fields">
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
          total          : ['is[{{ number_format($sale->total, 2) }}]', 'empty'],
          memo           : ['minLength[10]', 'empty']
        }
    });
  });
  </script>

@endsection
