import Vue from "vue"
import Vuex from "vuex"

Vue.use(Vuex)

let getDefaultState = () => ({
  settings: {},
  events: [],
  sale: [], // object of events and array of tickets for the event, ticket_id, price and count
  customer_id: 1,
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

    ADD_TICKET(state, { event_id, ticket }) {
      const ev = state.sale.find(e => e.id == event_id)
      const ev_index = state.sale.findIndex(e => e.id == event_id)
      if (state.sale[ev_index])
        state.sale[ev_index].tickets.push(ticket)
      else
        state.sale.push({ event_id, tickets: [ ticket ]})
    }

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

  }

}