import Vue from "vue";
import Router from "vue-router";

import Index from "./views/Index.vue";
import AfterSale from "./views/AfterSale.vue";
import Menu from "./views/Menu.vue";

Vue.use(Router);

export default new Router({
  routes: [
    { path: "/", name: "index", component: Index },
    { path: "/after-sale", name: "after-sale", component: AfterSale },
    { path: "/menu", name: "menu", component: Menu }
  ]
});
