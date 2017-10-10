import React, { Component } from 'react'
import axios     from 'axios'
import ReactDOM  from 'react-dom'
import EventCard from './EventCard'
import SaleCard  from './SaleCard'

export default class Cashier extends Component {
    constructor(props) {
      super(props)
      this.state = { value: '', events: []}
    }
    componentDidMount() {
      axios.get('/api/events')
        .then(response => { this.setState({ events: response.data })})
        .catch(function(error) {
          console.log(error)
        })
    }
    loadEventCards() {
      if (this.state.events instanceof Array) {
        return this.state.events.map(function(e, i) {
          return <EventCard event={e} key={i} />
        })
      }
      else {
        return 'No shows today'
      }
    }
    render() {
        return (
          <div className="ui grid">
            <div className="sixteen wide mobile twelve wide computer column">
            <div className="ui doubling grid">
              {this.loadEventCards()}
            </div>
            </div>
            <div className="sixteen wide mobile four wide computer column">
              <SaleCard subtotal={0} />
            </div>
          </div>
        )
    }
}

if (document.getElementById('cashier')) {
    ReactDOM.render(<Cashier />, document.getElementById('cashier'))
}
