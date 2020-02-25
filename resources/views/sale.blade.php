@extends('layout.astral')

@section('title', "Field Trip Confirmation - {$sale->customer->fullname} - {$sale->organization->name} (Sale #$sale->id)")

@section('content')

<div class="ui container">

  @if ($sale->status != 'confirmed')
  <div class="ui info icon message">
    <i class="info circle icon"></i>
    <div class="content">
      <div class="header">Your field trip is right around the corner!</div>
      <p>We are excited to have you at the {{ $setting->organization }}. Please confirm your field trip!</p>
    </div>
  </div>
  @endif

  <img src="{{ $setting->logo }}" alt="{{ $setting->organization }}" class="ui centered tiny image">
  
  @if ($sale->status == 'confirmed')
    <div class="ui icon green message">
      <i class="thumbs up icon"></i>
      <div class="content">
        <div class="header">
          Your field trip has already been confirmed, {{ $sale->customer->firstname }}!
        </div>
        <p>We hope you and group have a great field trip!</p>
      </div>
    </div>
    <a class="ui massive fluid blue button" href="http://{{ $setting->website }}">
      Back to {{ $setting->organization }}'s website
    </a>
  @else
    <div class="ui center aligned header">
      <div class="content">
        {{ $setting->organization }}
        <div class="sub header">Sale #{{ $sale->id }}</div>
      </div>
      
    </div>

    <div class="ui horizontal divider header">
      <i class="dollar icon"></i>
      Sale Information
    </div>

    <div class="ui items">
      <div class="item">
        <div class="content">
          <div class="header">
            Sale #{{ $sale->id }}
            <div class="ui green label">
              $ {{ number_format($sale->total, 2, '.', ',') }}
              <div class="detail">due at the ticket desk</div>
            </div>
            <div class="ui basic green label">
              $ {{ number_format($sale->payments->sum('total'), 2, '.', ',') }}
              <div class="detail">paid</div>
            </div>
            <div class="ui basic green label">
                $ {{ number_format($sale->balance, 2, '.', ',') }}
                <div class="detail">balance</div>
              </div>
          </div>
          <div class="description">
            <i class="user circle icon"></i>
            {{ $sale->customer->fullname }}
            <div class="ui black label">{{ $sale->customer->role->name }}</div>
            @if ($sale->organization_id != 1)
            <div class="ui black label">{{ $sale->organization->name }}</div>
            @endif
            <br>
            <i class="at icon"></i> {{ $sale->customer->email }}
          </div>
          <div class="meta">
            <i class="user circle icon"></i>
            {{ $sale->creator_id == 1 ? 'system' : $sale->creator->firstname }}
          </div>
          <div class="meta">
            <i class="pencil icon"></i> 
            {{ $sale->created_at->format('l, F j, Y \a\t g:i:s A') }} 
            ({{ $sale->created_at->diffForHumans()  }})
          </div>
          @if (($sale->created_at != $sale->updated_at) && isset($sale->created_at))
          <div class="meta">
            <i class="pencil icon"></i> 
            {{ $sale->updated_at->format('l, F j, Y \a\t g:i:s A') }} 
            ({{ $sale->updated_at->diffForHumans()  }})
          </div>
          @endif
        </div>
      </div>
    </div>

    <div class="ui horizontal divider header">
      <i class="calendar check icon"></i>
      Events, Attendance and Tickets
    </div>

    <div class="ui items">
      @foreach ($sale->events as $event)
      <div class="item">
        <div class="ui tiny image">
        <img src="{{ $event->show->cover }}" alt="{{ $event->show->name }}">
        </div>
        <div class="content">
          <div class="meta">
            {{ $event->start->format('l, F j, Y \a\t g:i:s A') }}
            ({{ $event->start->diffForHumans() }})
          </div>
          <div class="header">
            {{ $event->show->id == 1 ? $event->memo : $event->show->name }}
            <div class="ui black label">
              {{ $event->show->type }}
            </div>
            <div class="ui basic black label">
              {{ $event->type->name }}
            </div>
          </div>
          <div class="description">
            @foreach ($event->tickets->unique('ticket_type_id') as $ticket)
            <div class="ui black label">
              <i class="ticket icon"></i>
              {{ $ticket->where('sale_id', $sale->id)->where('event_id', $event->id)->count() }}
              <div class="detail">
                $ {{ number_format($ticket->type->price, 2, '.', ',') }} / 
                {{ $ticket->type->name }}
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
      @endforeach
    </div>
    
    <div class="ui horizontal divider header">
      <i class="dollar icon"></i>
      Totals
    </div>

    <div class="ui tiny five statistics">
      <div class="statistic">
        <div class="label">
            Subtotal
          </div>
        <div class="value">
          $ {{ number_format($sale->subtotal, 2, '.', ',') }}
        </div>
      </div>
      <div class="statistic">
        <div class="label">
            Tax
          </div>
        <div class="value">
          $ {{ number_format($sale->tax, 2, '.', ',') }}
        </div>
      </div>
      <div class="statistic">
        <div class="label">
            Total
          </div>
        <div class="value">
          $ {{ number_format($sale->total, 2, '.', ',') }}
        </div>
      </div>
      <div class="{{ $sale->payments->sum('total') > 0 ? 'green' : 'red' }} statistic">
        <div class="label">
            Paid
          </div>
        <div class="value">
          $ {{ number_format($sale->payments->sum('total'), 2, '.', ',') }}
        </div>
      </div>
      <div class="{{ $sale->balance == 0 ? 'green' : 'red' }} statistic">
          <div class="label">
              Balance
            </div>
          <div class="value">
            $ {{ number_format($sale->balance, 2, '.', ',') }}
          </div>
        </div>
    </div>

    <div class="ui divider"></div>

    {!! \Illuminate\Mail\Markdown::parse(App\Setting::find(1)->confirmation_text) !!}

    <?php

      //$events = $sale->events->count();
      $numberOfEvents = $sale->events->where('id', '!=', 1)->count();

    ?>

    <ul>
      <li>
        We reserved {{ $numberOfEvents == 1 ? $sale->tickets->count() : $sale->tickets->count() / $numberOfEvents }} seats per show for you. If more than {{ $numberOfEvents == 1 ? $sale->tickets->count() : $sale->tickets->count() / $numberOfEvents }} people show up,
        we admit them space available (up to our capacity of {{ App\Setting::find(1)->seats }}) for the same price you paid. You may
        choose, include them in your payment or they may buy their own tickets at show time.
      </li>
    </ul>

    <ul>
      <li>
        Please visit our <a href="http://{{ App\Setting::find(1)->website }}" target="_blank">website</a> for directions, parking and other valuable info. We sincerely hope you enjoy your visit. Do not hesitate
        to call or email us with any questions regarding your visit. Thank you a have a great day.
      </li>
    </ul>

    <hr />

    <div class="ui checkbox">
      <input type="checkbox" tabindex="0" class="hidden">
      <label>I agree with the terms above. I am ready to confirm my reservation.</label>
    </div>

    <br><br>

    <a class="ui massive green fluid button disabled" href="{{ route('sale.confirm', $sale) }}?source={{ request()->query('source') }}">
      <i class="thumbs up icon"></i>
      Confirm
    </a>

  @endif

  <h4 class="ui center aligned header">
    <div class="content">
      {{ $setting->organization }} <br /> {{ $setting->address }}
      <div class="sub header">
        <i class="phone icon"></i>{{ $setting->phone }} |
        <i class="at icon"></i>{{ $setting->email }} |
        <i class="globe icon"></i><a href="http://{{ App\Setting::find(1)->website }}" target="_blank">{{ $setting->website }}</a> | 
        <a href="https://astral.anderfernandes.com" class="ui black tiny image label" target="_blank">
          <img src="https://astral.anderfernandes.com/assets/astral-logo-light.png" alt="Astral" />
          Powered by Astral
        </a>
      </div>
    </div>
  </h4>
</div>

<script>

  let confirm_button = document.querySelector('.ui.massive.green.fluid.button')
  $('.ui.checkbox').checkbox({
    onChecked: function() { $(confirm_button).removeClass('disabled') },
    onUnchecked: function() { $(confirm_button).addClass('disabled') },
    })

</script>

@endsection
