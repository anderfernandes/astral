<template>
  <div id="event" v-if="!loading">
    
    <router-link to="/" class="ui basic black button">
      <i class="chevron left icon"></i> Back
    </router-link>

    <h3 class="ui dividing header">
      <div class="content">
        {{ event.show.name }}
        <div class="ui black label">
          {{ event.type.name }}
        </div>
        <div class="ui black label">
          {{ event.show.type }}
        </div>
        <div class="sub header">
          <i class="calendar alternate icon"></i>
          {{ format(event.start, "dddd, MMMM d [@] h:mm A") }}
          ({{ distanceInWordsToNow(event.start, { addSuffix: true }) }})
        </div>
      </div>
    </h3>

    <div class="ui grid">

      <div class="four wide column">
        <img :src="event.show.cover" :alt="event.show.name" class="ui fluid image">
      </div>

      <div class="twelve wide column">
        <h1 class="ui header">
          <div class="sub header">
            {{ event.show.description }}
          </div>
        </h1>
      </div>

    </div>

    <div class="ui four doubling link cards" v-if="tickets.length > 0">

      <div class="card" v-for="ticket in tickets" :key="ticket.id">
        <div class="content">
          <div class="header">
            {{ ticket.name }}
            <div class="right floated meta">
                <div class="ui green tag label">$ {{ ticket.price }}</div>
            </div>
          </div>
        </div>
        <div class="extra content">
          <div class="ui three column grid">
            <div class="column">
              <div class="ui basic green circular icon button" @click="ticket.amount++">
                <i class="plus icon"></i>
              </div>
            </div>
            <div class="column">
              <h1 class="ui center aligned header">
                {{ ticket.amount }}
              </h1>
            </div>
            <div class="column">
              <div class="ui basic yellow circular icon button" @click="ticket.amount--">
                <i class="minus icon"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>
</template>

<script>

  import { format, distanceInWordsToNow } from 'date-fns'

  export default {
    
    props: ['id'],

    data: () => ({

      loading: true,
    
      event: {},

    }),

    computed: {

      tickets: {

        get() { 

          const sale = this.$store.state.Public.sale.find(item => item.event.id == this.id)
            
          return sale.tickets
          

        },

        // a setter here is misteriously not necessary...
        set(value) { /*console.log(value)*/ }

      },

      sale() {

        return this.$store.state.Public.sale

      }

    },

    methods: {

      async fetchEvent() {

        try {
          
          const response = await fetch(`/api/public/events/${this.id}`)
          
          const ev = await response.json()
          
          this.event = ev.data
          
          this.tickets = ev.data.type.allowed_tickets
            .filter(ticket => ticket.public)
            .map(ticket => Object.assign(ticket, { amount: 0 }))

        } catch (e) {
          
          alert(`Error in fetchEvent: ${e}`)

        }

      },

      saveTickets() {

        const item = this.sale.find(i => i.event.id == this.id)

        this.$store.commit('Public/SET_TICKETS', {
          event: {
            id: this.id,
            type: this.event.type,
            show: {
              id: this.event.show.id,
              name: this.event.show.name,
              cover: this.event.show.cover,
              type: this.event.show.type,
              duration: this.event.show.duration
            },
            start: this.event.start,
          },
          tickets: this.tickets.map(t => ({
            id: t.id,
            name: t.name,
            amount: t.amount,
            price: t.price,
            name: t.name,
            event_id: this.id,
          }))
        })

      },
      
      format,

      distanceInWordsToNow,

    },

    async mounted() {

      this.loading = true

      await this.fetchEvent()

      if (!this.sale.find(item => item.event.id == this.id)) {
        this.$store.commit('Public/SET_TICKETS', {
          event: {
            id: this.id,
            type: this.event.type,
            show: {
              id: this.event.show.id,
              name: this.event.show.name,
              cover: this.event.show.cover,
              type: this.event.show.type,
              duration: this.event.show.duration
            },
            start: this.event.start,
          },
          tickets: this.event.type.allowed_tickets.filter(t => t.public).map(t => ({
            id: t.id,
            name: t.name,
            amount: 0,
            price: t.price,
            name: t.name,
            event_id: this.id,
          }))
        })
      }
        
      this.loading = false

    },

    //beforeDestroy() { this.saveTickets() }
  }
</script>