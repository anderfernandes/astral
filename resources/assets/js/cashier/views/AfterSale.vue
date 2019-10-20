<template>
  <div class="ui grid">
    <div class="ui sixteen wide column">
      <div class="ui header">
        Sale completed succesfully!
      </div>
      <div class="ui button" @click.prevent="handleCompletedSale">Back</div>
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    handleCompletedSale() {
      this.$store.commit('Cashier/RESET')
      this.$router.push({ name: 'index' })
    }
  }
}
</script>