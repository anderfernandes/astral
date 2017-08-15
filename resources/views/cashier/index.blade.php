@extends('layout.cashier')

@section('title', 'Cashier')

@section('icon', 'dollar')

@section('name', 'Cashier | '.Auth::user()->firstname.' '.Auth::user()->lastname)

@section('content')

<div class="ui grid">

  <div class="sixteen wide mobile eleven wide computer column">

  @if (count($events) > 0)
    @foreach($events as $event)
      <div class="ui unstackable divided items">
        <div class="item">
          <div class="ui small image">
            <img src="https://semantic-ui.com/images/wireframe/square-image.png">
          </div>
          <div class="content">
            <div class="meta">
              <span class="ui label" id="showtype">{{ $event->type }}</span>
              <span class="ui label">{{ $event->show->type }}</span>
              <span class="ui label">{{ $event->show->duration }} minutes</span>
            </div>
            <div class="ui header">
              {{ $event->show->name }}
              <div class="sub header">
                <i class="calendar icon"></i>
                {{ Date::parse($event->start)->format('l, F j, Y \a\t g:i A') }} |
                <i class="ticket icon"></i>
                {{ $event->seats - App\Ticket::where('event_id', '=', $event->id)->count() }} seats left
              </div>
            </div>
            <div class="meta">

            </div>
            <div class="description">
              <div class="ui form">
                <div class="three fields">
                  <div class="field">
                    <div class="ui right labeled left action small input">
                      <button onclick="changeAmount({{ $loop->index }}*3+0, 1, 'adult', {{ $event->show_id }}, '{{ $event->show->name }}', '{{ $event->type }}', {{ number_format($event->adults_price, 2) }}, {{ $event->id }})" class="ui icon button plus"><i class="plus icon"></i></button>
                      <button onclick="changeAmount({{ $loop->index }}*3+0,-1, 'adult', {{ $event->show_id }}, '{{ $event->show->name }}', '{{ $event->type }}', {{ number_format($event->adults_price, 2) }}, {{ $event->id }})" class="ui icon button"><i class="minus icon"></i></button>
                      <input class="number-of-tickets" readonly min="0" value="0" value="0" type="text" placeholder="0">
                      <div class="ui price label">at $ {{ number_format($event->adults_price, 2) }} / adult</div>
                    </div>
                  </div>
                  <div class="field">
                    <div class="ui right labeled left action small input">
                      <button onclick="changeAmount({{ $loop->index }}*3+1, 1, 'children', {{ $event->show_id }}, '{{ $event->show->name }}', '{{ $event->type }}', {{ number_format($event->children_price, 2) }}, {{ $event->id }})" class="ui icon button"><i class="plus icon"></i></button>
                      <button onclick="changeAmount({{ $loop->index }}*3+1,-1, 'children', {{ $event->show_id }}, '{{ $event->show->name }}', '{{ $event->type }}', {{ number_format($event->children_price, 2) }}, {{ $event->id }})" class="ui icon button"><i class="minus icon"></i></button>
                      <input class="number-of-tickets" readonly min="0" value="0" type="text" placeholder="0">
                      <div class="ui price label">at $ {{ number_format($event->children_price, 2) }} / child</div>
                    </div>
                  </div>
                  <div class="field">
                    <div class="ui right labeled left action small input">
                      <button onclick="changeAmount({{ $loop->index }}*3+2, 1, 'member', {{ $event->show_id }}, '{{ $event->show->name }}', '{{ $event->type }}', {{ number_format($event->member_price, 2) }}, {{ $event->id }})" class="ui icon button"><i class="plus icon"></i></button>
                      <button onclick="changeAmount({{ $loop->index }}*3+2,-1, 'member', {{ $event->show_id }}, '{{ $event->show->name }}', '{{ $event->type }}', {{ number_format($event->member_price, 2) }}, {{ $event->id }})" class="ui icon button"><i class="minus icon"></i></button>
                      <input class="number-of-tickets" readonly min="0" value="0" type="text" placeholder="0">
                      <div class="ui price label">at $ {{ number_format($event->member_price, 2) }} / member</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="extra">
              Created by {{ $event->creator->firstname }} {{ $event->creator->lastname }} on {{ Date::parse($event->created_at)->format('l, F j, Y \a\t g:i A') }}
            </div>
          </div>
        </div>
      </div>
    @endforeach
  @else
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
  @endif

  </div>

  <div class="sixteen wide mobile five wide computer column">
    {!! Form::open(['route' => 'cashier.store', 'class' => 'ui form', 'id' => 'cashier']) !!}
    <div class="ui two buttons">
      {!! Form::button('<i class="check icon"></i> Confirm', ['type' => 'submit', 'class' => 'ui green button', 'id' => 'submit-sale']) !!}
      <a href="{{ route('cashier.index') }}" class="ui large negative button"><i class="remove icon"></i>Cancel</a>
      <input type="hidden" name="subtotal" value="0">
      <input type="hidden" name="total" value="0">
    </div>

    <div class="ui segments">
      <div class="ui attached segment">
        <div class="ui form">
          <div class="field">
            {!! Form::label('tendered', 'Tendered') !!}
            <div class="ui massive labeled input">
              <div class="ui label">$</div>
              {!! Form::text('tendered', 0.00, ['placeholder' => 'Tendered', 'id' => 'tendered']) !!}
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
          <div class="sub header">Change Due</div>
          <span id="dollar-sign">$</span> <span id="change-due">0.00</span>
        </h4>
      </div>
      <div class="ui attached clearing segment">
        <h1 class="ui right floated header">
          <div class="sub header">Total</div>
          $ <span id="total">0.00</span>
        </h1>
      </div>
      <div class="ui attached segment">
        <div class="ui form">
          <div class="two fields">
            <div class="field">
              {!! Form::label('Payment Method') !!}
              <div class="ui selection dropdown">
                <input type="hidden" name="payment_method">
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
              {!! Form::label('reference', 'Reference') !!}
              {!! Form::text('reference', null, ['placeholder' => 'Last 4 for cards or check #. Leave blank for cash']) !!}
            </div>
          </div>
        </div>
        {!! Form::close() !!}
      </div>
      <div class="ui attached segment" id="tickets"></div>
    </div>
  </div>
