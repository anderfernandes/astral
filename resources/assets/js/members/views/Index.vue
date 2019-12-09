<template>
  <div class="ui basic segment" style="text-align:center !important">
    <h1 class="ui massive center aligned header">
      <i class="address card icon"></i>
    </h1>
    <h1 class="ui center aligned header">
      Welcome to the New Membership Wizard!
    </h1>
    <h4 class="ui center aligned header">
      I will ask you questions to help you quickly create memberships for new or
      existing users.
    </h4>
    <div
      class="ui green right labeled icon button"
      @click="$router.push('/primary')"
    >
      <i class="thumbs up icon"></i>
      I am ready to start!
    </div>
  </div>
</template>
