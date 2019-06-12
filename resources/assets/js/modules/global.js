import axios from "axios"

// const SERVER = "http://10.51.150.214:8000"

export default {
  
  state : {
    errors     : null,
    alert      : null,
    show_alert : false,
    user       : localStorage.getItem("u"),
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

  },

  actions : {
    

  },

  
  getters : {
    errors     : state => state.errors,
    alert      : state => state.alert,
    show_alert : state => state.show_alert,
    user       : state => state.user,
    
  },
}