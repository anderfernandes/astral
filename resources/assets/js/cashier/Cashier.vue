<template>
  <div>
    <div class="ui borderless fixed top menu">
      <a class="black header toc item" @click="handleMenuButtonClick">
        <i class="sidebar large icon"></i>
      </a>
      <div class="header item">
        <img src="/astral-logo-dark.png" style="padding-right:4px" />Astral
      </div>
      <div class="active header item hide-on-mobile">
        <strong> <i class="inbox icon"></i> Cashier </strong>
      </div>
      <div class="right menu">
        <div class="active header item hide-on-mobile">
          <strong>
            <i class="calendar icon"></i>
            {{ format(new Date(), 'dddd, MMMM D, YYYY') }}
          </strong>
        </div>
        <div class="ui dropdown item" v-if="user">
          <i class="user circle large icon"></i>
          {{ user.firstname }}
        </div>
      </div>
    </div>
    <transition mode="out-in" name="fade">
      <router-view />
    </transition>
  </div>
</template>

<script>
  import format from 'date-fns/format'

  export default {
    data: () => ({
      menu: false,
      user: null
    }),
    async mounted() {
      await this.fetchUser()
    },
    methods: {
      async fetchUser() {
        const response = await fetch(`/api/user/${localStorage.getItem('u')}`)
        const user = await response.json()
        Object.assign(this, { user })
      },
      handleMenuButtonClick() {
        Object.assign(this, { menu: !this.menu })
        if (this.menu) this.$router.push('/menu')
        else this.$router.push('/')
      },
      format
    }
  }
</script>

<style>
  .fade-enter-active,
  .fade-leave-active {
    transition: opacity 0.5s !important;
  }

  .fade-enter,
  .fade-leave-to {
    opacity: 0;
  }
</style>
