import Vue    from 'vue'
import Router from 'vue-router'

import Index  from './views/sales/Index.vue'
import Create from './views/sales/Create.vue'
import Show   from './views/sales/Show.vue'
import Edit   from './views/sales/Edit.vue'

//import ShiftsIndex  from './views/shifts/Index.vue'
//import ShiftsCreate from './views/shifts/Create.vue'
//import ShiftsShow   from './views/shifts/Show.vue'
//import ShiftsEdit   from './views/shifts/Edit.vue'

Vue.use(Router)

export default new Router({
  routes: [
    // Sales Routes
    {
      path      : '/',
      name      : 'index',
      component : Index
    },
    {
      path      : '/create',
      name      : 'create',
      component : Create
    },
    {
      path      : '/:id',
      name      : 'show',
      component : Show
    },
    {
      path      : '/:id/edit',
      name      : 'edit',
      component : Edit
    },
    
  ]
})