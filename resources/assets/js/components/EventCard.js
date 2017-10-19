import React, { Component } from 'react'
import moment from 'moment'

export default class EventCard extends Component {
  constructor(props) {
    super(props)
      this.state = {
        eventTickets: []
      }
  }

    // Get information on all the tickets for this event and sends it to the parent Cashier component
    addOrRemoveEventTicket(dataFromChild) {
      this.setState({ eventTickets: dataFromChild })
    }

    // Send this event's ticket information to parent Cashier component whenever tickets are added or removed
    componentDidUpdate(prevProps, prevState) {
      if (prevState.eventTickets != this.state.eventTickets)
        this.props.addOrRemoveTicket(this.state.eventTickets)

    }

    loadAllowedTickets() {
      return this.props.event.allowedTickets.map(function(t, i) {
        return (
          <TicketButton event={this.props.event} ticket={t} key={i} addOrRemoveEventTicket={this.addOrRemoveEventTicket.bind(this)} />
        )
      }, this)
    }

    render() {
      let event = this.props.event
      return (
          <div className="ui eight wide column">
            <div className="ui unstackable items">
              <div className="item">
                <div className="ui tiny rounded image">
                  <img src={event.show.cover} />
                </div>
                <div className="content">
                  <div className="header">
                    {event.show.name}
                  </div>
                  <div className="meta">
                    <div className="ui label">{event.show.type}</div>
                    <div className="ui label">{event.type}</div>
                  </div>
                  <div className="meta">{moment(event.start).calendar()} | {event.seats} seats left</div>
                  <div className="extra content">
                    { this.loadAllowedTickets() }
                  </div>
                </div>
              </div>
            </div>
          </div>
        )
    }
}

class TicketButton extends Component {

  // Sends ticket information to parent component. In this case, EventCard
  sendTicketInformation(action) {
    // Send and array of ticket objects
    this.props.addOrRemoveEventTicket([{
      ticketTypeId: this.props.ticket.id,
      ticketType: this.props.ticket.name,
      showName: this.props.event.show.name,
      showType: this.props.event.show.type,
      start: this.props.event.start,
      price: this.props.ticket.price,
      eventId: this.props.event.id,
      action: action
    }])
  }

  addOrRemoveTicket(e) {
    this.sendTicketInformation('add')
  }

  removeTicket(e) {
    this.sendTicketInformation('remove')
  }

  render() {
    return(
      <div className="ui buttons">
        <div className="ui inverted green button" onClick={ (e) => this.addOrRemoveTicket(e) }>
          {this.props.ticket.name}
        </div>
        <div className="ui inverted red icon button" onClick={ (e)=> this.removeTicket(e) }>
          <i className="minus icon"></i>
        </div>
      </div>
    )
  }
}
