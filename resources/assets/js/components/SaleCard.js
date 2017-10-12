import React, { Component } from 'react'

export default class SaleCard extends Component {
    constructor(props) {
      super(props)
      this.state = {
         settings: [],
         customers: [],
         subtotal: 0,
         tendered: 0,
         tax: 0,
      }
    }

    componentDidMount() {
      // Get Customers
      axios.get('/api/customers')
        .then(response => { this.setState({ customers: response.data})})
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
                <div className="sub header">{ this.state.settings.tax }% Tax = $ <span id="tax">{ parseFloat(this.state.tax).toFixed(2) }</span></div>
              </h4>
              <h4 className="ui left floated header">
                <div className="sub header">Change Due</div>
                <span id="dollar-sign">$</span> <span id="change-due">{ parseFloat(this.state.tendered - (this.state.subtotal + this.state.tax)).toFixed(2) }</span>
              </h4>
            </div>
            <div className="ui attached clearing segment">
              <div className="ui fluid buttons">
                <div className="ui red button">
                  <i className="cancel icon"></i> Cancel
                </div>
                <div className="ui green button">
                  <i className="check icon"></i> Charge $ <span id="total">{ parseFloat(this.state.subtotal + this.state.tax).toFixed(2) }</span>
                </div>
              </div>
            </div>
          </div>
        )
    }
}
