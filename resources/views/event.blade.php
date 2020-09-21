@extends('layout.public')

@section('title', 'Welcome!')

@section('content')

<div class="ui basic container segment">

  <div class="ui basic blue circular icon button">
    <i class="chevron left icon"></i>
  </div>

</div>

<div class="ui basic container segment">
  
  <h1 class="ui dividing header">
    <div class="content">
      {{ $event->show->name }}
      <div class="ui black label">
        {{ $event->type->name }}
      </div>
      <div class="ui black label">
        {{ $event->show->type }}
      </div>
      <div class="sub header">
        <i class="calendar alternate icon"></i>
        {{ $event->start }}
      </div>
    </div>
  </h1>

  <div class="ui grid">
    <div class="four wide column">
      <img class="ui fluid image" src="{{ $event->show->cover }}" alt="{{ $event->show->name }}">
    </div>
    <div class="twelve wide column">
      <h1 class="ui header">
        <div class="sub header">
          {{ $event->show->description }}
        </div>
      </h1>
    </div>
  </div>

</div>

<div class="ui basic segment container">

  <div class="ui five link cards">
    @foreach ($event->type->allowedTickets->where('public', true)->where('name', '!=', 'Member') as $ticket)
    <div class="card">
      <div class="content">
        <div class="header">
          {{ $ticket->name }}
          <div class="right floated meta">
            <div class="ui green tag label">
              $ {{ $ticket->price }}
            </div>
          </div>
        </div>
      </div>
      <div class="extra content">
        <div class="ui three column grid">
          <div class="column">
            <div class="ui basic green circular icon button" 
              onclick="addTicket({{ $event->id }}, {{ $ticket->id }}, {{ $ticket->price }})">
              <i class="plus icon"></i>
            </div>
          </div>
          <div class="column">
            <h1 class="ui center aligned header" id="{{ $event->id }}-{{ $ticket->id }}">0</h1>
          </div>
          <div class="column">
            <div class="ui basic yellow circular icon button" 
              onclick="removeTicket({{ $event->id }}, {{ $ticket->id }}, {{ $ticket->price }})">
              <i class="minus icon"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>

</div>

<div class="ui basic segment container">

  <div class="ui green huge fluid button" onclick="addToCart()">
    <i class="cart icon"></i>
    Add to Cart
  </div>

</div>

@endsection

<script>
  let cart = {
    event_id: {{ $event->id }},
    tickets: []
  }

  if (!localStorage.getItem('cart') && !localStorage.getItem('date')) {
    localStorage.setItem('cart', '[]')
    localStorage.setItem('date', new Date())
  }
    

  // This function will add tickets to the card
  const addTicket = (event_id, ticket_id, price) => {

    // Find object that describes current ticket
    let ticket = cart.tickets.find(ticket => ticket.id === ticket_id)

    // Find amount of the ticket in question
    const ticketAmount = ticket ? ticket.amount : 0

    if (ticket) {
      // If ticket exists, update only the amount
      ticket.amount++
    } else {
      // If it doesn't exist, push a new ticket object to cart
      cart.tickets.push({ id: ticket_id, price, amount: 1 })
    }

    // Find object that describes current ticket AFTER UPDATES
    ticket = cart.tickets.find(ticket => ticket.id === ticket_id)

    // Update amount of tickets on UI
    document.getElementById(`${String(event_id)}-${String(ticket_id)}`).textContent = ticket.amount
  }

  const removeTicket = (event_id, ticket_id, price) => {
    
    // Find object that describes current ticket
    let ticket = cart.tickets.find(ticket => ticket.id === ticket_id)

    if (ticket.amount > 0) {
      // Update ticket amount
      ticket.amount--
    }

    // Update amount of tickets on UI
    document.getElementById(`${String(event_id)}-${String(ticket_id)}`).textContent = ticket.amount
  }

  const addToCart = () => {
    localStorage.setItem('cart', JSON.stringify(cart))
    localStorage.setItem('date', new Date())
  }

</script>
