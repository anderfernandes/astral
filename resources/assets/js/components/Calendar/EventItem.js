import React, { Component } from 'react'
import { Grid, Image, Label } from 'semantic-ui-react'
import moment from 'moment'

export default class EventItem extends Component {
    constructor(props) {
      super(props)
      this.state = { data: [] }
    }
    render() {
      let data = this.props.data
      return(
        <Grid.Row>
          <Grid.Column>
            <Grid columns={2}>
              <Grid.Row>
                {
                  data.events.map((e, i) =>
                    <Grid.Column key={i}>
                      <Image src={e.show.cover} size="medium" centered />
                      <div className="ui label">{ e.show.type }</div>
                    </Grid.Column>
                  )}
              </Grid.Row>
            </Grid>
          </Grid.Column>
          <Grid.Column>
            <h4 className="ui centered huge header">
              <div className="content">
                { data.customer.name }
              </div>
              <div className="content">

                { data.customer.organization }
                <div className="sub header">
                  { moment(data.start).calendar() }
                </div>
              </div>
            </h4>
          </Grid.Column>
        </Grid.Row>
      )
    }
}
