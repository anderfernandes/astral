<template>
  <transition mode="out-in" name="fade">
    <router-view />
  </transition>
</template>

<script>
export default {
  
}
</script>

<style>
  .fade-enter-active, .fade-leave-active {
    transition: opacity 0.5s;
  }

  .fade-enter, .fade-leave-to {
    opacity: 0;
  }
</style>