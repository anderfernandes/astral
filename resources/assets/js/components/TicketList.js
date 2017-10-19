import React, { Component } from 'react'

export default class TicketList extends Component {
  render() {
    let ticket = this.props.ticket
    return (
      <h6 className="ui header">
        <i className="ticket icon"></i>
        <div className="content" style={{width: 100 + "%"}}>
          { ticket.ticketType }
          <span className="ui mini tag label" style={{float:"right"}}>$ { parseFloat(ticket.price).toFixed(2) }</span>
          <div className="sub header">
            { ticket.showName }
            <div className="ui mini label">{ ticket.showType }</div>
          </div>
        </div>
      </h6>
    )
  }
}
