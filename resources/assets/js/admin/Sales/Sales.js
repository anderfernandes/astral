import React, { Component } from 'react'
import ReactDOM from 'react-dom'
import { Dimmer, Loader, Button, Form, Dropdown } from 'semantic-ui-react'

class Sales extends Component {
  constructor() {
    super()
    this.state = {
      isLoading: true,
      sales: [],
      eventTypes: [],
      staff: [],
    }
  }

  fetchSales() {
    fetch('/api/sales')
      .then((response) => response.json())
      .then((sales) => this.setState({ sales: sales, isLoading: false}))
      .catch((error) => console.log(error))
  }

  fetchEventTypes() {
    fetch('/api/event-types')
      .then((response) => response.json())
      .then((eventTypes) => this.setState({ eventTypes: eventTypes}))
      .catch((error) => console.log(error))
  }

  componentDidMount() {
    this.fetchSales()
    this.fetchEventTypes()
    setInterval(() => this.fetchSales(), 5000)
  }

  render() {
    let sales = this.state.sales
    let isLoading = this.state.isLoading
    let eventTypes = this.state.eventTypes
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
          <FilterSalesForm data={sales} />
        </div>
      )
    }
  }
}

class SaleItem extends Component {
  constructor(props) {
    super(props)
    this.state = { }
  }

  setStatusLabelColor(status) {
    let color = 'black'
    switch(status) {
      case 'open'     : color = 'ui blue label';   break;
      case 'complete' : color = 'ui green label';  break;
      case 'no show'  : color = 'ui orange label'; break;
      case 'tentative': color = 'ui yellow label'; break;
      case 'canceled' : color = 'ui red label';    break;
      default: color = black
    }

    return color
  }

  setStatusLabelIcon(status) {
    let color = 'check'
    switch(status) {
      case 'open'     : color = 'unlock icon';   break;
      case 'complete' : color = 'checkmark icon';  break;
      case 'no show'  : color = 'thumbs outline down icon'; break;
      case 'tentative': color = 'help icon'; break;
      case 'canceled' : color = 'remove icon';    break;
      default: color = black
    }

    return color
  }

  render() {
    let sale = this.props.data

    return (
      <tr>
        <td><h3 className="ui center aligned header">{ sale.id }</h3></td>
        <td>
          <h4 className="ui header">{ sale.customer }
            {sale.sellToOrganization ? <div className="sub header"> { sale.organization }</div> : null }
          </h4>
        </td>
        <td>$ { parseFloat(sale.total).toFixed(2) }</td>
        <td>$ { sale.balance <= 0 ? parseFloat(0).toFixed(2) : parseFloat(sale.balance).toFixed(2) }</td>
        <td>
        <div className={ this.setStatusLabelColor(sale.status) }>
          <i className={ this.setStatusLabelIcon(sale.status) }></i>
          { sale.status }</div>
        </td>
        <td>{ sale.creator }</td>
        <td>
          <div className="ui icon buttons">
            <a href={ "/admin/sales/" + sale.id} className="ui secondary button"><i className="eye icon"></i></a>
            <a href={ "/admin/sales/" + sale.id + "/edit"} className="ui primary button"><i className="edit icon"></i></a>
          </div>
        </td>
      </tr>
    )
  }
}

class FilterSalesForm extends Component {
  constructor(props) {
    super(props)
    this.state = {
      data: this.props.data,
      number: '',
      customer: '',
      organization: '',
      status: '',
      creator: '',
    }
  }

  checked = (e) => { this.setState({ multiple: e.target.value }) }
  filterItems = (val, type) => {
    switch(type) {
      case 'number': this.setState({ number: val }); break;
      case 'customer': this.setState({ customer: val }); break;
      case 'organization': this.setState({ organization: val }); break;
      case 'status': this.setState({ status: val }); break;
      case 'creator': this.setState({ creator: val }); break;
      default: break;
    }
  }

  componentDidMount() {
    this.setState({status: 'open'})
  }

