@if (!$sale->refund)
  @if ($sale->payments->sum('total') > 0)
  <div class="ui right floated icon buttons">
    <div onclick="$('#refund-modal').modal('toggle')" class="ui red button" title="Refund Sale">
      <i class="reply icon"></i>
    </div>
  </div>
  @endif
@endif
<div class="ui left floated icon buttons">
  <a href="{{ route('admin.sales.index') }}" class="ui black basic button" title="Back to All Sales">
    <i class="left chevron icon"></i>
  </a>
  <a href="{{ Request::routeIs('admin.*') ? route('admin.sales.edit', $sale) : route('cashier.sales.edit', $sale) }}" class="ui yellow button" title="Edit Sale">
    <i class="edit icon"></i>
  </a>
  <div class="ui black dropdown button">
    <i class="copy icon"></i>
    <div class="menu">
      <div class="header">Sale Documents</div>
      @if ($sale->events->count() > 0)
      <div class="item">
        <i class="file icon"></i> In App <i class="dropdown icon"></i>
        <div class="menu">
          @if ($sale->status != "canceled")
          <a class="item" href="{{ route('admin.sales.confirmation', $sale) }}" target="_blank"><i class="file icon"></i> Reservation Confirmation</a>
          <a class="item" href="{{ route('admin.sales.invoice', $sale) }}" target="_blank"><i class="file icon"></i> Invoice</a>
          <a class="item" href="{{ route('admin.sales.receipt', $sale) }}" target="_blank"><i class="file icon"></i> Receipt</a>
          @else
          <a class="item" href="{{ route('admin.sales.cancelation', $sale) }}" target="_blank"><i class="file icon"></i> Cancelation Receipt</a>
          @endif
        </div>
      </div>
      <div class="item">
        <i class="file pdf icon"></i> As PDF <i class="dropdown icon"></i>
        <div class="menu">
          @if ($sale->status != "canceled")
          <a class="item" href="{{ route('admin.sales.confirmation', $sale) }}?format=pdf" target="_blank"><i class="pdf file icon"></i> Reservation Confirmation</a>
          <a class="item" href="{{ route('admin.sales.invoice', $sale) }}?format=pdf" target="_blank"><i class="pdf file icon"></i> Invoice</a>
          <a class="item" href="{{ route('admin.sales.receipt', $sale) }}?format=pdf" target="_blank"><i class="pdf file icon"></i> Receipt</a>
          @else
          <a class="item" href="{{ route('admin.sales.cancelation', $sale) }}?format=pdf" target="_blank"><i class="pdf file icon"></i> Cancelation Receipt</a>
          @endif
        </div>
      </div>
      @else
      <a class="item" href="{{ route('admin.members.receipt', $sale->customer->member) }}" target="_blank"><i class="pdf file icon"></i> Membership Receipt</a>
      @endif
    </div>
  </div>
  @if ($sale->customer_id != 1)
    <div onclick="$('#email-confirmation-letter').modal('toggle')" class="ui black basic button">
      <i class="mail icon"></i>
    </div>
  @endif
</div>

<br />

<h4 class="ui center aligned horizontal divider header"><i class="info circle icon"></i> Sale Data</h4>

