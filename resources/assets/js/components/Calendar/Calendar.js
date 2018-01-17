import React, { Component } from 'react'
import EventItem from './EventItem'
import { Grid, Dimmer, Loader, Header, Icon } from 'semantic-ui-react'
import moment from 'moment'
import ReactDOM from 'react-dom'

class Calendar extends Component {
  constructor() {
    super()
    this.state = {
      isLoading: true,
      sales: []
    }
  }

  getSales() {
    fetch('/api/sales')
      .then((response) => response.json())
      .then((sales) => this.setState({ sales: sales, isLoading: false }))
      .catch((error) => console.log(error))
  }

  componentDidMount() {
    this.getSales()
    setInterval(() => this.getSales(), 10000)
  }

  render() {
    let sales = this.state.sales
    let isLoading = this.state.isLoading
    if (isLoading) {
      return (
        <Dimmer active inverted>
          <Loader size="massive" inline="centered">Loading</Loader>
        </Dimmer>
      )
    }
    else {
      if (this.state.sales.length < 1 ) {
        return(
          <div>
            <img className="ui tiny centered image" src="/logo.png" />
            <h2 className="ui centered blue header">
              Upcoming Events
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

              <h2 className="ui centered blue header">
                <img className="ui image" src="/logo.png" />
                <div className="content">
                  Upcoming Events
                  <div className="sub header">Next 7 days</div>
                </div>
              </h2>

            <div className="ui grid">
                { sales.map((sale) => <EventItem data={sale} key={sale.id} />) }
            </div>
          </div>
        )
      }
    }
  }
}

if (document.getElementById('calendar')) {
    ReactDOM.render(<Calendar />, document.getElementById('calendar'))
}
