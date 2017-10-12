import React, { Component } from 'react'
import ReactDOM    from 'react-dom'
import axios       from 'axios'
import EventCard   from './EventCard'
import SaleCard    from './SaleCard'
import LoadingCard from './LoadingCard'

export default class Cashier extends Component {
    constructor(props) {
      super(props)
      this.state = {
        value: '',
        events: [],
        loading: true,
        allTickets : [],
      }
    }

    // Get all tickets in current sale and set it to state
    getAllTickets(dataFromChild) {
      this.setState({ allTickets: this.state.allTickets.concat(dataFromChild) })
    }

    componentDidMount() {
      axios.get('/api/events')
        .then(response => { this.setState({ events: response.data, loading: false })})
        .catch(function(error) {
          console.log(error)
        })
    }

    loadEventCards() {
      if (this.state.events instanceof Array) {
        return this.state.events.map(function(e, i) {
          return <EventCard event={e} callbackFromCashier={this.getAllTickets.bind(this)} key={i} />
        }, this)
      }
      else {
        return (<p>No Shows Today</p>)
      }
    }

    render() {
      return (
          <div className="ui grid">
            <div className="sixteen wide mobile twelve wide computer column">
            <div className="ui doubling grid">
              { this.state.loading ? <LoadingCard /> : this.loadEventCards() }
            </div>
            </div>
            <div className="sixteen wide mobile four wide computer column">
              <SaleCard />
            </div>
          </div>
        )
    }
}

if (document.getElementById('cashier')) {
    ReactDOM.render(<Cashier />, document.getElementById('cashier'))
}
