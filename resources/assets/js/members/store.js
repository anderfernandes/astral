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
  tendered: null,
  change_due: null,
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
    }
  }
}
