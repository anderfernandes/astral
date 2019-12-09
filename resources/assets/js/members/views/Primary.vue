<template>
  <div class="ui basic segment" style="text-align:center !important">
    <h1 class="ui massive center aligned header">
      <i class="address card icon"></i>
    </h1>
    <h1 class="ui center aligned header">
      Primary
    </h1>
    <h4 class="ui center aligned header">
      Please enter their First Name, Last Name and email to see if they already
      are in our database.
    </h4>
    <div class="ui form">
      <div class="three fields">
        <div class="field">
          <input type="text" v-model="firstname" placeholder="First Name" />
        </div>
        <div class="field">
          <input type="text" placeholder="Last Name" />
        </div>
        <div class="field">
          <input type="text" name="" placeholder="Email" />
        </div>
      </div>
    </div>
    <div
      class="ui centered yellow labeled icon button"
      @click="$router.push('/')"
    >
      <i class="left chevron icon"></i>
      Back
    </div>
    <div
      class="ui positive right labeled icon button"
      @click="$router.push('/primary')"
    >
      <i class="right chevron icon"></i>
      Next
    </div>
  </div>
</template>

<script>
  export default {
    computed: {
      firstname: {
        get() {
          return this.$store.state.Members.primary.firstname
        },
        set(value) {
          this.$store.commit('Members/SET_FIRSTNAME', value)
        }
      }
    }
  }
</script>
