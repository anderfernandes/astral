<template>
  <sui-modal v-model="open" basic>
    <slot></slot>
  </sui-modal>
</template>

<script>
  export default {
    computed: {
      open: {
        set(value) { this.$store.dispatch("toggleModal", value) },
        get()      { return this.$store.getters.showModal        }
      },
    },
  }
</script>