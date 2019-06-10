import axios from "axios"

const SERVER = "http://10.51.150.214:8000"

const saleStatuses = [
  { key: "open",      text: "Open",      value: "open",      icon: "unlock"     },
  { key: "confirmed", text: "Confirmed", value: "confirmed", icon: "thumbs up"  },
  { key: "complete",  text: "Completed", value: "complete",  icon: "check"      },
  { key: "tentative", text: "Tentative", value: "tentative", icon: "help"       },
  { key: "canceled",  text: "Canceled",  value: "canceled",  icon: "remove"     },
  { key: "no show",   text: "No Show",   value: "no show",   icon: "thumbs down"},
]

export default {
  // State
  state: {
    sales         : [],
    customers     : {},
    organizations : [],
    cashiers      : [],
    event_types   : [],
    statuses      : saleStatuses,
    page          : 1,
    query         : {
      id              : null,
      customer_id     : null,
      organization_id : null,
      status          : null,
      cashier_id      : null,
    },
    isLoading     : true,
    showModal     : false,
    
    currencySettings  : {
			minimumFractionDigits: 2,
      maximumFractionDigits: 2,
    },
  },
  // Mutations
  mutations: {
    // SET SALES
    SET_SALES(state, payload) {
      Object.assign(state, { sales : payload })
    },

    // SET_CUSTOMERS
    SET_CUSTOMERS(state, payload) {
      Object.assign(state.customers, payload)
    },

    // SET_ORGANIZATIONS
    SET_ORGANIZATIONS(state, payload) {
      Object.assign(state, { organizations: payload })
    },

    // SET_CASHIERS
    SET_CASHIERS(state, payload) {
      Object.assign(state, { cashiers : payload })
    },

    // SET_IS_LOADING
    SET_IS_LOADING(state, payload) {
      Object.assign(state, { isLoading : payload })
    },

    // SET_EVENT_TYPES
    SET_EVENT_TYPES(state, payload) {
      Object.assign(state.event_types, payload)
    },

    // TOGGLE_MODAL
    TOGGLE_MODAL(state, payload) {
      state.showModal = payload
    },

    // SET_QUERY
    SET_QUERY(state, payload) {
      Object.assign(state, { query : payload })
    },

    SET_PAGE(state, payload) {
      Object.assign(state, { page : payload })
    },
  },
  // Actions
  actions: {

    // Fetches sales, pagination aware
    async fetchSales({ state, commit }) {
      try {
        
        const url = new URL(`${SERVER}/api/sales?sort=desc&orderBy=id`)

        const params = new URLSearchParams(url.search)

        params.set("page", state.page++)

        for (let [key, value] of Object.entries(state.query)) {
          if (value)
            params.set(`${key}`, value)
        }

        url.search = params.toString()

        const response = await axios.get(url.toString())

        let sales = []

        if (state.page < 3)
          sales = response.data.data
        else
          sales = [...state.sales, ...response.data.data]

        commit("SET_SALES", sales)

      } catch (error) {
        alert(`Error in fetchSales: ${error.message}`)
      }
    },

    // Fetch customers
    async fetchCustomers({ commit }) {
      try {
        const response = await axios.get(`${SERVER}/api/customers`)
        
        let withOrganization = response.data.map(customer => ({
          key   : customer.id,
          value : customer.id,
          text  : `${customer.name} (${customer.role} ${ customer.organization.id == 1 ? '' : 'at ' + customer.organization.name })`,
        }))
        
        let withoutOrganization = response.data.map(customer => ({
          key   : customer.id,
          value : customer.id,
          text  : customer.name,
        }))

        withoutOrganization.unshift({ key: 0, value : null, text : "All Customers" })

        commit("SET_CUSTOMERS", { withOrganization, withoutOrganization })
      } catch (error) {
        alert(`Error in fetchCustomers: ${error.message}`)
      }
    },

    // Fetch organizations
    async fetchOrganizations({ commit }) {
      try {
        const response = await axios.get(`${SERVER}/api/organizations`)
        let organizations = response.data.map(organization => ({
          key   : organization.id,
          value : organization.id,
          text  : organization.name,
        }))
        organizations.unshift({
          key   : 0,
          value : null,
          text  : "All Organizations"
        })
        commit('SET_ORGANIZATIONS', organizations)
      } catch (error) {
        alert(`Error in fetchOrganizations: ${error.message}`)
      }
    },

    // Fetch cashiers
    async fetchCashiers({ commit }) {
      try {
        const response = await axios.get(`${SERVER}/api/staff`)
        let cashiers   = await response.data.map(cashier => ({
          icon  : "user circle",
          key   : cashier.id,
          value : cashier.id,
          text  : cashier.firstname,
        }))
        cashiers.unshift({
          key   : 0,
          value : null,
          text  : "All Cashiers",
        })
        commit('SET_CASHIERS', cashiers)
      } catch (error) {
        alert(`Error in fetchCashiers: ${error.message}`)
      }
    },

    // Fetch event types
    async fetchEventTypes({ commit }) {
      try {
        const response = await axios.get(`${SERVER}/api/event-types`)
        commit("SET_EVENT_TYPES", response.data)
      } catch (error) {
        alert(`Error in actions.fetchEventTypes: ${error.message}`)
      }
    },

    // Set isLoading
    setIsLoading(context, payload) {
      context.commit("SET_IS_LOADING", payload)
    },

    // Set showModal
    toggleModal(context, payload) {
      context.commit("TOGGLE_MODAL", payload)
    },

  },

  // getters
  getters: {
    sales            : state => state.sales,
    customers        : state => state.customers,
    organizations    : state => state.organizations,
    cashiers         : state => state.cashiers,
    event_types      : state => state.event_types,
    statuses         : state => state.statuses,
    page             : state => state.page,
    query            : state => state.query,
    isLoading        : state => state.isLoading,
    currencySettings : state => state.currencySettings,
    showModal        : state => state.showModal,
  },
}