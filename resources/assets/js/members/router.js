import Vue from 'vue'
import Router from 'vue-router'

import Index from './views/Index.vue'
import Primary from './views/Primary.vue'
import Details from './views/Details.vue'
import Secondaries from './views/Secondaries.vue'
import Payment from './views/Payment.vue'
import Confirm from './views/Confirm.vue'
import ThankYou from './views/ThankYou.vue'

Vue.use(Router)

export default new Router({
  routes: [
    { path: '/', name: 'index', component: Index, meta: { step: 0 } },
    {
      path: '/primary',
      name: 'primary',
      component: Primary,
      meta: { step: 1 }
    },
    {
      path: '/details',
      name: 'details',
      component: Details,
      meta: { step: 2 }
    },
    {
      path: '/secondaries',
      name: 'secondaries',
      component: Secondaries,
      meta: { step: 3 }
    },
    {
      path: '/payment',
      name: 'payment',
      component: Payment,
      meta: { step: 4 }
    },
    {
      path: '/confirm',
      name: 'confirm',
      component: Confirm,
      meta: { step: 5 }
    },
    {
      path: '/thank-you',
      name: 'thank-you',
      component: ThankYou,
      meta: { step: 6 }
    }
  ]
})
