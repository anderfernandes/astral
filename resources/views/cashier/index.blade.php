@extends('layout.cashier')

@section('title', 'Cashier')

@section('icon', 'dollar')

@section('name', 'Cashier | '.$user->firstname.' '.$user->lastname)

@section('content')

<div class="ui grid">

  <div class="sixteen wide mobile eleven wide computer column">

  @if (count($events) > 0)
    @foreach($events as $event)
      <div class="ui unstackable items">
        <div class="item">
          <div class="ui small image">
            <img src="https://semantic-ui.com/images/wireframe/square-image.png">
          </div>
          <div class="content">
            <div class="meta">
              <span class="ui label" id="showtype">{{ $event->type }}</span>
              <span class="ui label">{{ App\Show::find($event->show_id)->type }}</span>
              <span class="ui label">{{ App\Show::find($event->show_id)->duration }} minutes</span>
            </div>
            <div class="ui header">
              {{ App\Show::find($event->show_id)->name }}
              <div class="sub header">
                <i class="calendar icon"></i>
                {{ Date::parse($event->start)->format('l, F j, Y \a\t g:i A') }} |
                <i class="ticket icon"></i>
                {{ $event->seats }} seats left
              </div>
            </div>
            <div class="meta">

            </div>
            <div class="description">
              <div class="ui form">
                <div class="three fields">
                  <div class="field">
                    <div class="ui right labeled left action small input">
                      <button onclick="changeAmount({{ $loop->index }}*3+0, 1, 'adult', {{ $event->show_id }}, '{{ App\Show::find($event->show_id)->name }}', '{{ $event->type }}', {{ $event->adults_price }})" class="ui icon button plus"><i class="plus icon"></i></button>
                      <button onclick="changeAmount({{ $loop->index }}*3+0,-1, 'adult', {{ $event->show_id }}, '{{ App\Show::find($event->show_id)->name }}', '{{ $event->type }}', {{ $event->adults_price }})" class="ui icon button"><i class="minus icon"></i></button>
                      <input min="0" value="0" type="text" placeholder="0">
                      <div class="ui price label">at $ {{ number_format($event->adults_price, 2) }} / adult</div>
                    </div>
                  </div>
                  <div class="field">
                    <div class="ui right labeled left action small input">
                      <button onclick="changeAmount({{ $loop->index }}*3+1, 1, 'children', {{ $event->show_id }}, '{{ App\Show::find($event->show_id)->name }}', '{{ $event->type }}', {{ $event->children_price }})" class="ui icon button"><i class="plus icon"></i></button>
                      <button onclick="changeAmount({{ $loop->index }}*3+1,-1, 'children', {{ $event->show_id }}, '{{ App\Show::find($event->show_id)->name }}', '{{ $event->type }}', {{ $event->children_price }})" class="ui icon button"><i class="minus icon"></i></button>
                      <input min="0" value="0" type="text" placeholder="0">
                      <div class="ui price label">at $ {{ number_format($event->children_price, 2) }} / child</div>
                    </div>
                  </div>
                  <div class="field">
                    <div class="ui right labeled left action small input">
                      <button onclick="changeAmount({{ $loop->index }}*3+2, 1, 'member', {{ $event->show_id }}, '{{ App\Show::find($event->show_id)->name }}', '{{ $event->type }}', {{ number_format($event->member_price, 2) }})" class="ui icon button"><i class="plus icon"></i></button>
                      <button onclick="changeAmount({{ $loop->index }}*3+2,-1, 'member', {{ $event->show_id }}, '{{ App\Show::find($event->show_id)->name }}', '{{ $event->type }}', {{ number_format($event->member_price, 2) }})" class="ui icon button"><i class="minus icon"></i></button>
                      <input min="0" value="0" type="text" placeholder="0">
                      <div class="ui price label">at $ {{ number_format($event->member_price, 2) }} / member</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="extra">
              Created {{ Date::parse($event->created_at)->format('l, F j, Y \a\t g:i A') }}
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
    {!! Form::open(['route' => 'cashier.store', 'class' => 'ui form']) !!}
    <div class="ui two buttons">
      {!! Form::button('<i class="check icon"></i> Confirm', ['type' => 'submit', 'class' => 'ui green button']) !!}
      <button class="ui large negative button"><i class="remove icon"></i>Cancel</button>
    </div>
    {!! Form::close() !!}
    <div class="ui segments">
      <div class="ui bottom attached header">
        Total
        <h1 class="ui right aligned header">
          $ <span id="total">0.00</span>
        </h1>
      </div>
      <div class="ui attached segment">
        <div class="ui selection dropdown">
          <input type="hidden" name="payment_method">
          <i class="dropdown icon"></i>
          <div class="default text"><i class="money icon"></i>Cash</div>
          <div class="menu">
            <div class="item" data-value="visa"><i class="money icon"></i>Cash</div>
            <div class="item" data-value="visa"><i class="visa icon"></i>Visa</div>
            <div class="item" data-value="mastercard"><i class="mastercard icon"></i>Mastercard</div>
            <div class="item" data-value="discover"><i class="discover icon"></i>Discover</div>
            <div class="item" data-value="american"><i class="american express icon"></i>American Express</div>
          </div>
        </div>
        <h4 class="ui right floated header">
          Subtotal = $ <span id="subtotal">0.00</span>
          <div class="sub header">{{ App\Setting::find(1)->tax }}% Tax = $ <span id="tax">0.00</span></div>
        </h4>
      </div>
      <div class="ui attached segment" id="tickets">

      </div>
    </div>
  </div>
