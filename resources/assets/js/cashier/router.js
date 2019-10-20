import Vue from 'vue'
import Router from 'vue-router'

import Index from './views/Index.vue'
import AfterSale from './views/AfterSale.vue'

Vue.use(Router)

export default new Router({
  routes: [
    { path: '/', name: 'index', component: Index },
    { path: '/after-sale', name: 'after-sale', component: AfterSale }
  ]
})