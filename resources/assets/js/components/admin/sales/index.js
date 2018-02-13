import React, { Component } from 'react'
import moment from 'moment'
import ReactDOM from 'react-dom'
import { Dimmer, Loader } from 'semantic-ui-react'

class Sales extends Component {
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
      .then((sales) => this.setState({ sales: sales, isLoading: false}))
      .catch((error) => console.log(error))
  }

  componentDidMount() {
    this.getSales()
    setInterval(() => this.getSales, 5000)
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
      return (
        <div>
        <table className="ui selectable striped single line very compact table">
          <thead>
            <tr>
              <th>Sale #</th>
              <th>Customer</th>
              <th>Total</th>
              <th>Balance</th>
              <th>Status</th>
              <th>Created by</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            { sales.map((sale) => <SaleItem data={sale} key={sale.id} />) }
          </tbody>
        </table>
        </div>
      )
    }
  }
}

class SaleItem extends Component {
  constructor(props) {
    super(props)
    this.state = { data: [] }
  }

  render() {
    let sale = this.props.data
    return (
      <tr>
        <td><h3 className="ui center aligned header">{ sale.id }</h3></td>
        <td>{ sale.customer_id }</td>
        <td>$ { parseFloat(sale.total).toFixed(2) }</td>
        <td></td>
        <td>{ sale.status }</td>
        <td>{ sale.creator_id }</td>
        <td>
          <div className="ui icon buttons">
            <a href="/admin/sales/{sale.id}" className="ui secondary button"><i className="eye icon"></i></a>
            <a href={ "/admin/sales/" + sale.id + "/edit"} className="ui primary button"><i className="edit icon"></i></a>
          </div>
        </td>
      </tr>
    )
  }
}

if (document.getElementById('sales-index')) {
  ReactDOM.render(<Sales />, document.getElementById('sales-index'))
}