</div>

<script>

  function changeAmount(number, operator, ticketType, showId, show, eventType, price) {
    var sum = 0;
    var inputs = document.querySelectorAll("input[type='text']");
    var divs = document.querySelectorAll(".ui.price.label");
    inputs[number].value = parseInt(inputs[number].value) + parseInt(operator);
    if (parseInt(inputs[number].value) < 0)
      inputs[number].value = 0;
    for(i = 0; i < inputs.length; i++)
    {
      sum += parseInt(inputs[i].value) * parseFloat(divs[i].innerHTML.split(" ")[2]).toFixed(2);

    }
    var subtotal = sum.toFixed(2);
    var tax = (sum * ({{ App\Setting::find(1)->tax }}/100)).toFixed(2);
    var total = (parseFloat(subtotal) + parseFloat(tax)).toFixed(2);

    document.querySelector('#subtotal').innerHTML = subtotal;
    document.querySelector('#tax').innerHTML = tax;
    document.querySelector('#total').innerHTML = total;

    if (show)
      var showTrimmed = show.replace(/\s+/g, "").replace(":", "");

    if (eventType)
      var eventTypeTrimmed = eventType.replace(/\s+/g, "").replace(":", "");

    if(operator == 1) {
      $('#tickets').append('<h4 class="ui header '+ ticketType + showTrimmed + eventTypeTrimmed + price +'"><i class="ticket icon"></i><div class="content" style="width:100%">'+ ticketType +' | ' + eventType +' <span style="float:right">$ '+ price.toFixed(2) + '</span><div class="sub header">'+ show +'</div></div></h4>');
      $('form').append('<input type="hidden" name="tickettype[]" id="'+ ticketType + showTrimmed + eventTypeTrimmed + price +'" value="'+ ticketType +'">');
      $('form').append('<input type="hidden" name="show[]" id="'+ ticketType + showTrimmed + eventTypeTrimmed + price +'" value="'+ showId +'">');
      $('form').append('<input type="hidden" name="eventtype[]" id="'+ ticketType + showTrimmed + eventTypeTrimmed + price +'" value="'+ eventType +'">');
      $('form').append('<input type="hidden" name="price[]" id="'+ ticketType + showTrimmed + eventTypeTrimmed + price +'" value="'+ price +'">');
    }
    else {
      $('.ui.header.'+ ticketType + showTrimmed + eventTypeTrimmed + price + '').first().remove();
      $('input[type="hidden"][name="tickettype"][value="'+ ticketType +'"]#'+ ticketType + showTrimmed + eventTypeTrimmed + price + '').first().remove();
      $('input[type="hidden"][name="show"][value="'+ showId +'"]#'+ ticketType + showTrimmed + eventTypeTrimmed + price + '').first().remove();
      $('input[type="hidden"][name="eventtype"][value="'+ eventType +'"]#'+ ticketType + showTrimmed + eventTypeTrimmed + price + '').first().remove();
      $('input[type="hidden"][name="price"][value="'+ price +'"]#'+ ticketType + showTrimmed + eventTypeTrimmed + price + '').first().remove();
    }

  }

</script>

@endsection
