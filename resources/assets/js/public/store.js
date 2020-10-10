import Vue from "vue"
import Vuex from "vuex"

Vue.use(Vuex)

const currencySettings = { minimumFractionDigits: 2, maximumFractionDigits: 2 }

let getDefaultState = () => ({
  settings: {},
  events: [],
  sale: [], // object of events and array of tickets for the event, ticket_id, price and count
  customer_id: 1,
  count: 0
})

export default {

  namespaced: true,

  state: getDefaultState(),

  mutations: {
    
    SET_SETTINGS(state, payload) {
      Object.assign(state, { settings: payload })
    },

    SET_EVENTS(state, payload) {
      Object.assign(state, { events: payload })
    },
    
    SET_TICKETS(state, payload) {
      const event_exists = state.sale.some(item => item.event.id == payload.event.id)
      if (event_exists) {
        const index = state.sale.findIndex(event => event.id == payload.id)
        state.sale.splice(index, 1, payload)
      } else
      state.sale.push(payload)
      
      payload.tickets.forEach(ticket => { if (ticket.amount > 0) state.count++ })
    },

  },

  actions: {
    
    async fetchSettings({ commit }) {
      try {
        const response = await fetch('/api/public/home')
        const settings = await response.json()
        commit('SET_SETTINGS', settings.data)
      } catch (e) {
        alert(`Error in fetchSettings: ${e}`)
      }

    },

    async fetchEvents({ commit }) {
      try {
        const response = await fetch('/api/public/events')
        const events = await response.json()
        commit('SET_EVENTS', events.data)
      } catch (e) {
        alert(`Error in fetchEvents: ${e}`)
      }
    }

  },

  getters: {

    count: state => {
      let count = 0;
      state.sale.forEach(e => {
        // Counting tickets
        let temp = 0
        e.tickets.forEach(t => {
          temp += t.amount
        })
        count += temp
      })
      return count
    },

    subtotal: state => {
      
      let subtotal = 0
      
      state.sale.forEach(item => subtotal += item.tickets.reduce((acummulator, ticket) => acummulator + (ticket.amount * ticket.price), 0))
      
      return subtotal.toLocaleString('en-US', currencySettings)
    },

    tax: (state, getters) => {

      const tax_rate = parseFloat(state.settings.tax) / 100
      
      const tax = tax_rate * parseFloat(getters.subtotal)

      return tax.toLocaleString('en-US', currencySettings)

    },

    total: (state, getters) => {

      const subtotal = parseFloat(getters.subtotal)

      const tax = parseFloat(getters.tax)

      const total = subtotal + tax

      return total.toLocaleString('en-US', currencySettings)

    },

    gateway_key: state => state.settings.gateway_public_key,

  }

}