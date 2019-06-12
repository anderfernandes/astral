<template>
  <transition name="fade" mode="out-in">
    <component :is="view"></component>
  </transition>
</template>

<script>
import axios    from "axios"
import Next     from "./events/Next.vue"
import Upcoming from "./events/Upcoming.vue"
export default ({
  name: "Events",
  data() {
    return {
      view: "Next"
    }
  },
  components: {
    "Next"    : Next,
    "Upcoming": Upcoming
  },
  mounted() {
    setInterval(() => {
      this.view == "Next"
        ? this.view = "Upcoming"
        : this.view = "Next"
      
    }, 20000)
  },
})
</script>

<style>
  .fade-enter-active, .fade-leave-active {
    transition: opacity 2s ease
  }
  .fade-enter, .fade-leave-to {
    opacity: 0
  }
</style>