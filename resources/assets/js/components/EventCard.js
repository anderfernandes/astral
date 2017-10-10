import React, { Component } from 'react'
import ReactDOM from 'react-dom'
import moment from 'moment'

export default class EventCard extends Component {
    render() {
      let event = this.props.event
        return (
          <div className="ui eight wide column">
            <div className="ui unstackable items">
              <div className="item">
                <div className="ui tiny rounded image">
                  <img src={event.show.cover} />
                </div>
                <div className="content">
                  <div className="header">
                    {event.show.name}
                  </div>
                  <div className="meta">
                    <div className="ui label">{event.show.type}</div>
                    <div className="ui label">{event.type}</div>
                  </div>
                  <div className="meta">{moment(event.start).calendar()} | {event.seats} seats left</div>
                  <div className="extra content">
                    <div className="ui buttons">
                      <div className="ui inverted green button">Adult</div>
                      <div className="ui inverted red icon button"><i className="minus icon"></i></div>
                    </div>
                    <div className="ui buttons">
                      <div className="ui inverted green button">Child</div>
                      <div className="ui inverted red icon button"><i className="minus icon"></i></div>
                    </div>
                    <div className="ui buttons">
                      <div className="ui inverted green button">Member</div>
                      <div className="ui inverted red icon button"><i className="minus icon"></i></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        )
    }
}
