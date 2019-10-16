export default ({
  
  namespaced: true,
  
  state: {
    sale: {
      products: [],
      tickets: [],
    }
  },

  mutations: {
    
    ADD_PRODUCT(state, product) {
      if (state.sale.products.some(p => p.id === product.id)) {
        // Product already exists, add one more
        let existingProduct = state.sale.products.find(p => p.id === product.id)
        let index = state.sale.products.findIndex(p => p.id === product.id)
        state.sale.products.splice(index, 1, {
          id: product.id,
          name: product.name,
          price: product.price,
          cover: product.cover,
          quantity: existingProduct.quantity + 1,
        })
      } else {
        // Product does not exist, add one
        state.sale.products.push({
          id: product.id,
          name: product.name,
          price: product.price,
          cover: product.cover,
          quantity: 1,
        })
      }
    },

    REMOVE_PRODUCT(state, payload) {
      let existingProduct = state.sale.products.find(p => p.id === product.id)
      let index = state.sale.products.findIndex(p => p.id === product.id)
      if (existingProduct && existingProduct.quantity > 1) {
        // If product exists, take one out of quantity
        state.sale.products.splice(index, 1, {
          id: product.id,
          name: product.name,
          price: product.price,
          cover: product.cover,
          quantity: existingProduct.quantity - 1,
        })
      } else {
        state.sale.products.splice(index, 1)
      }
    },

    // If it exists, splice. If it doesn't, push
    ADD_TICKET(state, payload) {
      let existingEventIndex = state.sale.tickets.findIndex(t => t.event.id === payload.event.id)
      if (existingEventIndex != -1) {
        let currentEvent = state.sale.tickets[existingEventIndex]
        // Checking if ticket exist in that event
        let existingTicketIndex = currentEvent.tickets.findIndex(t => t.id === payload.ticket.id)
        if (existingTicketIndex != -1) {
          // Find current amount of tickets
          let existingTicket = currentEvent.tickets.find(t => t.id === payload.ticket.id)
          // Update ticket objects
          Object.assign(currentEvent.tickets.splice(existingTicketIndex, 1, {
            id: payload.ticket.id, 
            name: payload.ticket.name,
            price: payload.ticket.price,
            quantity: existingTicket.quantity + 1
          }))
        } else {
          // Add new ticket to event
          currentEvent.tickets.push({
            id: payload.ticket.id, 
            name: payload.ticket.name,
            price: payload.ticket.price,
            quantity: 1
          })
        }
        
        
      } else {
        state.sale.tickets.push({ 
          event: { 
            id: payload.event.id,
            start: payload.event.start,
            type: {
              id: payload.event.type.id,
              name: payload.event.type.name,
            },
            show: { 
              id: payload.event.show.id,
              name: payload.event.show.name,
              cover: payload.event.show.cover,
              type: {
                id: payload.event.show.type.id,
                name: payload.event.show.type.name,
              }
            } 
          }, 
          tickets: [{ 
            id: payload.ticket.id, 
            name: payload.ticket.name,
            price: payload.ticket.price,
            quantity: 1,
          }]
        })
      }
    },

    REMOVE_TICKET(state, ticket) {

    }

  },

  getters: {
    total: state => {
      let products_total = state.sale.products.reduce((total, product) => (total + (product.quantity * product.price)), 0)
      let tickets_total = state.sale.tickets.length == 0 
        ? 0 
        : state.sale.tickets.reduce((accumulator, event) => {
            let event_total = event.tickets.length == 0 ? 0 : event.tickets.reduce((ttl, tck) => (ttl + (tck.quantity * tck.price)), 0)
            return accumulator + event_total
          }, 0)
      return products_total + tickets_total
    }
  },
})