</div>

<script>

  // Payment method and Reference Validation


  // Make sure users enter reference for Credit Card and Checks
  $('#submit-sale').click(function() {
    var payment_method = document.querySelector('input[name="payment_method"]').value;

    if ( payment_method != 'cash' || payment_method == '') {
      $('#cashier.ui.form')
        .form({
          fields: {
            payment_method : 'empty',
            reference      : 'empty',
            tendered       : ['is[' + document.querySelector("#total").innerHTML + ']', 'empty'],
          }
      });
    } else {
      $('#cashier.ui.form')
        .form({
          fields: {
            payment_method : 'empty',
            //tendered       : ['is[' + document.querySelector("#total").innerHTML + ']', 'empty'],
          }
      });
      $('form#cashier.ui.form').removeClass('error');
      $('.field.error').removeClass('error');
    }
  });



  var ticketId = 0;

  $('input#tendered').keyup(function(){
    var tendered = parseFloat(document.getElementById('tendered').value).toFixed(2);
    var total = parseFloat(document.getElementById('total').innerHTML).toFixed(2);
    var changeDue = parseFloat(tendered - total).toFixed(2);
    document.getElementById('change-due').innerHTML = changeDue.fontcolor((changeDue < 0 ? '#cf3534':'black'));
    changeDue < 0 ? $('#dollar-sign').css('color', '#cf3534') : $('#dollar-sign').css('color', 'black');
  });

  function changeAmount(number, operator, type, show_id, show, event_type, price, event_id) {
    var currentTicketId = ticketId++;
    var sum = 0;
    var inputs = document.querySelectorAll(".number-of-tickets");
    var divs = document.querySelectorAll(".ui.price.label");
    inputs[number].value = parseInt(inputs[number].value) + parseInt(operator);
    if (parseInt(inputs[number].value) < 0)
      inputs[number].value = 0;
      // There is an extra input type text for the field reference. Count that one out
    for(i = 0; i < inputs.length; i++)
    {
      // This reads the text of the label beside each amount input field. Careful!!!
      sum += parseInt(inputs[i].value) * parseFloat(divs[i].innerHTML.split(" ")[2]).toFixed(2);
    }
    var subtotal = sum.toFixed(2);
    var tax = (sum * ({{ App\Setting::find(1)->tax }}/100)).toFixed(2);
    var total = (parseFloat(subtotal) + parseFloat(tax)).toFixed(2);

    // Display the totals
    document.querySelector('#subtotal').innerHTML = subtotal;
    document.querySelector('#tax').innerHTML = tax;
    document.querySelector('#total').innerHTML = total;

    // Set subtotal and total in the hidden input to send to the server
    document.querySelector('input[name="subtotal"]').value = subtotal;
    document.querySelector('input[name="total"]').value = total;

    if (show)
      var showTrimmed = show.replace(/\s+/g, "").replace(":", "");

    if (event_type)
      var event_typeTrimmed = event_type.replace(/\s+/g, "").replace(":", "");

    if(operator == 1) {
      $('#tickets').append('<h4 class="ui header '+ type + showTrimmed + event_typeTrimmed + price +'"><i class="ticket icon"></i><div class="content" style="width:100%">'+ type +' | ' + event_type +' <span style="float:right">$ '+ price.toFixed(2) + '</span><div class="sub header">'+ show +'</div></div></h4>');
      $('form.ui.form').append('<input class="'+ type + showTrimmed + event_typeTrimmed + price +'" type="hidden" name="ticket['+ currentTicketId +'][type]" value="'+ type +'">');
      $('form.ui.form').append('<input class="'+ type + showTrimmed + event_typeTrimmed + price +'" type="hidden" name="ticket['+ currentTicketId +'][price]" value="'+ price +'">');
      $('form.ui.form').append('<input class="'+ type + showTrimmed + event_typeTrimmed + price +'" type="hidden" name="ticket['+ currentTicketId +'][event_id]" value="'+ event_id +'">');
      $('form.ui.form').append('<input class="'+ type + showTrimmed + event_typeTrimmed + price +'" type="hidden" name="ticket['+ currentTicketId +'][cashier_id]" value="{{ Auth::user()->id }}">');
      $('form.ui.form').append('<input class="'+ type + showTrimmed + event_typeTrimmed + price +'" type="hidden" name="ticket['+ currentTicketId +'][customer_id]" value="999">');
    }
    else {
      $('#tickets h4.ui.header.'+ type + showTrimmed + event_typeTrimmed + price + '').first().remove();
      $('form.ui.form input.'+ type + showTrimmed + event_typeTrimmed + price +'').first().remove();
      $('form.ui.form input.'+ type + showTrimmed + event_typeTrimmed + price +'').first().remove();
      $('form.ui.form input.'+ type + showTrimmed + event_typeTrimmed + price +'').first().remove();
      $('form.ui.form input.'+ type + showTrimmed + event_typeTrimmed + price +'').first().remove();
      $('form.ui.form input.'+ type + showTrimmed + event_typeTrimmed + price +'').first().remove();
    }

  }
</script>

@endsection
