<template>
  <sui-segment inverted :loading="isLoading">
    
    <div class="ui inverted horizontal divider header" v-if="event_type && event_type.name">
      <i class="calendar check icon"></i> Event # {{ $vnode.key + 1 }} | 
      {{ event_type.name }}
    </div>
    
    <div class="required field">
      <label for="date">Date</label>
      <div class="ui left icon input">
        <i class="calendar alternate outline icon"></i>
        <flatpickr placeholder="Date" v-model="date" :config="flatpickrConfig" />
      </div>
    </div>

    <div class="required field" v-if="eventOptions">
      <label for="event">Event</label>
      <sui-dropdown fluid selection direction="upward"
                    v-model="event" 
                    :options="eventOptions" 
                    :placeholder="placeholder" />
    </div>

    <transition appear mode="out-in" name="fade">
      <div class="ui inverted segment" v-if="!isLoading && selected_event != null">
        <div class="ui items">
          <div class="item">
            <div class="image">
              <img :src="selected_event.show.cover" :alt="selected_event.show.name">
            </div>
            <div class="content">
              <div class="header" style="color:white">
                {{ selected_event.show.name }}
              </div>
              <div class="meta">
                <p style="color:white">
                  <i class="calendar alternate icon"></i>
                  {{ format(new Date(selected_event.start), $dateFormat.long) }}
                  ({{ distanceInWordsToNow(new Date(selected_event.start), { addSuffix: true }) }})
                </p>
                <div class="ui divider"></div>
              </div>
              <div class="meta">
                <div class="ui inverted header">
                  <div class="ui basic label" style="margin-left:0">
                    {{ selected_event.show.type }}
                  </div>
                  <div class="ui basic label">
                    {{ selected_event.type.name }}
                  </div>
                  <div class="ui basic label">
                    {{ selected_event.show.duration }} minutes
                  </div>
                  <div class="ui basic label">
                    {{ selected_event.seats }} {{ selected_event.seats == 1 ? 'seat' : 'seats' }} available
                  </div>
                </div>
              </div>
              <div class="description">
                <div class="ui divider"></div>
                <p style="color:white">{{ selected_event.show.description }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </transition>

    <transition appear mode="out-in" name="fade">
      <div class="required field" v-if="event">
        <label>Tickets</label>
        <sui-dropdown fluid selection direction="upward" v-if="ticketOptions && ticketOptions[0] && ticketOptions[0].hasOwnProperty('icon')"
                      multiple 
                      placeholder="Select tickets"
                      :options="ticketOptions"
                      v-model="tickets"
        />
      </div>
    </transition>

    <transition appear mode="out-in" name="fade">
      <table class="ui selectable single line very compact fixed table" v-if="tickets && tickets.length > 0">
        <thead>
          <tr class="header">
            <th>Ticket</th>
            <th>Amount / Price</th>
            <th></th>
          </tr>
        </thead>
        <tbody name="fade" is="transition-group" appear mode="out-in">
          <tr v-for="ticket in selected_tickets" :key="ticket.id">
            <td>
              <div class="ui small header">
                <i class="ticket icon"></i>
                <div class="content">
                  {{ ticket.name }} 
                  <div class="sub header">{{ ticket.description }}</div>
                </div>
              </div>
            </td>
            <td v-if="selected_event">
              <sui-button icon="plus" color="black" basic :disabled="ticket.amount >= selected_event.seats"
                          @click.prevent="ticket.amount++" />
              <sui-button icon="refresh" color="black" basic :disabled="ticket.amount == 1"
                          @click.prevent="ticket.amount = 1" />
              <sui-button icon="minus" color="black" basic :disabled="ticket.amount == 1"
                          @click.prevent="ticket.amount--" />
              &nbsp;
              <div class="ui right labeled input">
                <input type="number" readonly
                       style="width:4rem"
                       size="2"
                       min="1"
                       :max="selected_event.seats"
                       v-model.number="ticket.amount"
                       @input="$store.commit('CALCULATE_TOTALS')" 
                       placeholder="Amount">
                <div class="ui basic label">
                  $ {{ ticket.price.toFixed(2) }} each
                </div>
              </div>
              &nbsp;
              <div class="ui red basic icon button" @click="removeTicket(ticket.id)">
                <i class="trash icon"></i>
              </div>
            </td>
            <td v-if="selected_event">
              1
              <input type="range" v-model.number="ticket.amount" min="1" :max="selected_event.seats" style="width:75%">
              {{ selected_event.seats }}
            </td>
          </tr>
        </tbody>
      </table>
    </transition>

  </sui-segment>
</template>

<script>

  import { format, distanceInWordsToNow } from 'date-fns'
  import axios     from 'axios'
  import flatpickr from 'vue-flatpickr-component'
  import 'flatpickr/dist/flatpickr.css'

  export default {
    data: () => ({
      flatpickrConfig: {
        dateFormat  : "l, F j, Y",
        defaultDate : "today",
      },
      eventOptions  : [],
      events_data   : [],
      
      ticketOptions : [],
      tickets_data  : [],
      
      isLoading     : true,
      event_type_id : null,
      event_type    : {},
    }),

    components: { flatpickr },

    watch : {
      async date() { 
        this.isLoading = true
        await this.fetchEventOptions()
        this.isLoading = false
      },
      selected_tickets: {
        handler : function() { 
          this.selected_tickets
          this.$store.commit('CALCULATE_TOTALS')
        },
        deep : true,
      },
      tickets(newValue) { 
        this.selected_tickets = newValue
      },
      event()   { 
        if (this.tickets.length > 0)
          this.selected_tickets = this.tickets 
      }
    },
    
    methods: {
      
      format,

      distanceInWordsToNow,

      // Fetch Events
      async fetchEventOptions() {
        let date = format(new Date(this.date), "YYYY-MM-DD")
        try {
          const response = await axios.get(`/api/events?start=${date}&type=${ this.event_type_id }`)
          // Array with all event objects to show in box below event selection dropdown
          this.eventOptions = response.data.map(event => {
            this.events_data.push(event)
            let time = format(new Date(event.start), "h:mm aa")
            return {
              key   : event.id,
              text  : `#${event.id} - ${event.show.id == 1 ? event.memo : event.show.name} at ${time} (${event.type.name}, ${event.seats} ${event.seats == 1 ? "seat" : "seats"} left)`,
              value : event.id,
            }
          })
          // await this.$store.dispatch("setEventOptions", { index: this.$vnode.key - 1, eventOptions: eventOptions})
        } catch (error) {
          alert(`fetchEventOptions in EventForm failed: ${ error.message }`)
        }
      },

      // Fetch Sale Tickets
      async fetchSaleTickets() {
        try {
          const response = await axios.get(`/api/sale/${this.$route.params.id}`)
          let tickets = response.data.events[this.$vnode.key - 1].tickets.map(ticket => ticket.id)
          //await this.$store.dispatch("setSelectedTickets", tickets)
          this.tickets = tickets
          // Send already existing ticket amounts to store
          tickets = response.data.events[this.$vnode.key - 1].tickets
          await this.$store.dispatch("setAvailableTickets", tickets)
          await this.$store.dispatch("updateSelectedTickets", {index: this.$vnode.key - 1, tickets})
        } catch (error) {
          alert(`fetchSaleTickets in EventForm failed: ${error.message}`)
        }
      },

      // Fetch Tickets Types
      async fetchTicketsTypes() {
        try {
          const response = await axios.get(`/api/allowedTickets?event_type=${ this.event_type_id }`)
          this.ticketOptions = response.data.data.map(ticket => {
            Object.assign(ticket, { amount: 1, event: { id: 1 } })
            this.tickets_data.push(ticket)
            return {
              key   : ticket.id,
              text  : ticket.name,
              icon  : 'ticket',
              value : ticket.id,
            }
          })
        } catch (error) {
          alert(`fetchTicketTypes in EventForm failed: ${error.message}`)
        }
      },

      // Fetch Event Types
      async fetchEventType() {
        try {
          const response = await axios.get(`/api/event-types/${ this.event_type_id }`)
          this.event_type = response.data.data

        } catch (error) {
          alert(`Unable to fetch event types: ${ error.message }`)
        }
      },

      // Remove ticket from state
      removeTicket(id) {
        this.$store.commit('REMOVE_TICKET', { index: this.$vnode.key, id })
      }
    },

    async created() {

      this.isLoading = true
      
      this.event_type_id = await this.$route.query.type

      await this.fetchTicketsTypes()

      await this.fetchEventOptions()

      await this.fetchEventType()
      
      this.isLoading = false
    },
    
    computed: {

      selected_event() { 
        if (this.events_data && this.events_data.length > 0)
          return this.events_data.find(event => event.id == this.event) 
        else 
          return null
      },

      selected_tickets: {
        set(value) { 
          const selected_tickets = this.tickets_data.filter(ticket => value.includes(ticket.id))
          selected_tickets.forEach(ticket => Object.assign( ticket.event, { id: this.event } ))
          this.$store.commit('SET_SELECTED_TICKETS', { index: this.$vnode.key, selected_tickets })
        },
        get() { return this.$store.getters.sale.selected_tickets[this.$vnode.key] || [] }
      },
      
      placeholder() {
        return (this.eventOptions) && (this.eventOptions.length == 0) 
              ? 'No events found' 
              : `${ this.eventOptions.length } ${ this.eventOptions.length == 1 ? 'event' : 'events'} found` 
      },

      date: {
        set(value) { this.$store.commit('SET_DATES', { index: this.$vnode.key, date: value }) },
        get()      { 
          const dates = this.$store.getters.sale.dates
          
          return dates[this.$vnode.key] || new Date()     
        }
      },
      
      // Replace this with mapGetters in the future, use index of event
      event: {
        set(value) { this.$store.commit('SET_EVENT', { index: this.$vnode.key, event: value }) },
        get()      { return this.$store.getters.sale.events[this.$vnode.key] || null }
      },
      
      tickets: {
        set(value) { 
          //value.event.id = this.event.id
          //value.forEach(ticket => Object.assign(ticket.event, {id: this.event } ))
          this.$store.commit('SET_TICKETS', { index: this.$vnode.key, tickets: value }) 
        },
        get()      { 
          const tickets = this.$store.getters.sale.tickets[this.$vnode.key] 
          return tickets || []
          },
      },

    },
  }
</script>

<style scope>

  input { padding-right: 0 !important }

</style>