  render() {
    let filteredItems = this.props.data
    let state = this.state
    let filterProperties = ['number', 'customer', 'organization', 'status', 'creator']
    filterProperties.forEach(function(filterBy) {
      let filterValue = state[filterBy]
      if (filterValue) {
        filteredItems = filteredItems.filter(function(item) {
          // Object problems: item.customer.name for example...
          return item[filterBy].toLowerCase().match(filterValue.toLowerCase())
        })
      }
    })

    let numberArray = this.props.data.map(item => { return item.id })
    let customerArray = this.props.data.map(item => { return item.customer })
    let organizationArray = this.props.data.map(item => { return item.organization })
    let statusArray = this.props.data.map(item => { return item.status })
    let creatorArray = this.props.data.map(item => { return item.creator })

    numberArray.unshift('')
    customerArray.unshift('')
    organizationArray.unshift('')
    statusArray.unshift('')
    creatorArray.unshift('')

    return (
      <div>
        <FilterSalesOptions
          data={this.state.data}
          numberOptions={numberArray}
          customerOptions={customerArray}
          statusOptions={statusArray}
          creatorOptions={creatorArray}
          changeOption={this.filterItems}
          />
          <FilterSalesItems data={filteredItems} />
      </div>
    )
  }
}

class FilterSalesItems extends Component {
  render() {
    let data = this.props.data
    if (data.length > 0) {
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
              { data.map((item) => <SaleItem data={item} key={item.id} />)
              }
            </tbody>
          </table>
        </div>
      )
    }
    else {
      return (
        <div className="ui icon red message">
          <i className="warning circle icon"></i>
          <div className="content">
            <div className="header">Oops... Nothing found.</div>
            <p>Your search has returned no results.</p>
          </div>
        </div>
      )
    }
  }
}

class FilterSalesOptions extends Component {
  constructor() {
    super()
    this.state = {
      staff: []
    }
  }
  changeOption = (type, e) => {
    let val = e.target.value
    this.props.changeOption(val, type)
  }

  fetchStaff() {
    fetch('/api/staff')
      .then((response) => response.json())
      .then((staff) => this.setState({ staff: staff }))
      .catch((error) => console.log(error))
  }

  getStaff() {
    let staff = this.state.staff.map(staff => ({ firstname: staff.firstname, value: staff.id }))
    staff.unshift({ firstname: 'All', value: '' })
    return staff
  }

  componentDidMount() {
    this.fetchStaff()
  }

  render() {
    let statuses = [
      { text: 'All'       ,  value: ''         , icon: 'announcement'         },
      { text: 'Open'      ,  value: 'open'     , icon: 'unlock'               },
      { text: 'Complete'  ,  value: 'complete' , icon: 'check'                },
      { text: 'No Show'   ,  value: 'no show'  , icon: 'thumbs outline down'  },
      { text: 'Tentative' ,  value: 'tentative', icon: 'help'                 },
      { text: 'Canceled'  ,  value: 'canceled' , icon: 'remove'               },
    ]

    let staff = this.getStaff()

    return (
      <div className="ui form">
        <div className="four fields">
          <div className="field">
            <input value={ this.props.customer } onChange={ this.changeOption.bind(this, 'customer') } placeholder="Customer" />
          </div>
          <div className="field">
            <input value={ this.props.organization } onChange={ this.changeOption.bind(this, 'organization') } placeholder="Organization" />
          </div>
          <div className="field">
            <select id="status" defaultValue="open" onChange={ this.changeOption.bind(this, 'status') }>
              { statuses.map((status, index) => <option key={index} value={status.value}>{status.text}</option>) }
            </select>
          </div>
          <div className="field">
            <select id="creator" defaultValue="" onChange={ this.changeOption.bind(this, 'creator') }>
              { staff.map((person, index) => <option key={index} value={person.firstname}>{person.firstname}</option>) }
            </select>
          </div>
        </div>
      </div>
    )
  }
}

if (document.getElementById('sales-index')) {
  ReactDOM.render(<Sales />, document.getElementById('sales-index'))
}
