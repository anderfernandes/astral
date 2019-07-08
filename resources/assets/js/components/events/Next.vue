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
      <div class="six wide column">
        <div class="ui fluid large image">
          <div v-if="moment(event.start).diff(moment(), 'minutes') <= 15 && !moment().isAfter(event.start)" class="ui green ribbon label">
            <i class="thumbs up icon"></i>
            Now Seating
          </div>
          <div v-else-if="moment().isAfter(event.start)" class="ui blue ribbon label">
            <i class="play icon"></i>
            Now Playing
          </div>
          <img :src="event.show.cover" :alt="event.show.name">
        </div>
      </div>
      <div class="ten wide column">
        <div class="ui basic blue large label">
          <i class="clock outline icon"></i>
          {{ moment(event.start).format("dddd, MMMM D, YYYY [at] h:mm A") }}
          <div class="detail">
            ({{ moment(event.start).fromNow() }})
          </div>
        </div>
        <div class="ui blue large label" v-if="event.show.type != 'No Type'">
          {{ event.show.type }}
        </div>
        <div class="ui large label" :style="{ backgroundColor : event.color, color: 'white'}">
          {{ event.type }}
        </div>
        <div class="ui basic large blue label">
          {{ event.seats }} seats left
        </div>
        <div class="ui massive dividing header">
          {{ event.memo || event.show.name }}
        </div>
        <div class="ui large header" v-if="event.show.name != 'No Show'">
          <div class="sub header" v-html="marked(event.show.description)" style="font-size:0.75em"></div>
        </div>
        <div class="ui divider" v-if="event.show.name != 'No Show'"></div>
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
      let start = moment().subtract(30, 'minutes').format()
      let end   = moment().add(7, 'days').endOf('day').format()
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