let getDefaultMembersState = () => ({
  primary: {
    firstname: '',
    lastname: '',
    email: '',
    address: '',
    city: '',
    country: 'United States',
    state: 'Texas',
    zip: '',
    phone: '',
    newsletter: true
  },
  free_secondaries: [],
  nonfree_secondaries: [],
  membership_type: { id: null },
  start: null,
  end: null,

  subtotal: 0,
  tax: 0,
  paid: 0,
  balance: 0,
  total: 0,
  tendered: 0,
  change_due: 0,
  payment_method_id: null,
  reference: null,
  memo: null,

  check_primary: null
})

export default {
  namespaced: true,

  state: getDefaultMembersState(),

  mutations: {
    SET_FIRSTNAME(state, payload) {
      Object.assign(state.primary, { firstname: payload })
    },
    SET_LASTNAME(state, payload) {
      Object.assign(state.primary, { lastname: payload })
    },
    SET_EMAIL(state, payload) {
      Object.assign(state.primary, { email: payload })
    },
    SET_ADDRESS(state, payload) {
      Object.assign(state.primary, { address: payload })
    },
    SET_CITY(state, payload) {
      Object.assign(state.primary, { city: payload })
    },
    SET_STATE(state, payload) {
      Object.assign(state.primary, { state: payload })
    },
    SET_ZIP(state, payload) {
      Object.assign(state.primary, { zip: payload })
    },
    SET_PHONE(state, payload) {
      Object.assign(state.primary, { phone: payload })
    },
    SET_NEWSLETTER(state, payload) {
      Object.assign(state.primary, { newsletter: payload })
    },
    SET_CHECK_PRIMARY(state, payload) {
      Object.assign(state, { check_primary: payload })
    },
    SET_MEMBERSHIP_TYPE(state, payload) {
      Object.assign(state, { membership_type: payload })
    },
    SET_START(state, payload) {
      Object.assign(state, { start: payload })
    },
    SET_END(state, payload) {
      Object.assign(state, { end: payload })
    },
    SET_FREE_SECONDARIES(state, payload) {
      Object.assign(state, { free_secondaries: payload })
    },
    SET_NONFREE_SECONDARIES(state, payload) {
      Object.assign(state, { nonfree_secondaries: payload })
    },
    SET_TENDERED(state, payload) {
      Object.assign(state, { tendered: payload })
    },
    SET_REFERENCE(state, payload) {
      Object.assign(state, { reference: payload })
    },
    SET_MEMO(state, payload) {
      Object.assign(state, { memo: payload })
    },
    CALCULATE_TOTALS(state, tax_rate) {
      const primary_total = parseFloat(state.membership_type.price)
      const secondary_total =
        parseFloat(state.membership_type.secondary_price) *
        state.nonfree_secondaries.length
      const subtotal = primary_total + secondary_total
      const tax = subtotal * tax_rate
      const total = subtotal + tax
      const paid = state.tendered
      const balance = total - paid
      Object.assign(state, {
        subtotal: subtotal,
        tax,
        total,
        paid,
        balance
      })
    },
    SET_PAYMENT_METHOD_ID(state, payload) {
      Object.assign(state, { payment_method_id: payload })
    }
  },

  actions: {
    async checkPrimary({ state, commit }) {
      try {
        const response = await fetch('/api/members/check-primary', {
          method: 'post',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(state.primary)
        })
        const data = await response.json()
        commit('SET_CHECK_PRIMARY', data)
      } catch (error) {
        alert(`Error in checkPriamry: ${error.message}`)
      }
    },
    calculateTotals({ commit, rootState }) {
      commit('CALCULATE_TOTALS', rootState.Sale.settings.tax)
    }
  }
}
