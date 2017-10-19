import React, { Component } from 'react'
import TicketList  from './TicketList'
import LoadingCard from './LoadingCard'
import axios       from 'axios'

export default class SaleCard extends Component {
    constructor(props) {
      super(props)
      this.state = {
         settings: [],
         customers: [],
         paymentMethods: [],
         subtotal: 0,
         tendered: 0,
         change: 0,
         tax: 0,
         total: 0,
         loading: true,
         paymentMethod: "1",
         reference: "",
         customer: "1",
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
      // Get Payment Methods
      axios.get('/api/payment-methods')
        .then(response => { this.setState({ paymentMethods: response.data })})
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

    loadPaymentMethods() {
      return this.state.paymentMethods.map(function(p, i) {
        return (
          <option value={p.id} key={i}>{p.name}</option>
        )
      })
    }

    onChangePaymentMethod(event) {
      this.setState({ paymentMethod: event.target.value })
    }

    onChangeReference(event) {
      this.setState({ reference: event.target.value })
    }

    onChangeCustomer(event) {
      this.setState({ customer: event.target.value })
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

    handleSubmit(e) {
      e.preventDefault()
      let tickets = this.props.tickets
      let sale = {
        subtotal: this.state.subtotal,
        tendered: this.state.tendered,
        change: this.state.change,
        tax: this.state.tax,
        total: this.state.total,
        paymentMethod: this.state.paymentMethod,
        reference: this.state.reference,
        customer: this.state.customer,
      }
      //axios.post("/api/new-sale", {
      //  tickets: tickets,
      //  sale: sale,
      //}).then(response => { console.log(response.data) })

      for (let i = 0; i < tickets.length; i++){
        tickets[i] = Object.assign({customerId: sale.customer}, tickets[i])
      }

      console.log(tickets)
    }

    render() {
      return (
        <form onSubmit={(e) => this.handleSubmit(e)}>
          <div className="ui segments">
            <div className="ui top attached segment">
              <div className="ui form">
                <div className="field">
                  <label>Customer</label>
                  <select onChange={(e) => this.onChangeCustomer(e)} value={this.state.customer} className="ui search scrolling dropdown">
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
              <div className="ui form">
                <div className="field">
                  <label>Payment Method</label>
                  <select onChange={(e) => this.onChangePaymentMethod(e)} value={this.state.paymentMethod} className="ui dropdown">
                    { this.loadPaymentMethods() }
                  </select>
                </div>
                <div className="field">
                  <input onChange={(e) => this.onChangeReference(e)} placeholder="Credit Card or Check reference" type="text" />
                </div>
              </div>
            </div>
            <div className="ui attached clearing segment">
              <div className="ui fluid buttons">
                <div className="ui red button">
                  <i className="cancel icon"></i> Cancel
                </div>
                <button className="ui green button">
                  <i className="check icon"></i> Charge $ <span id="total">{ parseFloat(this.state.total).toFixed(2) }</span>
                </button>
              </div>
            </div>
            <div className="ui attached segment">
              {this.props.tickets.map(function(ticket, index) {
                return (
                  <TicketList ticket={ticket} key={index} />
                )
              })}
            </div>
          </div>
        </form>
        )
    }
}
