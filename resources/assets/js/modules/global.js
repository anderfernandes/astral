import axios from "axios"

// const SERVER = "http://10.51.150.214:8000"

export default {
  
  state : {
    errors     : null,
    alert      : null,
    show_alert : false,
    user       : null,
  },

  mutations : {
    
    // SET_ERRORS
    SET_ERRORS(state, payload) {
      Object.assign(state, { errors: payload })
    },

    // SET_MESSAGE
    SET_ALERT(state, payload) {
      Object.assign(state, { alert : payload })
    },

    TOGGLE_SHOW_ALERT(state, payload) {
      Object.assign(state, { show_alert : payload })
    },

    SET_USER(state, payload) {
      Object.assign(state, { user : payload })
    }

  },

  actions : {
    
    async fetchUser({ commit }) {
      try {
        const response = axios.get("/api/user")
        commit("SET_USER", response.data)
      } catch (error) {
        alert(`Error in global.fetchUser : ${ error.message }`)
      }
    }

  },

  
  getters : {
    errors     : state => state.errors,
    alert      : state => state.alert,
    show_alert : state => state.show_alert,

    
  },
}