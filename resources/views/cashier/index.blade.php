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

  @if ($events)
    @foreach($events as $event)
      <div class="ui unstackable items">
        <div class="item">
          <div class="ui small image">
            <img src="https://semantic-ui.com/images/wireframe/square-image.png">
          </div>
          <div class="content">
            <div class="meta">
              <span class="ui label">{{ $event->type }}</span>
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
                <button class="ui icon button"><i class="plus icon"></i></button>
                <button class="ui icon button"><i class="minus icon"></i></button>
                <input type="number" placeholder="0">
                <div class="ui tag label">
                  at $ {{ number_format($event->adults_price, 2) }} / adult
                </div>
              </div>
              <br />
              <div class="ui right labeled left action input">
                <button class="ui icon button"><i class="plus icon"></i></button>
                <button class="ui icon button"><i class="minus icon"></i></button>
                <input type="number" placeholder="0">
                <div class="ui tag label">
                  at $ {{ number_format($event->children_price, 2) }} / child
                </div>
              </div>
              <br />
              <div class="ui right labeled left action input">
                <button class="ui icon button"><i class="plus icon"></i></button>
                <button class="ui icon button"><i class="minus icon"></i></button>
                <input type="number" placeholder="0">
                <div class="ui tag label">
                  at $ {{ number_format($event->member_price, 2) }} / member
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

  <div class="sixteen wide mobile six wide computer column">
    <div class="ui segments">
      <h3 class="ui top attached header">
        <i class="file text icon"></i>Sale
      </h3>
      <div class="ui attached segment">
        <h4 class="ui header">
          <i class="ticket icon"></i>
          <div class="content">
            Adult Matinee $5.00 <i class="remove icon"></i>5 = $25.00
            <div class="sub header">Astronaut</div>
          </div>
        </h4>
      </div>
      <div class="ui attached segment">
        <h4 class="ui header">
          <i class="ticket icon"></i>
          <div class="content">
            Children Matinee $5.00<i class="remove icon"></i>5 = $25.00
            <div class="sub header">Astronaut</div>
          </div>
        </h4>
      </div>
      <div class="ui attached segment">
        <h4 class="ui right aligned header">
          Subtotal = $25.00
          <div class="sub header">{{ App\Setting::find(1)->tax }}% Tax = $1.00</div>
        </h4>
      </div>
      <div class="ui attached segment">
        <div class="ui radio checkbox">
          <input name="payment" type="radio">
          <label><i class="american express icon"></i></label>
        </div>
        <div class="ui radio checkbox">
          <input name="payment" type="radio">
        <label><i class="diners club icon"></i></label>
        </div>
        <div class="ui radio checkbox">
          <input name="payment" type="radio">
          <label><i class="discover icon"></i></label>
        </div>
        <div class="ui radio checkbox">
          <input name="payment" type="radio">
          <label><i class="mastercard icon"></i></label>
        </div>
        <div class="ui radio checkbox">
          <input name="payment" type="radio">
          <label><i class="visa icon"></i></label>
        </div>
        <div class="ui radio checkbox">
          <input name="payment" type="radio">
          <label><i class="money icon"></i></label>
        </div>
        <div class="ui radio checkbox">
          <input name="payment" type="radio">
          <label><i class="money icon"></i></label>
        </div>
      </div>
      <div class="ui bottom attached header">
        Total
        <h1 class="ui right aligned header">
          $25.00
        </h1>
      </div>
    </div>
    <div class="ui two buttons">
      <button class="ui large positive button"><i class="check icon"></i>Confirm</button>
      <button class="ui large negative button"><i class="remove icon"></i>Cancel</button>
    </div>
  </div>
</div>

@endsection
