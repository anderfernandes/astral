import Vue from "vue"
import Router from "vue-router"

import Home from "./views/Home.vue"
import Event from "./views/Event.vue"
import Cart from "./views/Cart.vue"
import Checkout from "./views/Checkout.vue"
import Confirmation from "./views/Confirmation.vue"

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
    {
      path: "/checkout",
      name: "checkout",
      component: Checkout,
    },
    {
      path: "/confirmation",
      name: "confirmation",
      component: Confirmation,
      props: true
    }
  ]
})