<template>
  <div class="ui grid" style="margin-top: 2rem">
    <div v-show="events.length > 0" class="ui four wide column" v-for="event in events" :key="event.id">
      <img class="ui medium centered image" :src="event.show.cover" :alt="event.show.name">
      <div class="ui centered header" style="margin-top: 0.5rem">
        <div class="content">
          {{ moment(event.start).calendar() }}
          <div class="sub header">
            <div class="ui blue label">{{ event.show.type }}</div>
            <div class="ui red label">{{ event.type }}</div>
          </div>
          <div class="sub header">
            <div class="ui label" v-for="ticket in event.allowedTickets">$ {{ parseFloat(ticket.price) }} / {{ ticket.name }}</div>
          </div>
          <div class="sub header">{{ event.seats }} seats left</div>
        </div>
      </div>
    </div>
    <div v-show="events.length <= 0" class="ui sixteen wide column">
      <div class="ui info icon floating massive message">
        <i class="info circle icon"></i>
        <div class="content">
          <div class="header">No events</div>
          <p>No events coming up in the next 7 days. Please check back soon!</p>
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
  created() {
    this.fetchEvents()
    setInterval(() => this.fetchEvents(), 10000)
  },
  methods: {
    fetchEvents() {
      // Last seven days
      let start = moment().format('YYYY-MM-DD')
      let end = moment().add(7, 'days').format('YYYY-MM-DD')
      axios.get(`/api/events/${start}/${end}`)
        .then(response => this.events = response.data)
    }
  }
})

</script>

<style>
</style>
