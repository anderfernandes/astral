@extends('layout.cashier')

@section('title', 'Cashier')

@section('icon', 'inbox')

@section('name', 'Cashier')

@section('content')

  <div class="ui grid">

  @if (!isset($events) || count($events) > 0)

    <div class="sixteen wide mobile eleven wide computer column">

      <div class="ui doubling grid">
        @foreach($events as $event)
          <div class="ui eight wide column">
            <div class="ui unstackable items">
              <div class="item">
                <div class="ui tiny rounded image">
                  <img src={{ $event->show->cover }} />
                </div>
                <div class="content">
                  <div class="header">
                    {{ $event->show->name }}
                  </div>
                  <div class="meta">
                    <div class="ui label">{{ $event->show->type }}</div>
                    <div class="ui label">{{ $event->type->name }}</div>
                  </div>
                  <div class="meta">
                    {{ Date::parse($event->start)->isToday() ? 'Today ' . Date::parse($event->start)->format('\a\t g:i A') : Date::parse($event->start)->format('l, F j, Y \a\t g:i A') }} |
                    {{ $event->seats - App\Ticket::where('event_id', '=', $event->id)->count() }} seats left
                  </div>
                  <div class="extra content">
                    @foreach ($event->type->allowedTickets as $ticket)
                      <div class="ui buttons">
                        <div class="ui inverted green button" onclick="changeAmount(1, `{{ $ticket->name }}`, {{ $event->show_id }}, `{{ $event->show->name }}`, '{{ $event->type->name }}', {{ number_format($ticket->price, 2) }}, {{ $event->id }}, {{ $ticket->pivot->ticket_type_id }}, '{{ $event->show->type }}')">
                          {{ $ticket->name }}
                        </div>
                        <div class="ui inverted red icon button" onclick="changeAmount(-1, `{{ $ticket->name }}`, {{ $event->show_id }}, `{{ $event->show->name }}`, '{{ $event->type->name }}', {{ number_format($ticket->price, 2) }}, {{ $event->id }}, {{ $ticket->pivot->ticket_type_id }}, '{{ $event->show->type }}')">
                          <i class="minus icon"></i>
                        </div>
                      </div>
                    @endforeach
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>

    <div class="sixteen wide mobile five wide computer column">
      {!! Form::open(['route' => 'cashier.store', 'class' => 'ui form', 'id' => 'cashier']) !!}
      <div class="ui segments" style="margin-top:0">
        <div class="ui attached segment">
          <div class="ui form">
            <div class="field">
              {!! Form::label('customer_id', 'Customer') !!}
              {!! Form::select('customer_id', $customers, 1, ['placeholder' => 'Taxable?', 'class' => 'ui search selection dropdown']) !!}
            </div>
          </div>
        </div>
        <div class="ui attached segment">
          <div class="ui form">
            <div class="field" id="tendered-input">
              {!! Form::label('tendered', 'Tendered') !!}
              <div class="ui huge labeled input">
                <div class="ui label">$</div>
                {!! Form::text('tendered', number_format(0, 2), ['placeholder' => 'Tendered', 'id' => 'tendered', 'autofocus' => true, 'size' => 1, 'disabled' => true]) !!}
              </div>
            </div>
          </div>
        </div>
        <div class="ui attached clearing segment">
          <h4 class="ui right floated header">
            Subtotal = $ <span id="subtotal">0.00</span>
            <div class="sub header">{{ App\Setting::find(1)->tax }}% Tax = $ <span id="tax">0.00</span></div>
          </h4>
          <h4 class="ui left floated header">
            <div class="sub header">Change</div>
            <span id="dollar-sign">$</span> <span id="change-due">0.00</span>
          </h4>
        </div>
        <div class="ui attached clearing segment">
          <div class="ui large two buttons">
            <a href="{{ route('cashier.index') }}" id="cancel" class="ui negative button"><i class="remove icon"></i>Cancel</a>
            {!! Form::button('<i class="check icon"></i>Charge $ <span id="total">0.00</span>', ['type' => 'submit', 'class' => 'ui green button', 'id' => 'submit-sale', 'disabled' => true]) !!}
            <input type="hidden" name="subtotal" value="0">
            <input type="hidden" name="total" value="0">
          </div>
        </div>
        <div class="ui attached segment">
          <div class="ui form">
            <div class="two fields">
            <div class="field">
              {!! Form::label('Payment Method') !!}
              <div class="ui selection dropdown">
                <input type="hidden" name="payment_method" value="1" id="payment_method">
                <i class="dropdown icon"></i>
                <div class="default text">Payment Method</div>
                <div class="menu">
                  @foreach ($paymentMethods as $paymentMethod)
                    <div class="item" data-value="{{ $paymentMethod->id}}"><i class="{{ $paymentMethod->icon }} icon"></i>{{ $paymentMethod->name }}</div>
                  @endforeach
                </div>
              </div>
            </div>
            <div class="field" id="reference-input">
              {!! Form::label('reference', 'Reference') !!}
              {!! Form::text('reference', null, ['placeholder' => 'Card or Check reference']) !!}
            </div>
            </div>
          </div>
          {!! Form::close() !!}
        </div>
        <div class="ui attached segment" id="tickets"></div>
      </div>
    </div>

    <script>

    // Payment method and Reference Validation


    // Make sure users enter reference for Credit Card and Checks
    $('#submit-sale').click(function(event) {
      var payment_method = document.querySelector('input[name="payment_method"]').value;
      var reference = document.querySelector('input[name="reference"]').value;
      var total = parseFloat(document.querySelector("#total").innerHTML).toFixed(2);
      var tendered = parseFloat(document.querySelector('input#tendered').value);
      // Returns true if tendered is less than total
      var checkCashSale = (tendered < total) ? true : false;

      // Non-cash payments must have a reference and a tendered greater than total
      if (payment_method != 1) {
        if (reference == '') {
          event.preventDefault()
          $('.field#reference-input').addClass('error')
        } else if (tendered < total || tendered == '') {
          event.preventDefault()
          $('.field#tendered-input').addClass('error')
        }
        else {
          $('form#cashier.ui.form').removeClass('error')
          $('.field.error').removeClass('error')
          $('#submit-sale').attr('disabled', true)
          $('#submit-sale').addClass('loading')
          $('#cancel').addClass('loading')
          $('#cancel').attr('disabled', true)
          $('#cashier').submit()
        }
      } else {
        if (tendered < total) {
          event.preventDefault();
          $('.field#tendered-input').addClass('error');
        }
        else {
          $('form#cashier.ui.form').removeClass('error')
          $('.field.error').removeClass('error')
          $('#submit-sale').attr('disabled', true)
          $('#submit-sale').addClass('loading')
          $('#cancel').addClass('loading')
          $('#cancel').attr('disabled', true)
          $('#cashier').submit()
        }

      }
    });

    function setTenderedOnNonCashPayments() {
      var payment_method = document.querySelector('input[name="payment_method"]').value
      var total = parseFloat(document.querySelector("#total").innerHTML).toFixed(2);
      if (payment_method != 1)
        document.querySelector('input#tendered').value = total
      else
        document.querySelector('input#tendered').value = parseFloat(0).toFixed(2)
    }

    $('#payment_method').change(setTenderedOnNonCashPayments)

    var ticketId = 0;
    var sum = 0;
    var ticketsArray = [];

    $('input#tendered').keyup(function(){
       var tendered = 0;
      // Make sure NaN isn't shown when there's nothing in the tendered input
      document.getElementById('tendered').value == "" ? tendered = 0 : tendered = parseFloat(document.getElementById('tendered').value).toFixed(2);

      var total = parseFloat(document.getElementById('total').innerHTML).toFixed(2);
      var changeDue = parseFloat(tendered - total).toFixed(2);
      document.getElementById('change-due').innerHTML = changeDue.fontcolor((changeDue < 0 ? '#cf3534':'black'));
      changeDue < 0 ? $('#dollar-sign').css('color', '#cf3534') : $('#dollar-sign').css('color', 'black');
    });

    function changeAmount(operator, type, show_id, show, event_type, price, event_id, ticket_type_id, show_type) {
      var currentTicketId = (operator == 1) ? ticketId++ : ticketId--

      //sum = (operator == 1) ? sum + price : sum = (sum <= 0) ? sum = 0 : sum - price;

      //sum = (operator == 1 ) ? sum.concat([ticket_type_id, event_id, price ])

      if (operator == 1) {
        // If we are adding tickets, attach some information on it to an array containing all tickets
        ticketsArray.push({ticketType: type, eventId: event_id, price: price})

      }
      else {
        // If not, remove only the right ticket
        var index = ticketsArray.findIndex(x => x.ticketType == type && x.eventId == event_id && x.price == price)
        if (index !== -1) {
          ticketsArray.splice(index, 1)
        } else {
          ticketsArray = ticketsArray
        }
      }

      ticketsArray.length > 0 ? $('#submit-sale').attr('disabled', false) : $('#submit-sale').attr('disabled', true)

      // sum = ticketsArray.map(item => item.price).reduce((prev, next) => { prev + next})

      sum = ticketsArray.length > 0 ? ticketsArray.map(item => item.price).reduce((prev, next) => prev + next ) : 0

      var tendered = parseFloat(document.getElementById('tendered').value).toFixed(2);
      var subtotal = sum.toFixed(2);
      var tax = (sum * ({{ App\Setting::find(1)->tax }}/100)).toFixed(2);
      var total = (parseFloat(subtotal) + parseFloat(tax)).toFixed(2);
      var changeDue = parseFloat(tendered - total).toFixed(2);
      changeDue < 0 ? $('#dollar-sign, #change-due').css('color', '#cf3534') : $('#dollar-sign, #change-due').css('color', 'black');

      // Display the totals
      document.querySelector('#subtotal').innerHTML = subtotal;
      document.querySelector('#tax').innerHTML = tax;
      document.querySelector('#total').innerHTML = total;

      document.querySelector('#change-due').innerHTML = changeDue;

      // Set subtotal and total in the hidden input to send to the server
      document.querySelector('input[name="subtotal"]').value = subtotal;
      document.querySelector('input[name="total"]').value = total;

      parseInt(document.querySelector("#total").innerHTML) <= 0 ? $('#tendered').attr('disabled', true) : $('#tendered').attr('disabled', false)

      if (show)
        var showTrimmed = show.replace(/\s+/g, "").replace(":", "").replace("\'", "");

      if (event_type)
        var event_typeTrimmed = event_type.replace(/\s+/g, "").replace(":", "").replace("\'", "");

      if (type)
        var typeTrimmed = type.replace(/\s+/g, "").replace(":", "").replace("\'", "");

      if(operator == 1) {
        $('#tickets').append(
          '<h5 class="ui header '+ typeTrimmed + showTrimmed + event_typeTrimmed + price +'">' +
            '<i class="ticket icon"></i>' +
              '<div class="content" style="width:100%">'+
              '<div class="ui mini label" style="margin-left:0">' + show_type +'</div>'+
              '<div class="ui mini label">' + event_type +'</div>'+
              '<div class="ui mini label">'+ type +'</div>'+
              '<span style="float:right">$ '+ price.toFixed(2) + '</span>'+
              '<div class="sub header">'+ show +'</div>'+
              '</div>'+
            '</h5>'
        );

        $('form.ui.form#cashier').append('<input class="'+ type + showTrimmed + event_typeTrimmed + price +'" type="hidden" name="ticket['+ currentTicketId +'][ticket_type_id]" value="'+ ticket_type_id +'">');
        $('form.ui.form#cashier').append('<input class="'+ type + showTrimmed + event_typeTrimmed + price +'" type="hidden" name="ticket['+ currentTicketId +'][event_id]" value="'+ event_id +'">');
        $('form.ui.form#cashier').append('<input class="'+ type + showTrimmed + event_typeTrimmed + price +'" type="hidden" name="ticket['+ currentTicketId +'][cashier_id]" value="{{ Auth::user()->id }}">');
      }
      if (operator == -1) {
        $('#tickets h5.ui.header.'+ typeTrimmed + showTrimmed + event_typeTrimmed + price + '').first().remove();
        $('form.ui.form#cashier input.'+ typeTrimmed + showTrimmed + event_typeTrimmed + price +'').first().remove();
        $('form.ui.form#cashier input.'+ typeTrimmed + showTrimmed + event_typeTrimmed + price +'').first().remove();
        $('form.ui.form#cashier input.'+ typeTrimmed + showTrimmed + event_typeTrimmed + price +'').first().remove();
      }

    }

    function showSpinner() {
      $('[type="submit"]').click(function() {
        $('.ui.button').addClass('loading')
        $('button.ui.button').attr('disabled', true)
        $('a.ui.button').addClass('disabled')
        //this.form.submit()
      })
    }
    </script>
  @else
    <div class="sixteen wide column">
      <div class="ui info icon message">
        <i class="info circle icon"></i>
        <i class="close icon"></i>
        <div class="content">
          <div class="header">
            No shows!
          </div>
          <p>It looks like there are no shows going on today.</p>
        </div>
      </div>
    </div>
  @endif

@endsection
