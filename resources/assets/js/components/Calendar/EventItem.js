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
              <Card>
                <Card.Content>
                  <Card.Header>
                    { data.customer.name } (#{ data.id })
                  </Card.Header>
                  <Card.Meta>
                    { data.customer.organization  }
                  </Card.Meta>
                  <Card.Meta>
                    <i className="at icon"></i>{ data.customer.email }
                  </Card.Meta>
                  <Card.Meta>
                    <i className="phone icon"></i>{ data.customer.phone }
                  </Card.Meta>
                  <Card.Description>
                  Created by <strong>{ data.creator }</strong> on { moment(data.created_at).format("dddd, MMMM d, YYYY") }
                  </Card.Description>
                  <Card.Description>
                    {
                      data.tickets.map((ticket, i) =>
                        <div className="ui label">{ ticket.type } ({ ticket.quantity })</div>
                      )
                    }
                  </Card.Description>
                </Card.Content>
                <Card.Content extra>
                  { moment(data.start).calendar() }
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
