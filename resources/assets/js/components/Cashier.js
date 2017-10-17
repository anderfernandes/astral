import React, { Component } from 'react'
import ReactDOM    from 'react-dom'
import axios       from 'axios'
import EventCard   from './EventCard'
import SaleCard    from './SaleCard'
import LoadingCard from './LoadingCard'
import update      from 'immutability-helper' // required to update ticket arrays properly

export default class Cashier extends Component {
    constructor(props) {
      super(props)
      this.state = {
        events: [],
        loading: true,
        allTickets : [],
      }
    }

    // Add ticket in current sale and update state
    addOrRemoveTicket(dataFromChild) {
      let tickets = this.state.allTickets

      if (dataFromChild[0].action == "add") {
        let addedTickets = update(tickets, {$push: dataFromChild})
        this.setState({ allTickets: addedTickets })
      }
      else {
        let removedTickets = []
        let ticketToRemove = dataFromChild[0].ticketId
        for (let i = 0; i < tickets.length; i++) {
          if (tickets[i].ticketId === ticketToRemove) {
            removedTickets = update(tickets, {$splice: [[i, 1]]})
            //tickets.splice(i, 1)
            break
          }
        }
        this.setState({ allTickets: removedTickets })
      }
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
          return <EventCard event={e} addOrRemoveTicket={this.addOrRemoveTicket.bind(this)} key={i} />
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
              <SaleCard tickets={this.state.allTickets} />
            </div>
          </div>
        )
    }
}

if (document.getElementById('cashier')) {
    ReactDOM.render(<Cashier />, document.getElementById('cashier'))
}
