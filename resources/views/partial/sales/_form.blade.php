@isset($sale)
  @if ($sale->memos->count() > 0)
    {!! Session::flash('info', 'You are editing a sale. Don\'t forget to  <a href="#memo">write a memo</a> explaining why.') !!}
  @endif
@endisset
<form action="{{ isSet($sale) ? route('admin.sales.update', $sale) : route('admin.sales.store') }}" method="POST" class="ui form" id="sale">
@if (isSet($sale))
  {{ method_field('PUT') }}
@endif

  {{ csrf_field() }}


  <div class="ui grid">
    <div class="sixteen wide column" style="position:fixed;z-index:1; padding-bottom: 0">
        <div class="ui grid" style="background-color:white;">
          <div class="ui sixteen wide column">
            <div class="ui container">
              <div class="two fields" style="margin-bottom:0">

              <div class="field">
                <a onclick="window.history.back()" class="ui basic black button">
                  <i class="left chevron icon"></i>
                  Back
                </a>
                <div class="ui green labeled submit icon button">
                  Save <i class="save icon"></i>
                </div>
              </div>

              {{-- Sale Status --}}
              <div class="inline required field" style="text-align:right">
                <label for="status">Status</label>
                <div class="ui selection dropdown" id="sale-status">
                  <input type="hidden" id="status" name="status" value="{{ isSet($sale) ? $sale->status : old('status') == null ? 'open' : old('status') }}">
                  <i class="dropdown icon"></i>
                  <div class="default text">Sale Status</div>
                  <div class="menu">
                    <div class="item" data-value="open" style="background-color: #6435c9 !important; border-color: #6435c9; color: white">
                      <i class="unlock icon"></i>Open
                    </div>
                    <div class="item" data-value="confirmed" style="background-color: white !important; border-color: #21ba45; color: #21ba45">
                      <i class="thumbs up icon"></i>Confirmed
                    </div>
                    <div class="item" data-value="complete" style="background-color: #21ba45 !important; border-color: #21ba45; color: white">
                      <i class="checkmark icon"></i>Complete
                    </div>
                    @if (!Request::routeIs('*.*.create'))
                    <div class="item" data-value="canceled" style="background-color: #cf3534 !important; border-color: #cf3534; color: white">
                      <i class="remove icon"></i>Canceled
                    </div>
                    @endif
                    <div class="item" data-value="tentative" style="background-color: #fbbd08 !important; border-color: #fbbd08; color: white">
                      <i class="help icon"></i>Tentative
                    </div>
                    <div class="item" data-value="no show" style="background-color: #f2711c !important; border-color: #f2711c; color: white">
                      <i class="thumbs outline down icon"></i>No Show
                    </div>
                  </div>
                </div>
              </div>

            </div>
            </div>
          </div>
        </div>
    </div>
  </div>

  <div class="ui container">

    {{-- Error message from the client side form validation --}}
    <div class="field">

      <div class="ui error message"></div>

    </div>

    <div class="ui grid" style="margin-bottom:120px; margin-top:66px">

      <div class="ui sixteen wide column">
        {{-- Tabs --}}
        <div class="ui top attached tabular menu">
          <a class="active item" data-tab="sale-information"><i class="dollar icon"></i>Sale Information</a>
          <a class="item" data-tab="payment-information"><i class="money icon"></i>Payment Information</a>
        </div>
        {{-- Sale Information Tab --}}
        <div class="ui bottom attached active tab segment" data-tab="sale-information">

          {{-- Customer Information --}}

            {{-- Sell To --}}
            <div class="required field">
              <label for="sell_to_organization">Sell To</label>
              <select class="ui dropdown" name="sell_to_organization" id="sell_to_organization" value="1">
                <option value="0">Customer</option>
                <option value="1">Organization</option>
              </select>
            </div>
            {{-- Customer --}}
            <div class="required field">
              <label for="Customer">Customer</label>
              <div class="ui selection search scrolling dropdown" id="customers">
                <input type="hidden" id="customer_id" name="customer_id" value="1">
                <div class="default text">Select a Customer</div>
                <i class="dropdown icon"></i>
                <div class="menu" id="users">
                  <div class="item" data-value="1">Walk-up</div>
                </div>
              </div>
            </div>
            {{-- Grade --}}
            <div class="field">
              <label for="grades">Grade(s)</label>
              <select name="grades[]" multiple="" id="grades" class="ui dropdown">
                <option value="">N/A</option>
                @foreach ($grades as $grade)
                  <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                @endforeach
              </select>
            </div>

          {{-- Pre-existing events for edit view --}}
          @if (isSet($sale))
            @foreach($sale->events as $event)
              <div class="ui inverted segment">

                <h4 class="ui horizontal divider header"><i class="calendar check icon"></i> Event #{{ $loop->index + 1 }}</h4>

                {{-- Event Date --}}
                <div class="required field">
                  <div class="field">
                    <div class="required field">
                      <label for="start">Date</label>
                      <div class="ui left icon input">
                        {{-- dateFieldId --}}
                        <input value="{{ $event->start->format('l, F j, Y') }}" type="text" name="events[{{ $loop->index }}][date]" placeholder="Second Event Date" class="date" readonly="readonly" data-validate="date">
                        <i class="calendar alternate outline icon"></i>
                      </div>
                    </div>
                  </div>
                </div>

                {{-- Show --}}
                <div class="required field">
                  <label for="second_event_id">Show</label>
                  {{-- dropdownDivId --}}
                  <div class="ui search selection events dropdown" id="second-event">
                    <input type="hidden" name="events[{{ $loop->index }}][id]" value="{{ $event->id }}" class="show" data-validate="show">
                    <i class="dropdown icon"></i>
                    <div class="default text">Select a Show</div>
                    {{-- dropdownMenuId --}}
                    <div class="menu" id="second-show">
                      <div class="item" data-value="1">No Show</div>
                      @foreach ($events[$loop->index] as $e)
                        <div class="item" data-value="{{ $e->id }}">
                          <strong>{{ $e->show->name }}</strong>
                          at <em>{{ Date::parse($e->start)->format('g:i A') }}</em>
                          ({{ $e->seats - App\Ticket::where('event_id', $e->id)->count() }} seats left)
                        </div>
                      @endforeach
                    </div>
                  </div>
                </div>

                {{-- Tickets --}}
                <table class="ui selectable single line very compact table">
                    <thead>
                      <tr class="header">
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
                            <input type="text" name="events[{{ $loop->parent->index }}][tickets][{{ $loop->index }}][quantity]" value="{{ isSet($sale->tickets) ? $sale->tickets->where('event_id', $event->id)->where('ticket_type_id', $ticketType->id)->count() : old("events.{$event->id}.tickets.{$loop->index}.quantity") }}" size="1" class="ticket-amount">
                            <input type="hidden" name="events[{{ $loop->parent->index }}][tickets][{{ $loop->index }}][type_id]" value="{{ $ticketType->id }}">
                            <div class="ui basic label">$ <span class="ticket price">{{ number_format($ticketType->price, 2) }}</span> each</div>
                          </div>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>

              </div>
            @endforeach
          @else
            {{-- Event #1 --}}
            <div class="ui inverted segment">

              <h4 class="ui horizontal divider inverted header"><i class="calendar check icon"></i> Event #1</h4>

                {{-- First Event Date --}}
                <div class="required field">
                  <label for="event[0][date]">Date</label>
                  <div class="ui left icon input">
                    {{-- dateFieldId --}}
                    <input type="text" name="events[0][date]" placeholder="First Event Date and Time" class="date" data-validate="date" readonly="readonly" value="">
                    <i class="calendar alternate outline icon"></i>
                  </div>
                </div>

                {{-- First Show --}}
                <div class="required field">
                  <label for="first_event_id">Show</label>
                  {{-- dropdownDivId --}}
                  <div class="ui search selection events dropdown" id="first-event">
                    <input type="hidden" name="events[0][id]" value="1" class="show" data-validate="show">
                    <i class="dropdown icon"></i>
                    <div class="default text">Select a Show</div>
                    {{-- dropdownMenuId --}}
                    <div class="menu" id="first-show">
                      <div class="item" data-value="1">No Show</div>
                    </div>
                  </div>
                </div>

              {{-- Tickets --}}
              <table class="ui selectable single line very compact table" style="display:none">
                <thead>
                  <tr class="header">
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
                        <input type="text" name="events[0][tickets][{{ $loop->index }}][quantity]" value="0" size="1" class="ticket-amount">
                        <input type="hidden" name="events[0][tickets][{{ $loop->index }}][type_id]" value="{{ $ticketType->id }}">
                        <div class="ui basic label">$ <span class="ticket price">{{ number_format($ticketType->price, 2) }}</span> each</div>
                      </div>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>

            </div>
          @endif

          <div id="extra-events"></div>

          <br>

          <div class="ui black button" id="add-another-event">
            <i class="icons">
              <i class="calendar alternate icon"></i>
              <i class="inverted add corner icon"></i>
            </i>
            Add Another Event
          </div>

          {{-- Products --}}
          <div class="ui segment">

            <h4 class="ui horizontal divider header"><i class="box icon"></i> Products</h4>

            <table class="ui selectable single line very compact table">
              <thead>
                <tr class="header">
                  <th>Product</th>
                  <th>Amount / Price</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($products as $product)
                <tr>
                  <td>
                    <h4 class="ui header">
                      <img src="{{ $product->cover == '/default.png' ? $product->cover : Storage::url($product->cover) }}">
                      <div class="content">
                        {{ $product->name }}
                        <div class="ui tiny black label">{{ $product->type->name }}</div>
                        @if ($product->inventory)
                          <div class="ui {{ $product->stock < 10 ? 'red' : 'black' }} tiny label" {!! $product->stock < 10 ? "data-tooltip='Only $product->stock in stock!' data-inverted=''" : ""!!}>
                            <i class="box icon"></i>{{ $product->stock }}
                          </div>
                        @endif
                        <div class="sub header">{{ $product->description }}</div>
                      </div>
                    </h4>
                  </td>
                  <td>
                    <div class="ui right labeled input">
                      <input type="text" name="products[{{ $loop->index }}][quantity]" value="{{ isSet($sale->products) ? $sale->products->where('id', $product->id)->count() : (old("products.{$loop->index}.quantity") == null ? 0 : old("products.{$loop->index}.quantity")) }}" size="1" class="product-amount">
                      <input type="hidden" name="products[{{ $loop->index }}][id]" value="{{ $product->id }}">
                      <input type="hidden" name="products[{{ $loop->index }}][type_id]" value="{{ $product->type_id }}">
                      <div class="ui basic label">$ <span class="product price">{{ number_format($product->price, 2) }}</span> each</div>
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>

          </div>

        </div>
        {{-- Payment Information Tab --}}
        <div class="ui bottom attached tab segment" data-tab="payment-information">
          <div class="four fields">
            <div class="required field">
              <label for="taxable">Taxable</label>
              <select name="taxable" value="" class="ui taxable dropdown">
                <option value="0">No</option>
                <option value="1">Yes</option>
              </select>
            </div>
          </div>
          <div class="four fields">
            <div class="field">
              {!! Form::label('payment_method_id', 'Payment Method') !!}
              <div class="ui fluid selection dropdown">
                <input type="hidden" name="payment_method_id" value="{{ old('payment_method_id') }}">
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
              <label for="tendered">Tendered</label>
              <div class="ui labeled input">
                <div class="ui label">$ </div>
                <input type="text" name="tendered" value="{{ number_format(0, 2) }}" placeholder="Tendered">
              </div>
            </div>
            <div class="field">
              <label for="change_due">Change Due</label>
              <div class="ui labeled input">
                <div class="ui label">$ </div>
                <input type="text" name="change_due" value="{{ number_format(0, 2) }}" placeholder="Change due" readonly>
              </div>
            </div>
            <div class="field">
              <label for="reference">Reference</label>
              <input type="text" name="reference" placeholder="Credit Card or Check reference">
            </div>
          </div>
          {{-- Payment Table --}}
          <table class="ui selectable single line table">
          <thead>
            <tr class="payments">
              <th>#</th>
              <th>Method</th>
              <th>Amount Paid</th>
              <th>Date</th>
              <th>Cashier</th>
              @if (isSet($sale))
                @if (!$sale->refund)
                  @if ($sale->payments->count() > 1)
                    @if ($sale->payments->where('refunded', false)->where('total', '>', 0)->count() > 1)
                      @if ($sale->payments[0]->cashier_id == Auth::user()->id)
                      <th>Actions</th>
                      @endif
                    @endif
                  @endif
                @endif
              @endif
            </tr>
          </thead>
          <tbody>
            <tr class="warning center aligned payments">
              @if (isSet($sale))
                @if(count($sale->payments) > 0)
                  @foreach($sale->payments as $payment)
                    @if ($payment->total < 0)
                    <tr class="negative">
                    @else
                    <tr>
                    @endif
                      <td><div class="ui header">{{ $payment->id }}</div></td>
                      <td>{{ $payment->method->name }}</td>
                      <td>{{ number_format($payment->tendered, 2) }}</td>
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
              @else
                <tr class="warning center aligned">
                  <td colspan="5"><i class="info circle icon"></i> No payments have been received so far</td>
                </tr>
              @endif
            </tr>
          </tbody>
        </table>
        </div>
      </div>

      <div class="ui sixteen wide column">

        <h4 class="ui horizontal divider header"><i class="comments outline icon"></i> Memos</h4>

      </div>

      <div class="ui sixteen wide column">
        @if (isSet($sale->memos))
          @if ($sale->memos->count() > 0)
            <div class="ui comments">
            @foreach($sale->memos->sortByDesc('created_at') as $m)
              <div class="comment">
                <div class="avatar"><i class="user circle big icon"></i></div>
                <div class="content">
                  <div class="author">
                    {{ $m->author->fullname }}
                    <div class="metadata">
                      <span class="date">{{ Date::parse($m->created_at)->format('l, F j, Y \a\t g:i A') }}</span>
                    </div>
                  </div>
                  <div class="text">
                    {{ $m->message }}
                  </div>
                </div>
              </div>
            @endforeach
          </div>
          @else
            <div class="ui icon info message">
              <i class="info circle icon"></i>
              <div class="content">
                <div class="header">
                  No memos yet
                </div>
                <p>This sale doesn't have any memos yet.</p>
              </div>
            </div>
          @endif
        @else
          <div class="ui icon info message">
            <i class="info circle icon"></i>
            <div class="content">
              <div class="header">
                No memos yet
              </div>
              <p>This sale doesn't have any memos yet.</p>
            </div>
          </div>
        @endif
      </div>

      <div class="ui sixteen wide column">
        <div class="field">
          <label for="memo">Message</label>
          <textarea name="memo" rows="8" cols="3" placeholder="Write a memo here"></textarea>
        </div>
      </div>

    </div>

  </div>

  {{-- Totals --}}
  <div class="ui grid">

    <div class="sixteen wide column" style="padding: 0 0 0 0 !important">

      <div class="ui bottom fixed sticky" style="width:100%">

        <div class="ui inverted segment" style="border-radius: 0 !important">

          <div class="ui container">

            <div class="ui inverted form">

              <div class="five fields">

                {{-- Subtotal --}}
                <div class="field">
                  <label for="subtotal">Subtotal</label>
                  <div class="ui inverted transparent left icon input">
                    <i class="dollar icon"></i>
                    <input name="subtotal" type="text" id="subtotal" value="{{ isSet($sale) ? number_format($sale->subtotal, 2, '.', ',') : old('subtotal') }}" readonly size="1">
                  </div>
                </div>

                {{-- Tax --}}
                <div class="field">
                  <label for="tax">Tax ({{ App\Setting::find(1)->tax }}%)</label>
                  <div class="ui inverted transparent left icon input">
                    <i class="dollar icon"></i>
                    <input name="tax" type="text" id="tax" value="{{ isSet($sale) ? number_format($sale->tax, 2, '.', ',') : old('tax') != null ? old('tax') : 0 }}" readonly size="1">
                  </div>
                </div>

                {{-- Total --}}
                <div class="field">
                  <label for="total">Total</label>
                  <div class="ui inverted transparent left icon input">
                    <i class="dollar icon"></i>
                    <input name="total" type="text" id="total" value="{{ isSet($sale) ? number_format($sale->total, 2, '.', ',') : old('total') }}" readonly size="1">
                  </div>
                </div>

                {{-- Paid --}}
                <div class="field">
                  <label for="paid">Paid</label>
                  <div class="ui inverted transparent left icon input">
                    <i class="dollar icon"></i>
                    <input type="text" id="paid" value="{{ isSet($sale) ? number_format($sale->payments->sum('tendered'), 2, '.', ',') : number_format(0, 2) }}" readonly size="1">
                  </div>
                </div>

                {{-- Balance --}}
                <div class="field">
                  <label for="paid">Balance</label>
                  <div class="ui inverted transparent left icon input">
                    <i class="dollar icon"></i>
                    <input type="text" id="balance" value="{{ isSet($sale) ? number_format($sale->payments->sum('tendered') - $sale->total, 2, '.', ',') : number_format(0, 2) }}" readonly size="1">
                  </div>
                </div>

              </div>

            </div>

          </div>

        </div>

      </div>

    </div>
  </div>

</form>



<div class="ui basic modal" id="event-add-error">
  <div class="ui icon header">
    <i class="info circle icon"></i>
    Oops...
  </div>
  <div class="content">
    <p></p>
  </div>
  <div class="actions">
    <div class="ui red ok inverted button">
      <i class="checkmark icon"></i>
      Gotcha, I'll fix that!
    </div>
  </div>
</div>

<script>

  var index = {!! isSet($sale->events) ? $sale->events->count() - 1 : 0 !!}

  $('#add-another-event').click(function() {
    if ($($('.show')[index]).val() == '1') {
      $('#event-add-error .content').html(`
        <p>You need to select a show for <strong>Event #${index + 1}</strong>
        before you can add another events to this sale.</p>
        `)
      $('#event-add-error').modal('toggle')
    } else {
      {{-- Sentinel --}}
      index++
      {{-- Append another segment with event information --}}
      $('#extra-events').append(`
        {{-- Event #2 --}}
        <div class="ui inverted segment">

          <h4 class="ui horizontal divider header"><i class="calendar check icon"></i> Event #${index + 1}</h4>

            {{-- Second Event Date --}}
            <div class="required field">
              <div class="field">
                <div class="required field">
                  <label for="start">Date</label>
                  <div class="ui left icon input">
                    {{-- dateFieldId --}}
                    <input type="text" name="events[${index}][date]" placeholder="Second Event Date" class="date" readonly="readonly" data-validate="date">
                    <i class="calendar alternate outline icon"></i>
                  </div>
                </div>
              </div>
            </div>

            {{-- Second Show --}}
            <div class="required field">
              <label for="second_event_id">Show</label>
              {{-- dropdownDivId --}}
              <div class="ui search selection events dropdown" id="second-event">
                <input type="hidden" name="events[${index}][id]" value="1" class="show" data-validate="show">
                <i class="dropdown icon"></i>
                <div class="default text">Select a Show</div>
                {{-- dropdownMenuId --}}
                <div class="menu" id="second-show">
                  <div class="item" data-value="1">No Show</div>
                </div>
              </div>
            </div>



          {{-- Tickets --}}
          <table class="ui selectable single line very compact table" style="display:none">
              <thead>
                <tr class="header">
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
                      <input type="text" name="events[${index}][tickets][{{ $loop->index }}][quantity]" value="0" size="1" class="ticket-amount">
                      <input type="hidden" name="events[${index}][tickets][{{ $loop->index }}][type_id]" value="{{ $ticketType->id }}">
                      <div class="ui basic label">$ <span class="ticket price">{{ number_format($ticketType->price, 2) }}</span> each</div>
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>

        </div>
      `)
      {{-- Initialize show dropdown --}}
      $('.ui.dropdown').dropdown()
      {{-- Set default date for new date input --}}
      $($('input.date')[index]).flatpickr({dateFormat: 'l, F j, Y', defaultDate: 'today'})
      {{-- Fetch Events --}}
      $('input.date').change(function() {
        {{-- Get index of the event --}}
        var index = $('input.date').index(this)
        {{-- Getting this events' date field --}}
        var dateField = `[name="events[${index}][date]"]`
        {{-- Getting this events' show dropdown --}}
        var dropdownDiv = $('.ui.search.selection.events.dropdown')[index]
        {{-- Getting the menu of this events' show dropdown --}}
        var dropdownMenu = $('.ui.search.selection.events.dropdown .menu')[index]
        {{-- Fetch events of the selected event segment --}}
        fetchEvents(dateField, dropdownDiv, dropdownMenu, index)
      })

      $($('input.date')[index]).trigger('change')

      {{-- Toggle tickets table --}}
      $('.show').change(function() {
        {{-- Get current index of the show dropdown --}}
        var index = $('.show').index(this)
        {{-- Get the ticket table class for this events' tickets --}}
        var ticketsTableClass = '.ui.selectable.single.line.very.compact.table'
        $('.show')[index].value == 1 ? $($(ticketsTableClass)[index]).css('display', 'none') : $($(ticketsTableClass)[index]).css('display', 'table')
      })
      {{-- ...change amount of tickets --}}
      $('.ticket-amount').keyup(calculateTotals)
      {{-- ...change amount of products --}}
      $('.product-amount').keyup(calculateTotals)
      {{-- ...change taxable --}}
      $('[name="taxable"]').change(calculateTotals)
      {{-- ...change second event because it could be 1 (no show) --}}
      $('#second_event_id').change(calculateTotals)
      {{-- ...change tendered amount --}}
      $('[name="tendered"]').keyup(calculateTotals)
    }

  })

  //$('.ui.bottom.fixed.sticky').sticky()

  $('input.date').change(function() {
    {{-- Get index of the event --}}
    var index = $('input.date').index(this)
    {{-- Getting this events' date field --}}
    var dateField = `[name="events[${index}][date]"]`
    {{-- Getting this events' show dropdown --}}
    var dropdownDiv = $('.ui.search.selection.events.dropdown')[index]
    {{-- Getting the menu of this events' show dropdown --}}
    var dropdownMenu = $('.ui.search.selection.events.dropdown .menu')[index]
    {{-- Fetch events of the selected event segment --}}
    fetchEvents(dateField, dropdownDiv, dropdownMenu, index)
  })

  $('.show').change(function() {
    {{-- Get current index of the show dropdown --}}
    var index = $('.show').index(this)
    {{-- Get the ticket table class for this events' tickets --}}
    var ticketsTableClass = '.ui.selectable.single.line.very.compact.table'
    $('.show')[index].value == 1 ? $($(ticketsTableClass)[index]).css('display', 'none') : $($(ticketsTableClass)[index]).css('display', 'table')
  })

  {{-- Fetches events --}}
  async function fetchEvents(dateFieldId, dropdownDivId, dropdownMenuId, index) {
    var date = document.querySelector(dateFieldId).value
    var date = moment(date, 'dddd, MMMM D, YYYY h:mm A').format('Y-MM-DD')
    $(dropdownMenuId).empty()
    $(dropdownMenuId).append(`<div class="item" data-value="1">No Show</div>`)
    $(dropdownDivId).dropdown('set selected', 1)
    var response = await fetch(`/api/events?start=${date}&type={{ $eventType->id }}`)
    var events = await response.json()
    events.map((event, i) => {
      var date = moment(event.start, 'YYYY-MM-DD HH:mm:ss').format('h:mm A')
      $(dropdownMenuId)
        .append(`
          <div class="item" data-value="${event.id}">
            <strong>${event.show.name}</strong> at <em>${date}</em> (${event.seats} seats left)
          </div>
          `)
          $($('.ui.search.selection.events.dropdown')[index]).dropdown('set selected', event.id)
    })
  }

  $('.menu .item').tab({ history: true })

  {{-- Get Users for the user selecion dropdown --}}
  async function fetchUsers() {
    $('#users').empty()
    $("#users").append(`<div class="item" data-value="1">Walk-up</div>`)
    var response = await fetch('/api/customers')
    var customers = await response.json()
    customers.map((customer, index) => {
      $("#users")
        .append(`
          <div class="item" data-value="${customer.id}">
          <i class="user circle icon"></i>
            ${customer.name}
            (<em>${customer.role}</em>${customer.organization.id != 1 ? `, <strong>${customer.organization.name}</strong>` : ``})
          </div>
          `)
      //$('#taxable').dropdown('set selected', customer.taxable)
    })
  }

  $("#customer_id").change(function() {
    calculateTotals()
  })

  {{-- Calculating Totals --}}
  function calculateTotals() {

      var ticketAmounts = document.querySelectorAll('.ticket-amount')
      var ticketPrices = document.querySelectorAll('.ticket.price')
      var productAmounts = document.querySelectorAll('.product-amount')
      var productPrices = document.querySelectorAll('.product.price')
      var subtotalBox = document.querySelector('#subtotal')
      var subtotalArray = []
      var productSubtotalArray = []
      var subtotal = 0;
      var productSubtotal = 0;
      var taxBox = document.querySelector('#tax')
      @if (isSet($sale))
        var tax = {{ $sale->tax }}
      @else
        var tax = 0
      @endif
      var totalBox = document.querySelector('#total')
      var total = 0
      var taxable = document.querySelector('[name="taxable"]')
      var secondShow = document.querySelector('#second_event_id')
      var changeDue = 0
      var changeDueBox = document.querySelector('[name="change_due"]')
      var tenderedBox = document.querySelector('[name="tendered"]')
      var tendered = parseFloat(tenderedBox.value.replace(",", ""))

      @if (isSet($sale))
        var paid = {{ number_format($sale->payments->sum('tendered'), 2) }}
      @else
        var paid = 0
      @endif

      var paidBox = document.querySelector('#paid')
      var balance = 0
      var balanceBox = document.querySelector('#balance')

      @if (isset($sale)) {{-- If the sale exists in the database --}}
        @if ($sale->events->count() > 0) {{-- If the sale has events --}}
        ticketAmounts.forEach(function(item, index) {
          {{-- Multiply the number of tickets by the price and adding them to a subtotal array --}}
          subtotalArray[index] = ticketAmounts[index].value * parseFloat((ticketPrices[index].innerHTML).replace(",", ""))
        })
        @else {{-- If the sale does not have events --}}
        subtotalArray = [0];
        @endif
      @else {{-- If the sale is new --}}
      ticketAmounts.forEach(function(item, index) {
        {{-- Multiply the number of tickets by the price and adding them to a subtotal array --}}
        subtotalArray[index] = ticketAmounts[index].value * parseFloat((ticketPrices[index].innerHTML).replace(",", ""))
      })
      @endif

      productAmounts.forEach(function(item, index) {
        {{-- Multiply the number of desired products by their price --}}
        productSubtotalArray[index] = productAmounts[index].value * parseFloat((productPrices[index].innerHTML).replace(",", ""))
      })

      subtotal = subtotalArray.reduce(function(accumulator, currentValue) {
        return accumulator + currentValue
      })

      productSubtotal = productSubtotalArray.reduce(function(accumulator, currentValue) {
        return accumulator + currentValue
      })

      //subtotal = secondShow.value == "1" ? subtotal : subtotal * 2

      subtotalBox.value = (parseFloat(subtotal.toFixed(2)) + parseFloat(productSubtotal)).toLocaleString("en-US", {minimumFractionDigits: 2})


      tax = taxable.value == "1" ? (subtotal + productSubtotal) * ({{ App\Setting::find(1)->tax }} / 100) : 0

      tax = Number(Math.round(tax+'e2')+'e-2')

      taxBox.value = parseFloat(tax.toFixed(2)).toLocaleString("en-US", {minimumFractionDigits: 2})
      total = subtotal + tax + productSubtotal
      totalBox.value = total.toLocaleString("en-US", {minimumFractionDigits: 2})

      balance = total - (parseFloat(paidBox.value) + tendered)
      balanceBox.value = (balance <= 0 || isNaN(balance)) ? parseFloat(0).toLocaleString("en-US", {minimumFractionDigits: 2}) : balance.toLocaleString("en-US", {minimumFractionDigits: 2})
      {{-- Get rid of NaN in the balance textbox if user deletes numbers form it --}}

      changeDue = tendered - (total - parseFloat(paidBox.value))
      changeDueBox.value = changeDue <= 0 ? (0).toLocaleString("en-US", {minimumFractionDigits: 2}) : changeDue.toLocaleString("en-US", {minimumFractionDigits: 2})

    }

  {{-- Sale Status Color --}}
  function changeSaleStatusColor() {
      $('#sale-status').css('color', 'white')
      switch(document.querySelector('#status').value) {
        case 'open'      : $('#sale-status').css('background-color', '#6435c9').css('border-color', '#6435c9'); break;
        case 'complete' : $('#sale-status').css('background-color', '#21ba45').css('border-color', '#21ba45'); break;
        case 'canceled' : $('#sale-status').css('background-color', '#cf3534').css('border-color', '#cf3534'); break;
        case 'no show' : $('#sale-status').css('background-color', '#f2711c').css('border-color', '#f2711c'); break;
        case 'tentative' : $('#sale-status').css('background-color', '#fbbd08').css('border-color', '#fbbd08'); break;
        case 'confirmed' : $('#sale-status').css('background-color', 'white').css('color', '#21ba45').css('border-color', '#21ba45'); break;
        default: $('#sale-status').css('background-color', 'white').css('color', 'black');
      }
    }

  $(document).ready(function() {
    changeSaleStatusColor()
    calculateTotals()
    fetchUsers()
    @if (isSet($sale->events))
      $('[name="taxable"]').dropdown('set selected', {{ (int)$sale->taxable }})
      @foreach ($sale->events as $event)
      $($('input.date')[{{ $loop->index }}]).flatpickr({dateFormat: 'l, F j, Y'})
      @endforeach
    @else
      $('input.date').flatpickr({dateFormat: 'l, F j, Y', defaultDate: 'today' })
      //$('input.date').trigger('change')
    @endif
    {{-- Forcing change on date field so that new events can be fetched from the server --}}
    //$('.date').trigger('change')
    setTimeout(function() {
      $("#sell_to_organization").dropdown('set selected', "{{ isSet($sale) ? $sale->sell_to_organization : old('sell_to_organization') }}")
      {{-- Set default events --}}
      @if (isSet($sale))
        $("#customers").dropdown('set selected', {{ $sale->customer_id }})
        $("#sale-status").dropdown('set selected', '{{ $sale->status }}')
      @else
        $("#customers").dropdown('set selected', {{ old('customer_id') }})
      @endif
    }, 600)
  })



  {{-- Change Sale Status color whenever the sale status changes --}}
  $('#status').change(changeSaleStatusColor)

  {{-- Recalculate totals every time we... --}}

  {{-- ...change amount of tickets --}}
  $('.ticket-amount').keyup(calculateTotals)
  {{-- ...change amount of products --}}
  $('.product-amount').keyup(calculateTotals)
  {{-- ...change taxable --}}
  $('[name="taxable"]').change(calculateTotals)
  {{-- ...change second event because it could be 1 (no show) --}}
  $('#second_event_id').change(calculateTotals)
  {{-- ...change tendered amount --}}
  $('[name="tendered"]').keyup(calculateTotals)

  {{-- Client Side Validation --}}

  $('form').form({
    inline: true,
    on    : 'blur',
    fields: {
      {{-- Sell To Organization Validation --}}
      sell_to_organization: {
        rules: [
          { type  : 'integer', prompt: 'Are you selling to an organization or individual?' },
          { type  : 'empty', prompt: 'Are you selling to an organization or individual?' }
        ]
      },
      {{-- Customer ID validation --}}
      customer_id : {
        rules: [{
          type  : 'notExactly[1]',
          @if (isset($sale))
          prompt: 'Walk-up sales are only allowed in cashier. The current customer for this sale is {{ $sale->customer->fullname }}.'
          @else
          prompt: 'Walk-up sales are only allowed in cashier.'
          @endif 
        }]
      },
      {{-- Taxable Validation --}}
      taxable: {
        rules: [{ type  : 'empty', prompt: 'Is this sale taxable?' }]
      },

      {{-- Tendered Validation --}}
      tendered: {
        rules: [
          { type  : 'number', prompt: 'Make sure you only enter numbers' },
          { type  : 'empty',  prompt: 'Make sure you enter a value'      },
        ]
      },
      @isset($sale)
      {{-- Memo Validation --}}
      memo: {
        rules: [{ type  : 'empty', prompt: 'Why are you changing this sale?' }]
      },
      @endisset
    }
  })

  @isset($sale)

    @if ($sale->grades->count() > 0)

      @foreach ($sale->grades as $g)
        $('#grades').dropdown('set selected', {{ $g->id }})
      @endforeach

    @endif

  @endisset

  $('[name="payment_method_id"]').change(function() {
    this.value != 1 ? $('form').form('add rule', 'reference', ['empty']) : $('form').form('remove fields', ['reference'])
  })

  $('[name="tendered"]').change(function() {
    if (this.value > 0)
      $('form').form('add rule', 'payment_method_id', ['empty', 'number'])
    else
      $('form').form('remove fields', ['payment_method_id'])
  })

  $('.ui.taxable.dropdown').dropdown('set selected', '{{ isSet($sale) ? $sale->taxable : old('taxable') }}')

</script>

<style>
  input#subtotal, input#tax, input#total, input#paid, input#balance {font-weight: bold !important; color: #FFF}
</style>
