import './bootstrap'

import Vue from 'vue'
import App from './views/App.vue'
import Shifts from './views/shifts/Shifts.vue'
import router from './router'
import store from './store'

import SuiVue from 'semantic-ui-vue'
Vue.use(SuiVue)

import moment from 'moment'
import marked from 'marked'

Vue.prototype.moment = moment
Vue.prototype.marked = marked

import { format, distanceInWords } from 'date-fns'

Vue.config.productionTip = false

Vue.mixin({
  filters: {
    currency(value) {
      if (value)
        return value.toLocaleString('en-US', store.getters.currencySettings)
    }
  },

  methods: {
    format,

    distanceInWords,

    getSaleColor(status) {
      let color = null
      switch (status) {
        case 'complete':
          color = { backgroundColor: '#21ba45' }
          break
        case 'confirmed':
          color = { backgroundColor: '#ffffff', color: '#21ba45' }
          break
        case 'open':
          color = { backgroundColor: '#6435c9' }
          break
        case 'canceled':
          color = { backgroundColor: '#db2828' }
          break // MST RED: #CF3534 SEMANTIC RED: #DB2828
        case 'tentative':
          color = { backgroundColor: '#fbbd08' }
          break
        case 'no show':
          color = { backgroundColor: '#f2711c' }
          break
      }
      return color
    },

    getSaleLabelColor(status) {
      let className = null
      switch (status) {
        case 'complete':
          className = 'ui green label'
          break
        case 'confirmed':
          className = 'ui basic green label'
          break
        case 'open':
          className = 'ui violet label'
          break
        case 'canceled':
          className = 'ui red label'
          break
        case 'tentative':
          className = 'ui yellow label'
          break
        case 'no show':
          className = 'ui orange label'
          break
      }
      return className
    },

    getSaleIcon(status) {
      let className = null
      switch (status) {
        case 'complete':
          className = 'checkmark icon'
          break
        case 'confirmed':
          className = 'thumbs up icon'
          break
        case 'open':
          className = 'unlock icon'
          break
        case 'canceled':
          className = 'remove icon'
          break
        case 'tentative':
          className = 'help icon'
          break
        case 'no show':
          className = 'thumbs outline down icon'
          break
      }
      return className
    }
  }
})

Vue.prototype.$dateFormat = {
  long: 'dddd, MMMM D, YYYY [at] h:mm a',
  short: 'dddd, MMMM D, YYYY'
}

// New Sales Interface
if (document.querySelector('#sales'))
  new Vue({
    router,
    store,
    render: h => h(App)
  }).$mount('#sales')

// Cashier App
import Cashier from './cashier/Cashier.vue' // This is cashier's App.js
import CashierRouter from './cashier/router'
import CashierStore from './cashier/store'

if (document.querySelector('#cashier'))
  new Vue({
    router: CashierRouter,
    store,
    render: h => h(Cashier)
  }).$mount('#cashier')

// Events Component
import Events from './components/Events'

if (document.querySelector('#events')) {
  new Vue({
    el: '#events',
    components: { Events },
    template: '<Events />'
  })
}

// New Member Wizard
import Members from './members/Members.vue'
import MembersRouter from './members/router'
import MembersStore from './members/store'

if (document.querySelector('#new-member-wizard'))
  new Vue({
    router: MembersRouter,
    store,
    render: h => h(Members)
  }).$mount('#new-member-wizard')
