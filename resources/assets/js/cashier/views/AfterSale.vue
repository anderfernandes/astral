<template>
  <div class="ui centered one column grid">
    <div class="column">
      <div class="ui huge center aligned icon header">
        <i class="thumbs up icon"></i>
        <div class="content">
          Sale completed succesfully!
        </div>
        <div class="content">
          <br>
          <div class="ui huge positive button" @click.prevent="handleCompletedSale">OK</div>
        </div>
      </div>
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