<div class="ui three doubling stackable cards">

    <div class="ui raised card">
      <div class="content">
        <div class="ui top attached black center aligned large label">
          <i class="dollar icon"></i> Sale Information
        </div>
        <div class="header">
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
        </div>
        <a href="{{ route('admin.users.show', $sale->creator) }}" target="_blank" class="meta"><i class="user circle icon"></i> {{ $sale->creator->fullname }}</a>
        <div class="meta"><i class="inbox icon"></i> {{ $sale->source }}</div>
        <div class="description">
          <i class="pencil icon"></i> {{ Date::parse($sale->created_at)->format('l, F j, Y \a\t g:i A') }} ({{ Date::parse($sale->created_at)->diffForHumans() }})
        </div>
        <div class="description">
          <i class="edit icon"></i> {{ Date::parse($sale->updated_at)->format('l, F j, Y \a\t g:i A') }} ({{ Date::parse($sale->updated_at)->diffForHumans() }})
        </div>
      </div>
    </div>

    @if ($sale->customer_id != 1 )

    <div class="ui raised card">
      <div class="content">
        <div class="ui top attached black center aligned large label"><i class="user icon"></i> Customer Information</div>
        <a href="{{ route('admin.users.show', $sale->customer) }}" target="_blank" class="header">{{ $sale->customer->fullname }}</a>
        <div class="meta"><i class="user icon"></i> {{ $sale->customer->role->name }}</div>
        @if ($sale->customer->organization_id != 1)
        <a href="{{ route('admin.organizations.show', $sale->customer->organization) }}" class="meta"><i class="university icon"></i>{{ $sale->customer->organization->name }}</a>
        @endif
        <div class="description">
          <i class="map marker alternate icon"></i> {{ $sale->customer->address }} {{ $sale->customer->city }}, {{ $sale->customer->state }} {{ $sale->customer->zip }}
        </div>
        <div class="description">
          <i class="phone icon"></i> {{ $sale->customer->phone}}
        </div>
        <div class="description">
          <i class="at icon"></i> {{ $sale->customer->email }}
        </div>
      </div>
    </div>

    @endif

    @if ($sale->sell_to_organization and $sale->organization_id != 1)

    <div class="ui raised card">
      <div class="content">
        <div class="ui top attached black center aligned large label"><i class="university icon"></i> Organization Information</div>
        <a href="{{ route('admin.organizations.show', $sale->organization) }}" class="header">{{ $sale->organization->name }}</a>
        <div class="meta"><i class="university icon"></i> {{ $sale->organization->type->name }}</div>
        <div class="description">
          <i class="map marker alternate icon"></i> {{ $sale->organization->address }}
        </div>
        <div class="description">
          <i class="map marker icon"></i> {{ $sale->organization->city }}, {{ $sale->organization->state }} {{ $sale->organization->zip }}
        </div>
        <div class="description">
          <i class="phone icon"></i> {{ $sale->organization->phone}}
        </div>
        @isset($sale->organization->website)
        <div class="description">
          <i class="globe icon"></i> {{ $sale->organization->website }}
        </div>
        @endisset
      </div>
    </div>
    @endif

    {{-- Grades --}}
    @if ($sale->grades->count() > 0)
    <div class="ui raised card">
      <div class="content">
        <div class="ui top attached black center aligned large label"><i class="book icon"></i> Grades</div>
        <div class="header">
          <div class="ui large labels">
            @foreach ($sale->grades as $grade)
              <div class="ui black label">{{ $grade->name }}</div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
    @endif

    {{-- Events and Attendance --}}
    <div class="ui raised card">
      <div class="content">
        <div class="ui top attached black center aligned large label"><i class="calendar check icon"></i> Events and Tickets</div>
        <div class="ui list">
          @foreach($sale->events as $event)
            <div class="item">
            @if($event->show->id != 1)
              @if ($sale->refund)
                <h3 class="ui red header">
              @endif
            <h3 class="ui header">
              <img src="{{ $event->show->cover }}" alt="{{ $event->show->name }}" class="ui image">
              <div class="content">
                <div class="sub header">
                  {{ Date::parse($event->start)->format('l, F j, Y \a\t g:i A') }}
                  <div class="ui circular label" style="background-color: {{ $event->type->color }}; color: rgba(255, 255, 255, 0.8)">{{ $event->type->name }}</div>
                </div>
                <a href="{{ route('admin.events.show', $event) }}" target="_blank">{{ $event->show->name }}</a>
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
    </div>

    @if($sale->products->count() > 0)
    <div class="ui raised card">
      <div class="content">
        <div class="ui top attached black center aligned large label"><i class="box icon"></i> Extras</div>
        {{-- Products --}}
        <div class="ui divided list">
          @foreach ($sale->products->unique('id') as $product)
            <div class="item">
              <h3 class="ui header">
                <img src="{{ $product->cover == '/default.png' ? $product->cover : Storage::url($product->cover) }}">
                <div class="content">
                  <div class="sub header">
                    <div class="ui black label" style="margin-left:0">
                      <i class="box icon"></i>
                      {{ $sale->products->where('id', $product->id)->count() }}
                    </div>
                    <div class="ui black label" style="margin-left:0">
                      <i class="dollar icon"></i>
                      {{ number_format($product->price, 2, '.', '') }} each
                    </div>
                    <div class="ui circular blue label" style="margin-left:0">{{ $product->type->name }}</div>
                  </div>
                  <a href="{{ route('admin.products.edit', $product) }}" target="_blank">{{ $product->name }}</a>
                </div>
              </h3>
            </div>
          @endforeach
        </div>
      </div>
    </div>
    @endif


  </div>

