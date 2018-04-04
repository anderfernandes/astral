// Importing Vue
import Vue from 'vue'

// Importing dependencies
import moment from 'moment'

// Prototyping
Vue.prototype.moment = moment

// Disable production tip
Vue.config.productionTip = false

// Event Component
import Events from './components/upcoming/Events'

if (document.querySelector('#events')) {
  new Vue({
    el: '#events',
    components: { Events },
    template: '<Events />'
  })  
}
