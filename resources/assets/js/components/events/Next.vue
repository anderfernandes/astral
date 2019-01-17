<template>
  <div class="ui container" v-if="isLoaded">
    <div class="ui grid">
      <div class="sixteen wide column">
        <br /><br />
        <div class="ui horizontal divider">
          Next Show
        </div>
      </div>
    </div>
    <div class="ui grid">
      <div class="five wide column">
        <img :src="event.show.cover" class="ui large image" alt="">
      </div>
      <div class="eleven wide column">
        <div class="ui basic blue large label">
          <i class="clock outline icon"></i>
          {{ moment(event.start).format("dddd, MMMM D, YYYY [at] h:mm A") }}
          <div class="detail">
            ({{ moment(event.start).fromNow() }})
          </div>
        </div>
        <div v-if="moment(event.start).diff(moment(), 'minutes') <= 15" class="ui huge black label">
          Now Seating
        </div>
        <div class="ui blue large label">
          {{ event.show.type }}
        </div>
        <div class="ui large label" :style="{ backgroundColor : event.color, color: 'white'}">
          {{ event.type }}
        </div>
        <div class="ui basic large blue label">
          {{ event.seats }} seats left
        </div>
        <div class="ui massive dividing header">
          {{ event.show.name }}
        </div>
        <div class="ui large header">
          <div class="sub header" v-html="marked(event.show.description)" style="font-size:0.75em"></div>
        </div>
        <div class="ui divider"></div>
        <div v-for="ticket in event.allowedTickets" :key="ticket.id" class="ui large green tag label">
          $ {{ parseFloat(ticket.price).toFixed(2) }} / {{ ticket.name }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import axios from 'axios'

export default ({
  name: "Next",
  data() {
    return {
      event: "",
      isLoaded: false,
    }
  },
  created() {
    this.fetchEvents()
  },
  methods: {
    async fetchEvents() {
      // Next seven days
      let start = moment().format('YYYY-MM-DD')
      let end   = moment().add(7, 'days').format('YYYY-MM-DD')
      const response = await axios.get(`/api/events/${start}/${end}`)
      // Update data only if there are updates
      if (this.event != response.data[0])
        this.event = response.data[0]
      // Let the component know that data has been loaded
      this.isLoaded = true
    }
  }
})

</script>

<style>
  .ui.massive.header { font-size: 4em   }
</style>
