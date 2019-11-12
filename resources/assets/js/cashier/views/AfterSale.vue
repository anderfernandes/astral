<template>
  <div class="ui centered one column grid">
    <div class="column" style="text-align:center !important">
      <div class="ui huge center aligned icon header">
        <i class="thumbs up icon"></i>
        <div class="content">
          Sale #{{ last_sale.id }} completed succesfully!
        </div>
      </div>
      <a class="ui massive basic positive button" :href="`/admin/sales/${last_sale.id}/tickets`" target="_blank">
        <i class="ticket icon"></i>
        Tickets
      </a>
      <div class="ui massive positive button" @click.prevent="handleCompletedSale">
        <i class="check icon"></i>
        OK
      </div>
      <a class="ui massive basic positive button" :href="`/admin/sales/${last_sale.id}/receipt`" target="_blank">
        <i class="file text icon"></i>
        Receipt
      </a>
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
  },
  computed: {
    last_sale() { return this.$store.state.Cashier.last_sale }
  }
}
</script>