<template>
  <div id="home">
    <div id="event" v-for="(day, i) in events" :key="i">
      <h3 class="ui dividing header">
        <i class="calendar alternate icon"></i>
        <div class="content">
          {{ format(new Date(day.date), "dddd, MMMM d") }}
          ({{ isToday(day.date) ? "Today" : distanceInWordsToNow(new Date(day.date), { addSuffix: true }) }})
        </div>
      </h3>
      <div class="ui four doubling link cards">
        <router-link class="card" v-for="event in day.events" :key="event.id" :to="({ name: 'event', params: { id: event.id }})">
          <div class="image">
            <img :src="event.show.cover" :alt="event.name">
          </div>
          <div class="content">
            <div class="meta" style="margin-bottom:1rem">
              <div class="ui basic black label">
                <i class="clock icon"></i>
                {{ format(event.start, 'h:mm A') }}
              </div>
              <div class="ui basic black label">
                <i class="user outline icon"></i>
                {{ event.seats_available }} 
                {{ event.seats_available == 1 ? "seat" : "seats" }} available
              </div>
            </div>
            <div class="header">{{ event.show.name }}</div>
            <div class="description">
              <div class="ui black label">{{ event.type.name }}</div>
              <div class="ui black label">{{ event.show.type }}</div>
            </div>
          </div>
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>

import { createNamespacedHelpers } from 'vuex'

const { mapState, mapActions } = createNamespacedHelpers('Public')

import { format, distanceInWordsToNow, isToday } from 'date-fns'

export default {

  data: () => ({
    loading: true,
  }),

  computed: mapState({
    
    events: state =>state.events,

  }),

  methods: {

    ...mapActions(['fetchEvents']),

    format,

    distanceInWordsToNow,

    isToday,

  },

  async mounted() {

    this.loading = true
    
    await this.fetchEvents()
    
    this.loading = false

  }

}
</script>