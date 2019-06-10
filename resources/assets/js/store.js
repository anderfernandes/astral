import Vue from 'vue'
import Vuex from 'vuex'

// Sales Global Vuex Module
import Global from './modules/global'

//  Sales Index Vuex Module
import Index from './modules/index'

// Sales Create Vuex Module
import Sale from './modules/sale'

Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    Global,
    Index,
    Sale,
  }
})