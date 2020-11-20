<template>
  <div id="event" v-if="!loading">

    <div class="ui icon error message" v-show="event.seats_available <= 0">
      <i class="exclamation circle icon"></i>
      <div class="content">
        <div class="header">Sold out</div>
        <p>We are sold out for this show.</p>
      </div>
    </div>

    <div class="ui icon warning message" v-show="seats_ratio < 0.25 && seats_ratio > 0 ">
      <i class="info circle icon"></i>
      <div class="content">
        <div class="header">Few seats left!</div>
        <p>We only have {{ event.seats_available }} {{ event.seats_available == 1 ? "seat" : "seats" }}</p>
      </div>
    </div>
    
    <router-link to="/" class="ui basic black button">
      <i class="chevron left icon"></i> Back
    </router-link>

    <h2 class="ui dividing header">
      <div class="content">
        {{ event.show.name }}
        <div class="ui black label">
          {{ event.type.name }}
        </div>
        <div class="ui black label">
          {{ event.show.type }}
        </div>
      </div>
      <div class="sub header" style="margin-top:0.5rem; margin-left:-0.5rem">
        <div class="ui basic black label">
          <i class="calendar alternate icon"></i>
          {{ format(event.start, "dddd, MMMM d [@] h:mm A") }}
          ({{ distanceInWordsToNow(event.start, { addSuffix: true }) }})
        </div>
        <div class="ui basic black label">
          <i class="user outline icon"></i>
          {{ event.seats_available }} 
          {{ event.seats_available == 1 ? "seat" : "seats" }} available
        </div>
      </div>
    </h2>

    <div class="ui stackable grid">

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

    <div class="ui four doubling link cards" v-if="(tickets.length > 0) && (event.seats_available > 0)">

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
              <button style="width:36px" class="circular ui basic green icon button" :disabled="event_tickets >= event.seats_available" @click="ticket.amount++">
                <i class="plus icon"></i>
              </button>
            </div>
            <div class="column">
              <h1 class="ui center aligned header">
                {{ ticket.amount }}
              </h1>
            </div>
            <div class="column">
              <button style="width:36px" class="ui basic yellow circular icon button" :disabled="ticket.amount <= 0" @click="ticket.amount--">
                <i class="minus icon"></i>
              </button>
            </div>
          </div>
        </div>
      </div>

    </div>

    <div class="ui info icon message" v-show="event_tickets >= event.seats_available">
      <i class="info circle icon"></i>
      <div class="content">
        <div class="header">You have reached the number of tickets available!</div>
        <p>You can't add more tickets to this event.</p>
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

      },

      seats_ratio() {

        return this.event.seats_available / this.event.seats

      },

      event_tickets() {

        return this.tickets.reduce((total, ticket) => total + ticket.amount, 0)


      }

    },

    methods: {

      async fetchEvent() {

        try {
          
          const response = await fetch(`/api/public/events/${this.id}`)
          
          const ev = await response.json()
          
          this.event = ev.data
          
          /*this.tickets = ev.data.type.allowed_tickets
            .filter(ticket => ticket.price > 0)
            .map(ticket => Object.assign(ticket, { amount: 0 }))*/

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
          tickets: this.event.type.allowed_tickets.filter(t => t.public && (t.price > 0)).map(t => ({
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