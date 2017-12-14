import React, { Component } from 'react'
import { Grid, Image, Label } from 'semantic-ui-react'
import moment from 'moment'

export default class EventCard extends Component {
    constructor(props) {
      super(props)
      this.state = { data: [] }
    }
    render() {
      let data = this.props.data
      return(
        <Grid.Column>
          <Image src={data.show.cover} rounded size="medium" centered />
          <h3 className="ui centered header">
            <div className="content">
              { moment(data.start).calendar() }
              <div className="sub header">
                <Label color="blue">{data.show.type}</Label><Label color="red">{data.type}</Label>
              </div>
              <div className="sub header">
                {data.allowedTickets.map((ticket) => <Label key={ticket.id}>$ {ticket.price} / {ticket.name}</Label>)}
              </div>
              <div className="sub header">
                {data.seats} seats left
              </div>
            </div>
          </h3>
        </Grid.Column>
      )
    }
}
