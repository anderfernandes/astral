import React, { Component } from 'react'
import ReactDOM from 'react-dom'

export default class SaleCard extends Component {
    constructor(props) {
      super(props)
      this.state = {
         settings: []
      }
    }
    componentDidMount() {
      axios.get('/api/settings')
        .then(response => { this.setState({ settings: response.data[0] })})
        .catch(function(error) {
          console.log(error)
        })
    }
    render() {
        return (
          <div className="ui segments">
            <div className="ui top attached segment">
              <div className="ui form">
                <div className="field">
                <label>Tendered</label>
                <div className="ui massive fluid labeled input">
                  <div className="ui label">$</div>
                  <input type="text" size="1" value={0}/>
                </div>
                </div>
              </div>
            </div>
            <div className="ui attached clearing segment">
              <h4 className="ui right floated header">
                Subtotal = $ <span id="subtotal">0.00</span>
                <div className="sub header">{this.state.settings.tax}% Tax = $ <span id="tax">0.00</span></div>
              </h4>
              <h4 className="ui left floated header">
                <div className="sub header">Change Due</div>
                <span id="dollar-sign">$</span> <span id="change-due">0.00</span>
              </h4>
            </div>
            <div className="ui attached clearing segment">
              <div className="ui fluid buttons">
                <div className="ui red button">
                  <i className="cancel icon"></i> Cancel
                </div>
                <div className="ui green button">
                  <i className="check icon"></i> Charge $ <span id="total">0.00</span>
                </div>
              </div>
            </div>
          </div>
        )
    }
}
