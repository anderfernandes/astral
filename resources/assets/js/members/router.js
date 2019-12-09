import Vue from 'vue'
import Router from 'vue-router'

import Index from './views/Index.vue'
import Primary from './views/Primary.vue'

Vue.use(Router)

export default new Router({
  routes: [
    { path: '/', name: 'index', component: Index, meta: { step: 0 } },
    { path: '/primary', name: 'primary', component: Primary, meta: { step: 1 } }
  ]
})
