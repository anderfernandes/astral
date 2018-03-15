@extends('layout.admin')

@section('title', 'Sale Information')

@section('subtitle', 'Sale #' . $sale->id)

@section('icon', 'dollar')

@section('content')

  @if ($sale->memos->count() > 0)
    <div class="ui info icon message">
      <i class="info circle icon"></i>
      <i class="close icon"></i>
      <div class="content">
        <div class="header">
          Hey, you!
        </div>
        <p>This sale has one or more memos. <a href="#memos">Click here</a> to read them.</p>
      </div>
    </div>
  @endif

  @if ($sale->refund)
  <h3 class="ui red dividing header">
  @else
  <h3 class="ui dividing header">
  @endif
    <i class="dollar icon"></i>
    <div class="content">
      Sale # {{ $sale->id }}
      @if ($sale->refund)
        <div class="ui red label"><i class="reply icon"></i> Refund</div>
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
  </h3>

  @if (!$sale->refund)
    @if ($sale->payments->sum('total') > 0)
    <div class="ui right floated buttons">
      <div onclick="$('#refund-modal').modal('show')" class="ui red button"><i class="reply icon"></i> Refund</div>
    </div>
    @endif
  @endif
  <div class="ui left floated buttons">
    <a href="{{ route('admin.sales.index') }}" class="ui default button">
      <i class="left chevron icon"></i>
      Back
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

  <br /><br />

  <div class="ui center aligned segment">
    <h4 class="ui horizontal divider header">
      <i class="dollar icon"></i> Sale Information
    </h4>
    <table class="ui very basic celled table">
      <thead>
        <tr>
          <th>Sale #</th>
          <th>Source</th>
          <th>Created by</th>
          <th>Created On</th>
          <th>Last Modified</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><h4 class="ui header">{{ $sale->id }}</h4></td>
          <td>{{ $sale->source }}</td>
          <td>{{ $sale->creator->fullname }}</td>
          <td>{{ Date::parse($sale->created_at)->format('l, F j, Y \a\t g:i A') }} ({{ Date::parse($sale->created_at)->diffForHumans() }})</td>
          <td>{{ Date::parse($sale->updated_at)->format('l, F j, Y \a\t g:i A') }} ({{ Date::parse($sale->updated_at)->diffForHumans() }})</td>
        </tr>
      </tbody>
    </table>
  </div>

  @if ($sale->customer_id != 1 )

  <div class="ui center aligned segment">
    <h4 class="ui horizontal divider header">
      <i class="user circle icon"></i> Customer Information
    </h4>

    <table class="ui very basic celled table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Address</th>
          <th>Phone</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><h4 class="ui header">{{ $sale->customer->fullname }}</h4></td>
          <td>{{ $sale->customer->email }}</td>
          <td>{{ $sale->customer->address }} {{ $sale->customer->city }}, {{ $sale->customer->state }} {{ $sale->customer->zip }}</td>
          <td>{{ $sale->organization->phone }}</td>
        </tr>
      </tbody>
    </table>
  </div>

  @if ($sale->organization_id != 1)
  <div class="ui center aligned segment">
    <h4 class="ui horizontal divider header">
      <i class="university icon"></i> Organization Information
    </h4>
    <table class="ui very basic celled table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Address</th>
          <th>Phone</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><h4 class="ui header">{{ $sale->organization->name }}</h4></td>
          <td>{{ $sale->organization->email }}</td>
          <td>{{ $sale->organization->address }} {{ $sale->organization->city }}, {{ $sale->organization->state }} {{ $sale->organization->zip }}</td>
          <td>{{ $sale->organization->phone }}</td>
        </tr>
      </tbody>
    </table>
  </div>
  @endif

  @endif

  <div class="ui center aligned segment">
    <h4 class="ui horizontal divider header">
      <i class="calendar check icon"></i> Events and Attendance
    </h4>
    <div class="ui ordered horizontal divided list">
      @foreach($sale->events as $event)
        <div class="item">
        @if($event->show->id != 1)
          @if ($sale->refund)
            <h3 class="ui red header">
          @endif
        <h3 class="ui header">
          <img src="{{ $event->show->cover }}" alt="{{ $event->show->name }}" class="image">
          <div class="content">
            <div class="sub header">
              {{ Date::parse($event->start)->format('l, F j, Y \a\t g:i A') }}
              <div class="ui black circular label">{{ $event->type->name }}</div>
            </div>
            <a href="{{ route('admin.events.edit', $event) }}" target="_blank">{{ $event->show->name }}</a>
            <div class="sub header">
              @foreach($sale->tickets->unique('ticket_type_id') as $ticket)
                <div class="ui black label" style="margin-left:0">
                  <i class="ticket icon"></i>
                  {{ $sale->tickets->where('event_id', $event->id)->where('ticket_type_id', $ticket->type->id)->count() }}
                  <div class="detail">
                    {{ $ticket->type->name }}
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        </h3>
        @endif
      </div>
      @endforeach
    </div>
  </div>

  <div class="ui center aligned segment">
    <h4 class="ui horizontal divider header">
      <i class="dollar icon"></i> Totals
    </h4>

    <div class="ui tiny five statistics">
      <div class="statistic">
        <div class="label">Subtotal</div>
        <div class="value"><i class="dollar sign icon"></i> {{ number_format($sale->subtotal, 2) }}</div>
      </div>
      <div class="statistic">
        <div class="label">Tax</div>
        <div class="value"><i class="dollar sign icon"></i> {{ number_format($sale->total - $sale->subtotal, 2) }}</div>
      </div>
      <div class="statistic">
        <div class="label">Total</div>
        <div class="value"><i class="dollar sign icon"></i> {{ number_format($sale->total, 2) }}</div>
      </div>
      @if ($sale->payments->sum('tendered') == 0)
        <div class="yellow statistic">
      @elseif ($sale->payments->sum('tendered') < 0)
        <div class="red statistic">
      @else
        <div class="green statistic">
      @endif
        <div class="label">Paid</div>
        <div class="value"><i class="dollar sign icon"></i> {{ number_format($sale->payments->sum('tendered'), 2) }}</div>
      </div>
      @if ($sale->total - $sale->payments->sum('tendered') == 0)
        <div class="green statistic">
      @else
        <div class="red statistic">
      @endif
        <div class="label">Balance</div>
        <div class="value">
          @if (number_format($sale->total - $sale->payments->sum('tendered'), 2) > 0)
            <i class="dollar sign icon"></i> {{ number_format($sale->total - $sale->payments->sum('tendered'), 2) }}
          @else
            <i class="dollar sign icon"></i> 0.00
          @endif
        </div>
      </div>
    </div>
  </div>

  <div class="ui center aligned segment">
    <h4 class="ui horizontal divider header">
      <i class="money icon"></i> Payments
    </h4>

    <table class="ui selectable single line table">
      <thead>
        <tr>
          <th>#</th>
          <th>Method</th>
          <th>Tendered</th>
          <th>Date</th>
          <th>Cashier</th>
          @if (!$sale->refund)
            @if ($sale->payments->where('refunded', false)->where('total', '>', 0)->count() > 1)
              @if ($sale->payments->sum('total') > 0)
                @if ($sale->payments[0]->cashier_id == Auth::user()->id)
                <th>Actions</th>
                @endif
              @endif
            @endif
          @endif
        </tr>
      </thead>
      <tbody>
        @if(count($sale->payments) > 0)
          @foreach($sale->payments as $payment)
            @if ($payment->total < 0)
            <tr class="negative">
            @else
            <tr>
            @endif
              <td><div class="ui header">{{ $payment->id }}</div></td>
              <td>{{ $payment->method->name }}</td>
              <td>{{ number_format($payment->total, 2) }}</td>
              <td>{{ Date::parse($payment->created_at)->format('l, F j, Y \a\t g:i A') }}</td>
              <td @if($payment->total < 0 or $payment->refunded) colspan="2" @endif>{{ $payment->cashier->firstname }}</td>
              @if (!$sale->refund)
                @if ($sale->payments->where('refunded', false)->where('total', '>', 0)->count() > 1)
                  @if ($sale->payments->sum('total') > 0)
                    @if ($payment->total > 0)
                      @if (!$payment->refunded)
                        @if ($payment->cashier_id == Auth::user()->id)
                        <td>
                          {!! Form::open(['route' => ['admin.sales.refundPayment', $payment], 'class' => 'ui form', 'id' => 'refundPayment']) !!}
                            {!! Form::button('<i class="reply icon"></i>', ['type' => 'submit', 'class' => 'ui mini basic icon button']) !!}
                          {!! Form::close() !!}
                        </td>
                        @endif
                      @endif
                    @endif
                  @endif
                @endif
              @endif
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

  <div class="ui segment" id="memos">
    <h4 class="ui horizontal divider header">
      <i class="comment outline icon"></i> Memo
    </h4>

    <div class="ui comments">
      @foreach(App\SaleMemo::where('sale_id', $sale->id)->orderBy('updated_at', 'desc')->get() as $memo)
        <div class="comment">
          <div class="avatar"><i class="user circle big icon"></i></div>
          <div class="content">
            <div class="author">
              {{ $memo->author->fullname }}
              <div class="metadata">
                <span class="date">{{ Date::parse($memo->created_at)->format('l, F j, Y \a\t g:i A') }} ({{ Date::parse($memo->created_at)->diffForHumans() }})</span>
              </div>
            </div>
            <div class="text">
              {{ $memo->message }}
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>

  {{-- Refund Modal --}}
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
