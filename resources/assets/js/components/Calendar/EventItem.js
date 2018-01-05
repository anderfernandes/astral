import React, { Component } from 'react'
import { Image, Card } from 'semantic-ui-react'
import moment from 'moment'

export default class EventItem extends Component {
    constructor(props) {
      super(props)
      this.state = { data: [] }
    }
    render() {
      let data = this.props.data
      return (
        <div className="eight wide column">
          <div className="ui grid">
            <div className="eight wide column">
              <div className="ui grid">
              {
                data.events.map((e, i) =>
                  <div className="eight wide column" key={i}>
                    <Image src={e.show.cover} size="medium" centered />
                    <h3 className="ui centered header" style={{marginTop: '0.5rem'}}>
                      <div className="ui blue label">{ e.show.type }</div>
                    </h3>
                  </div>
                )}
              </div>
            </div>
            <div className="eight wide column">
              <Card fluid>
                <Card.Content>
                  <Card.Header>
                    <i className="calendar outline icon"></i>
                    { moment(data.start).calendar(null, { nextWeek: "dddd, MMMM D, YYYY", sameElse: "dddd, MMMM D, YYYY"}) }
                  </Card.Header>
                  <Card.Description>
                    { data.customer.name } (#{ data.id }) <br />
                    { data.customer.organization } <br />
                    <i className="at icon"></i>{ data.customer.email } <br />
                    <i className="phone icon"></i>{ data.customer.phone } <br />
                  </Card.Description>
                  <Card.Description>
                    Created by <strong>{ data.creator }</strong> <br />
                    on { moment(data.created_at).format("dddd, MMMM D, YYYY") }
                  </Card.Description>
                  <Card.Description>
                    {
                      data.tickets.map((ticket, i) =>
                        <div className="ui label" key={i}>{ ticket.type } ({ ticket.quantity })</div>
                      )
                    }
                  </Card.Description>
                </Card.Content>
                <Card.Content extra>
                  <div className="right floated meta">
                    <div className="ui green tag label">$ { parseFloat(data.total).toFixed(2) }</div>
                  </div>
                </Card.Content>
              </Card>
            </div>
          </div>
        </div>
      )
    }
}
