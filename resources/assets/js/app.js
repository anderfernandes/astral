// Importing Vue
import Vue from 'vue'

// Importing dependencies
import moment from 'moment'

// Prototyping
Vue.prototype.moment = moment

// Disable production tip
Vue.config.productionTip = false

// Events Component
import Events from './components/Events'

if (document.querySelector('#events')) {
  new Vue({
    el: '#events',
    components: { Events },
    template: '<Events />'
  })
}

// Sales

import Sales from './components/Sales'

if (document.querySelector('#sales')) {
  new Vue({
    el: '#sales',
    components: { Sales },
    template: '<Sales />'
  })
}
