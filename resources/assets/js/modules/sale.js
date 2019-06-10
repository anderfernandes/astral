import axios from "axios"

const SERVER = "http://10.51.150.214:8000"

let getDefaultState = () => ({
    // Sale data
    sale: {
      creator_id        : 3,
      status            : "open",
      sell_to           : null,
      customer          : null,
      dates             : [],
      grades            : [],
      products          : [],
      selected_products : [],
      events            : [],
      tickets           : [],
      selected_tickets  : [],
      taxable           : 0,
      payment_method    : null,
      tendered          : 0,
      change_due        : 0,
      reference         : null,
      payments          : [],
      memo              : null, // New memo
      memos             : [],
      subtotal          : 0,
      tax               : 0,
      paid              : 0,
      total             : 0,
      balance           : 0,
    },

    // Options for dropdowns throughout form
    sell_to : [
      { key: "customer",     text: "Customer",     value: 0 },
			{ key: "organization", text: "Organization", value: 1 },
    ],
    
    taxable : [
      { key: "No",  text: "No",  value: 0 },
			{ key: "Yes", text: "Yes", value: 1 },
    ],

    numberOfEvents  : 1,
    grades          : [],
    products        : [], // options for dropdown
    product_options : [], // full object with all product options
    payment_methods : [],
    settings        : {},
})