{{-- Totals --}}

  <h4 class="ui horizontal divider center aligned header">
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
      <div class="value"><i class="dollar sign icon"></i> {{ $paid }}</div>
    </div>
    @if ($balance >= 0)
      <div class="green statistic">
        <div class="label">Balance</div>
        <div class="value">
          <i class="dollar sign icon"></i> {{ $balance }}
        </div>
      </div>
    @else
      <div class="red statistic">
        <div class="label">Balance</div>
        <div class="value">
          <i class="dollar sign icon"></i> {{ number_format(abs($balance), 2) }}
        </div>
      </div>
    @endif
  </div>

{{-- Payments --}}

  <h4 class="ui horizontal divider center aligned header">
    <i class="money icon"></i> Payments
  </h4>

  <table class="ui selectable single line table">
    <thead>
      <tr>
        <th>#</th>
        <th>Method</th>
        <th>Paid</th>
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
            <td>$ {{ number_format($payment->tendered - $payment->change_due, 2) }}</td>
            <td>$ {{ number_format($payment->tendered, 2) }}</td>
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
          <td colspan="6"><i class="info circle icon"></i> No payments have been received so far</td>
        </tr>
      @endif
    </tbody>
  </table>


{{-- Memo --}}
  <h4 class="ui horizontal divider center aligned header" id="memos">
    <i class="comment outline icon"></i> Memo
  </h4>

  @if ($memos->count() > 0)
  <div class="ui comments">
    @foreach($memos as $memo)
      <div class="comment">
        <div class="avatar"><i class="user circle big icon"></i></div>
        <div class="content">
          <div class="author">
            {{ $memo->author->fullname }}
            <div class="ui tiny black label">{{ $memo->author->role->name }}</div>
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
  @else
  <div class="ui info icon message">
    <i class="info circle icon"></i>
    <i class="close icon"></i>
    <div class="content">
      <div class="header">
        No Memos!
      </div>
      <p>This sale has no memos so far.</p>
    </div>
  </div>
  @endif

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

{{-- Email Confirmation Letter Modal --}}
<div class="ui fullscreen modal" id="email-confirmation-letter">
  <i class="close icon"></i>
  <div class="header">Confirmation Letter Preview</div>
  <div class="content">
    <div class="ui info icon message">
      <i class="info circle icon"></i>
      <i class="close icon"></i>
      <div class="content">
        <div class="header">
          Make sure there are no mistakes before sending!
        </div>
        <p>Triple check dates, times and amounts. If everything looks good, click on send.</p>
      </div>
    </div>
  </div>
  <div class="scrolling content">
    @include('partial.email._confirmation')
  </div>
  <div class="actions">
    <a href="{{ route('admin.sales.mail', $sale) . '?document=confirmation' }}" class="ui positive right labeled submit icon button">Looks good! Email it now! <i class="checkmark icon"></i></a>
    <a href="{{ route('admin.sales.edit', $sale) }}" class="ui yellow right labeled submit icon button">Let me change a few things... <i class="edit icon"></i></a>
    <div class="ui secondary deny right labeled submit icon button">Close Preview <i class="close icon"></i></div>
  </div>
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
