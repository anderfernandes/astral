import Vue from "vue"
import Router from "vue-router"

import Home from "./views/Home.vue"
import Event from "./views/Event.vue"
import Cart from "./views/Cart.vue"

Vue.use(Router)

export default new Router({
  routes: [
    { 
      path: "/", 
      name: "home", 
      component: Home 
    },
    { 
      path: "/event/:id", 
      name: "event", 
      props: true,
      component: Event 
    },
    { 
      path: "/cart", 
      name: "cart", 
      component: Cart 
    },
  ]
})