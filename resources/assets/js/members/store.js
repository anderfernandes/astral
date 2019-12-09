let getDefaultMembersState = () => ({
  primary: {
    firstname: null,
    lastname: null,
    email: null
  },
  free_secondaries: [],
  nonfree_secondaries: [],
  type_id: null,
  start: new Date(),
  end: null,
  tendered: null,
  change_due: null,
  payment_method_id: null,
  reference: null,
  memo: null
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
    }
  },

  actions: {
    async checkPrimary({ state }) {
      try {
        const response = fetch('/api/members/check-primary', {
          method: 'post',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(primary)
        })
        const exists = await response.json()
        console.log(exists)
      } catch (error) {
        alert(`Error in checkPriamry: ${error.message}`)
      }
    }
  }
}
