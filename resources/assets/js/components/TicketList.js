import React, { Component } from 'react'

export default class TicketList extends Component {
  render() {
    let ticket = this.props.ticket
    console.log(ticket)
    return (
      <div className="ui attached segment">
        <h5 className="ui header">
          <i className="ticket icon"></i>
          <div className="content">
            { ticket.showName }
            <div className="sub header">
              <div className="ui mini labels">
              <div className="ui tag label">$ { parseFloat(ticket.price).toFixed(2) }</div>
                <div className="ui label">{ ticket.showType }</div>
                <div className="ui label">{ ticket.ticketType }</div>
              </div>
            </div>
          </div>
        </h5>
      </div>
    )
  }
}
