import React, { Component } from 'react'

export default class Message extends Component {
  render() {
    return (
      <div className="ui info icon message">
        <i className={this.props.icon + " icon"}></i>
        <div className="content">
          <div className="header">
            {this.props.header}
          </div>
          <p>{this.props.message}</p>
        </div>
      </div>
    )
  }
}
