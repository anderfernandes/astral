<template>
  <div class="ui fluid container" v-if="isLoaded">
    <div class="ui grid">
      <div class="sixteen wide column">
        <br /><br />
        <div class="ui horizontal divider">
          Future Shows
        </div>
        <div class="ui four raised cards">
          <div class="card" :key="event.id" v-for="event in events">
            <div class="image">
              <img :src="event.show.cover">
            </div>
            <div class="content">
              <div class="header">
                {{ event.memo || event.show.name }}
              </div>
              <div class="description">
                {{ moment(event.start).format("dddd, MMMM D, YYYY [at] h:mm A") }}
                ({{ moment(event.start).fromNow() }})
              </div>
            </div>
            <div class="extra content">
              <div class="ui large blue label" v-if="event.show.type != 'No Type'">
                {{ event.show.type }}
              </div>
              <div class="ui large label" :style="{ backgroundColor : event.color, color: 'white'}">
                {{ event.type }}
              </div>
              <div class="ui large basic blue label">
                {{ event.seats }} seats left
              </div>
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
  name: "Upcoming",
  data() {
    return {
      events  : [],
      isLoaded: false,
    }
  },
  created() {
    this.fetchEvents()
  },
  methods: {
    async fetchEvents() {
      // Last seven days
      let start = moment().subtract(30, 'minutes').format()
      let end   = moment().endOf('day').format()
      const response = await axios.get(`/api/events/${start}/${end}`)
      // Update data only if there are updates
      if (this.events != response.data)
        this.events = response.data.slice(1, 5)
      // Let the component know that data has been loaded
      this.isLoaded = true
    }
  }
})
</script>

<style>
  .ui.massive.header { font-size: 4em   }
</style>