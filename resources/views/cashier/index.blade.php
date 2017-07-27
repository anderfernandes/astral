@extends('layout.cashier')

@section('title', 'Cashier')

@section('content')

<div class="ui grid">
  <div class="sixteen wide mobile sixteen wide computer column">
    <h1 class="ui dividing header">
      Cashier
      <div class="sub header">
        Welcome, {{ $user->firstname }} {{ $user->firstname }}! Today is {{ Date::now()->format('l, F j, Y')}}.
      </div>
    </h1>
  </div>
</div>

<div class="ui grid">

  <div class="sixteen wide mobile ten wide computer column">

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
              <div class="ui right labeled left action input">
                <button onclick="changeAmount({{ $loop->index }}*3+0, 1, 'adult', '{{ App\Show::find($event->show_id)->name }}', '{{ $event->type }}', {{ $event->adults_price }})" class="ui icon button plus"><i class="plus icon"></i></button>
                <button onclick="changeAmount({{ $loop->index }}*3+0,-1, 'adult', '{{ App\Show::find($event->show_id)->name }}', '{{ $event->type }}', {{ $event->adults_price }})" class="ui icon button"><i class="minus icon"></i></button>
                <input min="0" value="0" type="number" placeholder="0">
                <div class="ui tag label">at $ {{ number_format($event->adults_price, 2) }} / adult</div>
              </div>
              <br />
              <div class="ui right labeled left action input">
                <button onclick="changeAmount({{ $loop->index }}*3+1, 1, 'children', '{{ App\Show::find($event->show_id)->name }}', '{{ $event->type }}', {{ $event->children_price }})" class="ui icon button"><i class="plus icon"></i></button>
                <button onclick="changeAmount({{ $loop->index }}*3+1,-1, 'children', '{{ App\Show::find($event->show_id)->name }}', '{{ $event->type }}', {{ $event->children_price }})" class="ui icon button"><i class="minus icon"></i></button>
                <input min="0" value="0" type="number" placeholder="0">
                <div class="ui tag label">at $ {{ number_format($event->children_price, 2) }} / child</div>
              </div>
              <br />
              <div class="ui right labeled left action input">
                <button onclick="changeAmount({{ $loop->index }}*3+2, 1, 'member', '{{ App\Show::find($event->show_id)->name }}', '{{ $event->type }}', {{ number_format($event->member_price, 2) }})" class="ui icon button"><i class="plus icon"></i></button>
                <button onclick="changeAmount({{ $loop->index }}*3+2,-1, 'member', '{{ App\Show::find($event->show_id)->name }}', '{{ $event->type }}', {{ number_format($event->member_price, 2) }})" class="ui icon button"><i class="minus icon"></i></button>
                <input min="0" value="0" type="number" placeholder="0">
                <div class="ui tag label">at $ {{ number_format($event->member_price, 2) }} / member</div>
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

  <div class="sixteen wide mobile six wide computer column">
    <div class="ui segments">
      <h3 class="ui top attached header">
        <i class="file text icon"></i>Sale
      </h3>
      <div class="ui attached segment" id="tickets">
        <!--<h4 class="ui header">
          <i class="ticket icon"></i>
          <div class="content">
            Adult Matinee $5.00 <i class="remove icon"></i>5 = $25.00
            <div class="sub header">Astronaut</div>
          </div>
        </h4>-->
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
      <div class="ui bottom attached header">
        Total
        <h1 class="ui right aligned header">
          $ <span id="total">0.00</span>
        </h1>
      </div>
    </div>
    <div class="ui two buttons">
      <button class="ui large positive button"><i class="check icon"></i>Confirm</button>
      <button class="ui large negative button"><i class="remove icon"></i>Cancel</button>
    </div>
  </div>
</div>

<script>

  function changeAmount(number, operator, ticketType, show, eventType, price) {
    var sum = 0;
    var inputs = document.querySelectorAll("input[type='number']");
    var divs = document.querySelectorAll(".ui.tag.label");
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

    console.log(showTrimmed);


    if(operator == 1)
      $('#tickets').append('<h4 class="ui header '+ ticketType + showTrimmed + eventType + price +'"><i class="ticket icon"></i><div class="content" style="width:100%">'+ ticketType +' | ' + eventType +' <span style="float:right">$ '+ price.toFixed(2) + '</span><div class="sub header">'+ show +'</div></div></h4>');
    else {
      $('.ui.header.'+ ticketType + showTrimmed + eventType + price + '').first().remove();
    }
  }

</script>

@endsection
