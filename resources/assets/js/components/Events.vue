<template>
  <div class="ui grid">
    <div class="row">
      <div class="column">
        <div class="ui items" style="margin-top:0">
          <div class="item" style="width:100vw">
            <div class="ui medium rounded image">
              <img :src="nextEvent.show.cover" alt="">
            </div>
            <div class="content">
              <div class="ui huge header">
                {{ nextEvent.show.name }}
              </div>
              <div class="meta">
                <div v-if="moment(nextEvent.start).diff(moment(), 'minutes') <= 15" class="ui large black label">Now Seating</div>
                <div class="ui large blue label">{{ nextEvent.show.type }}</div>
                <div class="ui basic large label">
                  <i class="clock outline icon"></i>
                  {{ moment(nextEvent.start).format("dddd, MMMM D, YYYY [at] h:mm A") }}
                  <div class="detail">({{ moment(nextEvent.start).fromNow() }})</div>
                </div>
                <div class="ui large blue label">{{ nextEvent.seats }} seats left</div>
              </div>
              <div class="description">
                <div class="ui huge header">
                  <div class="sub header" v-html="marked(nextEvent.show.description)"></div>
                </div>
              </div>
              <div class="description">
                <div v-for="ticket in nextEvent.allowedTickets" class="ui large green tag label">
                  $ {{ parseFloat(ticket.price).toFixed(2) }} / {{ ticket.name }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="column">
        <div class="ui five cards">
          <div class="card" v-for="event in upcomingEvents">
            <div class="image"><img :src="event.show.cover" alt=""></div>
            <div class="ui black top right attached label">
              <i class="clock outline icon"></i>{{ moment(event.start).calendar() }}
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</template>

<script>

import axios from 'axios'

export default ({
  name: 'Events',
  data() {
    return {
      events: [],
    }
  },
  mounted() {
    this.fetchEvents()
    setInterval(() => this.fetchEvents(), 10000)
  },
  computed: {
    nextEvent() {
      if (this.events.length > 0)
        return this.upcomingEvents.shift()
      else
        return []
    },
    upcomingEvents() {
      let now = moment().subtract(15, 'minutes')
      // Get shows with start time less thasn 15 minutes past their start time
      let upcomingEvents = this.events.filter(event => moment(event.start).isAfter(now))
      return upcomingEvents.slice(0, 6)
    }
  },
  methods: {
    async fetchEvents() {
      // Last seven days
      let start = moment().format('YYYY-MM-DD')
      let end = moment().add(7, 'days').format('YYYY-MM-DD')
      const response = await axios.get(`/api/events/${start}/${end}`)
      this.events = response.data
    }
  }
})

</script>

<style>
</style>
