import React, { Component } from 'react'
import EventItem from './EventItem'
import { Grid, Dimmer, Loader, Header, Icon } from 'semantic-ui-react'
import moment from 'moment'
import ReactDOM from 'react-dom'

class Upcoming extends Component {
  constructor() {
    super()
    this.state = {
      isLoading: true,
      events: []
    }
  }

  getEvents() {
    console.log("Up")
    let today = moment()
    let start = today.format('YYYY-MM-DD')
    let end = today.add(7, 'days').format('YYYY-MM-DD')
    fetch('/api/events/' + start +'/' + end)
      .then((response) => response.json())
      .then((events) => this.setState({ events: events, isLoading: false }))
      .catch((error) => console.log(error))
  }

  componentDidMount() {
    this.getEvents()
    setInterval(() => this.getEvents(), 10000)
  }

  render() {
    let events = this.state.events
    let isLoading = this.state.isLoading
    if (isLoading) {
      return (
        <Dimmer active inverted>
          <Loader size="massive" inline="centered">Loading</Loader>
        </Dimmer>
      )
    }
    else {
      if (this.state.events.length < 1 ) {
        return(
          <div>
            <img className="ui tiny centered image" src="http://mayborntheaterticketing.campus.ctcd.org/logo.png" />
            <h2 className="ui centered blue header">
              Upcoming Show Times
            </h2>
            <div className="ui info icon floating massive message">
              <i className="info circle icon"></i>
              <div className="content">
                <div className="header">No events</div>
                <p>No events coming up in the next 7 days. Please check back soon!</p>
              </div>
            </div>
          </div>
        )
      } else {
        return (
          <div>
            <img className="ui tiny centered image" src="http://mayborntheaterticketing.campus.ctcd.org/logo.png" />
            <h2 className="ui centered blue header">
              Upcoming Show Times
            </h2>
            <Grid columns={4} divided>
              { events.map((e) => <EventItem data={e} key={e.id} />) }
            </Grid>
          </div>
        )
      }
    }
  }
}

if (document.getElementById('root')) {
    ReactDOM.render(<Upcoming />, document.getElementById('root'))
}
