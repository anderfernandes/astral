import React, { Component } from 'react'
import TicketList  from './TicketList'
import LoadingCard from './LoadingCard'

export default class SaleCard extends Component {
    constructor(props) {
      super(props)
      this.state = {
         settings: [],
         customers: [],
         subtotal: 0,
         tendered: 0,
         change: 0,
         tax: 0,
         total: 0,
         loading: true,
      }
    }

    componentDidMount() {
      // Get Customers
      axios.get('/api/customers')
        .then(response => { this.setState({ customers: response.data, loading: false})})
        .catch(function(error) {
          console.log(error)
      })
      // Get Settings
      axios.get('/api/settings')
        .then(response => { this.setState({ settings: response.data[0] })})
        .catch(function(error) {
          console.log(error)
      })
    }

    loadCustomers() {
      return this.state.customers.map(function(c, i) {
        return (
          <option value={c.id} key={i}>{c.firstname} {c.lastname}</option>
        )
      })
    }

    handleChange(event) {
      this.setState({ tendered: event.target.value })
    }

    calculateTotals() {
      let subtotal = 0
      this.props.tickets.map(function(t, i) {
        let ticketPrice = parseFloat(t.price)
        subtotal = subtotal + ticketPrice
      })
      let tax = parseFloat((this.state.settings.tax / 100) * subtotal)
      // Round to two decimal place string
      tax = tax.toFixed(2)
      // Make the string a float with two decimal places
      tax = parseFloat(tax)
      let total = parseFloat(subtotal + tax).toFixed(2)
      let change = (this.state.tendered - parseFloat(total)) <= 0 ? 0 : (this.state.tendered - parseFloat(total))
      // Round to two decimal place string
      change = change.toFixed(2)
      // Make the string a float with two decimal places
      change = parseFloat(change)
      // Make it a string
      change = change.toFixed(2)
      this.setState({ tax: tax, subtotal: subtotal, total: total, change: change })
    }

    componentDidUpdate(prevProps, prevState) {
      if (prevProps.tickets != this.props.tickets || prevState.tendered != this.state.tendered)
        this.calculateTotals()
    }

    render() {
      return (
          <div className="ui segments">
            <div className="ui top attached segment">
              <div className="ui form">
                <div className="field">
                  <label>Customer</label>
                  <select style={{font:'inherit'}} className="ui search scrolling dropdown">
                    { this.loadCustomers() }
                  </select>
                </div>
              </div>
            </div>
            <div className="ui attached segment">
              <div className="ui form">
              <div className="field">
                <label>Tendered</label>
                <div className="ui massive fluid labeled input">
                  <div className="ui label">$</div>
                  <input type="text" value={ this.state.tendered } onChange={(e) => this.handleChange(e)} />
                </div>
              </div>
            </div>
            </div>
            <div className="ui attached clearing segment">
              <h4 className="ui right floated header">
                Subtotal = $ <span id="subtotal">{ parseFloat(this.state.subtotal).toFixed(2) }</span>
                <div className="sub header">
                  { this.state.settings.tax }% Tax = $ <span id="tax">{ parseFloat(this.state.tax).toFixed(2) }</span>
                </div>
              </h4>
              <h4 className="ui left floated header">
                <div className="sub header">Change</div>
                <span id="dollar-sign">$</span>
                  <span id="change-due">
                    { parseFloat(this.state.change).toFixed(2) }
                  </span>
              </h4>
            </div>
            <div className="ui attached clearing segment">
              <div className="ui fluid buttons">
                <div className="ui red button">
                  <i className="cancel icon"></i> Cancel
                </div>
                <div className="ui green button">
                  <i className="check icon"></i> Charge $ <span id="total">{ parseFloat(this.state.total).toFixed(2) }</span>
                </div>
              </div>
            </div>

            {this.props.tickets.map(function(ticket, index) {
              return (
                <TicketList ticket={ticket} key={index} />
              )
            })}

          </div>
        )
    }
}
