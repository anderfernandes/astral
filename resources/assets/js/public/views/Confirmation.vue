<template>
<div id="confirmation">
  <div :class="`ui ${type} icon message`">
    <i class="thumbs up icon"></i>
    <div class="content" v-if="type == 'success'">
      <div class="header">Success!</div>
      <p>
        We have sent the tickets <em>and</em> the receipt to <strong>{{ sale.customer.email }}</strong>, <strong> {{ sale.customer.firstname }}</strong>.
        Show us any of those we will let you in. Make sure you <strong>check your email's spam folder</strong> in case our email ended up there.
        We are looking forward to have you at the <strong>{{ settings.organization }}</strong>!
      </p>
    </div>
    <div class="content" v-else-if="type == 'warning'">
      <div class="header">Success, but...</div>
      <p>
        {{ message }} Contact us at <strong>{{ settings.phone }}</strong> or <strong>{{ settings.email }}</strong> 
        and tell us that there was an error emailing your tickets for Sale #{{ sale.id }}.
      </p>
    </div>
  </div>
</div>
</template>

<script>

import { createNamespacedHelpers } from 'vuex'

const { mapState } = createNamespacedHelpers('Public')

export default {

  props: ['sale', 'message', 'type'],

  data: () => ({

  }),

  computed: {
    
    ...mapState([ 'settings' ]),

  }
}
</script>