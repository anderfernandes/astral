<template>
  <sale-form></sale-form>
</template>

<script>

  import SaleForm from '../../components/forms/Sale.vue'

  export default {
    components: { SaleForm },
    async beforeDestroy() {
      await this.$store.commit("RESET_CREATE")
    }
  }
</script>