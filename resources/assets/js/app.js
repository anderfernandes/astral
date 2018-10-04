// Importing Vue
import Vue from 'vue'

// Importing dependencies
import moment from 'moment'

// Prototyping
Vue.prototype.moment = moment

// Disable production tip
Vue.config.productionTip = false

// ElementUI
//import ElementUI from 'element-ui';
//import 'element-ui/lib/theme-chalk/index.css';

//Vue.use(ElementUI)

// Cashier
import Cashier from './components/Cashier'

if (document.querySelector('#cashier')) {
  new Vue({
    el: '#cashier',
    render: h => h(Cashier)
  })
}


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
