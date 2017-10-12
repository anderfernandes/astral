import React, { Component } from 'react'

export default class LoadingCard extends Component {
  render() {
    return(
      <div className="ui active inverted dimmer">
        <div className="ui text loader">Loading...</div>
      </div>
    )
  }
}
