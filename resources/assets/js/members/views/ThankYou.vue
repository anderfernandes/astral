<template>
  <div class="ui basic segment" style="text-align:center !important">
    <h1 class="ui massive center aligned header">
      <i class="address card outline icon"></i>
    </h1>
    <h1>Membership #{{ membership.id }} created successfully!</h1>
    <p><a :href="`/admin/members/${membership.id}`">Click here</a> to see membership details. Make sure all the data is correct.</p>
  </div>
</template>

<script>
  export default({
    computed: {
      membership() { return this.$store.state.Members.membership }
    }
  })
</script>
