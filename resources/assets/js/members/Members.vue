<template>
  <div class="ui container">
    <sui-step-group ordered>
      <sui-step>
        <sui-step-content>
          <sui-step-title>Primary</sui-step-title>
          <sui-step-description
            >Make new or existing User a Member</sui-step-description
          >
        </sui-step-content>
      </sui-step>
      <sui-step>
        <sui-step-content>
          <sui-step-title>Secondaries</sui-step-title>
          <sui-step-description
            >Define secondaries on membership</sui-step-description
          >
        </sui-step-content>
      </sui-step>
      <sui-step>
        <sui-step-content>
          <sui-step-title>Membership Details</sui-step-title>
          <sui-step-description
            >Membership Type, Start and End Dates</sui-step-description
          >
        </sui-step-content>
      </sui-step>
      <sui-step>
        <sui-step-content>
          <sui-step-title>Payment</sui-step-title>
          <sui-step-description>Membership Payment</sui-step-description>
        </sui-step-content>
      </sui-step>
    </sui-step-group>
    <div class="ui text container">
      <router-view />
    </div>
  </div>
</template>

<script>
  export default {}
</script>