export default {
  
  state : getDefaultState(),

  mutations : {

    SET_SALE(state, payload) {
      Object.assign(state, { sale : payload })
    },

    // RESET_CREATE
    RESET_CREATE(state) {
      const s = getDefaultState()
      Object.keys(s).forEach(key => {
        state[key] = s[key]
      })
    },
    
    // SET_GRADES
    SET_GRADES(state, payload) {
      Object.assign(state.grades, payload)
    },

    // SET_PRODUCTS
    SET_PRODUCTS(state, payload) {
      Object.assign(state, { products : payload })
    },

    // SET_SELECTED_PRODUCTS
    SET_SELECTED_PRODUCTS(state, payload) {
      let selected_products = state.product_options.filter(product_option => payload.includes(product_option.id))
      Object.assign(state.sale, { selected_products })
    },

    // SET_SELECTED_PRODUCTS
    SET_PRODUCT_OPTIONS(state, payload) {
      Object.assign(state, { product_options: payload })
    },

    REMOVE_PRODUCT(state, payload) {
      // Find product
      let i = state.sale.products.findIndex(product => product == payload.id)
      let j = state.sale.selected_products.findIndex(product => product.id == payload.id)
      // Reset count
      Object.assign(state.sale.selected_products[i], { amount: 1 })
      // Remove from array
      state.sale.products.splice(i, 1)
      state.sale.selected_products.splice(i, j)
    },

    // SET_SETTINGS
    SET_SETTINGS(state, payload) {
      Object.assign(state.settings, payload)
    },

    // SET_PAYMENT_METHODS
    SET_PAYMENT_METHODS(state, payload) {
      Object.assign(state.payment_methods, payload)
    },

    // CALCULATE_TOTALS
    CALCULATE_TOTALS(state) {
      let productTotals = 0
      let ticketTotals  = 0

      // Calculating product totals
      if (state.sale.selected_products.length > 0)
        productTotals = state.sale.selected_products.reduce((total, product) =>
          (total + (product.amount * product.price)), 0)

      // Calculating ticket totals
      state.sale.selected_tickets.forEach(eventTickets => {
        ticketTotals += eventTickets.reduce((total, ticket) => 
          (total + (ticket.amount * ticket.price)), 0
        )
      })

      let subtotal   = productTotals + ticketTotals
      let tax = (state.settings.tax * state.sale.taxable) * subtotal
      tax     = Number(Math.round(tax + 'e2') + 'e-2')
      let total      = subtotal + tax
      let balance    = (total - state.sale.tendered) > 0 ? total - state.sale.tendered - state.sale.paid : 0
      let change_due = (state.sale.tendered - total) > 0 ? state.sale.tendered - total : 0

      Object.assign(state.sale, {
        tax        : tax, 
        subtotal   : subtotal,
        total      : total,
        balance    : balance,
        change_due : change_due,
      })
    },

    // SET_EVENT
    SET_EVENT(state, payload) {
      state.sale.events.splice(payload.index, 1, payload.event)

      // Update event in tickets if event changes and there are tickets for the event
      if (state.sale.tickets[payload.index] && state.sale.tickets[payload.index].length > 0)
        state.sale.tickets[payload.index].forEach(ticket => Object.assign(ticket.event, { id: state.sale.events[payload.index] }))
    },

    // SET_TICKETS
    SET_TICKETS(state, payload) {
      state.sale.tickets.splice(payload.index, 1, payload.tickets)
      // payload.tickets is an array of selected tickets for event # payload.index in sale
    },

    SET_SELECTED_TICKETS(state, payload) {
      state.sale.selected_tickets.splice(payload.index, 1, payload.selected_tickets)
    },

    REMOVE_TICKET(state, payload) {
      
      // Find ticket
      let i = state.sale.tickets[payload.index].findIndex(ticket => ticket == payload.id)
      let j = state.sale.selected_tickets[payload.index].findIndex(ticket => ticket.id == payload.id)
      // Reset count
      Object.assign(state.sale.selected_tickets[payload.index][j], { amount: 1 })
      // Remove from array
      state.sale.tickets[payload.index].splice(i, 1)
      state.sale.selected_tickets[payload.index].splice(j, 1)
    },

    SET_NUMBER_OF_EVENTS(state, payload) {
      if (payload)
        Object.assign(state, { numberOfEvents : parseInt(payload) })
      else
        state.numberOfEvents++
    },

    SET_DATES(state, payload) {
      state.sale.dates.splice(payload.index, 1, payload.date)
    }

  },

  actions : {
    
    // Fetch grades
    async fetchGrades({ commit }) {
      try {
        const response = await axios.get(`${SERVER}/api/grades`)
        let grades     = response.data.data.map(grade => ({
          key  : grade.id,
          text : grade.name,
          value: grade.id,
        }))
        commit('SET_GRADES', grades)
      } catch (error) {
        alert(`Error in actions.fetchGrades: ${ error.message }`)
      }
    },
    
    // Fetch products
    async fetchProducts({ commit }) {
      try {
        let product_options = []
        const response = await axios.get(`${SERVER}/api/products`)
        let products   = response.data.data.map(product => {
          Object.assign(product, { amount : 1 })
          product_options.push(product)
          return {
            key   : product.id,
            text  : product.name,
            value : product.id,
            icon  : 'box',
          }
        })
        commit("SET_PRODUCTS", products)
        commit("SET_PRODUCT_OPTIONS", product_options)
      } catch (error) {
        alert(`Error in actions.fetchProducts: ${ error.message }`)
      }
    },

    // Fetch payment methods
    async fetchPaymentMethods({ commit }) {
      try {
        const response = await axios.get(`${SERVER}/api/payment-methods`)
        let payment_methods = response.data.data.map(payment_method => ({
					key  : payment_method.id, 
					text : payment_method.name,
					value: payment_method.id,
					icon : payment_method.icon
				}))
				await commit("SET_PAYMENT_METHODS", payment_methods)
      } catch (error) {
        alert(`Error in actions.fetchSettings: ${ error.message }`)
      }
    },

    // Fetch settings
    async fetchSettings({ commit }) {
      try {
        const response = await axios.get(`${SERVER}/api/settings`)
        let tax        = parseFloat(response.data.tax) / 100
        await commit('SET_SETTINGS', { tax: tax })
        //await context.commit('HAS_SETTINGS', true)
      } catch (error) {
        alert(`Error in actions.fetchSettings: ${ error.message }`)
      }
    }
  },

  
  getters : {
    sale            : state => state.sale,
    sell_to         : state => state.sell_to,
    taxable         : state => state.taxable,
    grades          : state => state.grades,
    products        : state => state.products,
    payment_methods : state => state.payment_methods,
    settings        : state => state.settings,
    numberOfEvents  : state => state.numberOfEvents,
  },
}