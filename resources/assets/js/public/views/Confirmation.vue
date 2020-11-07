<template>
<div id="confirmation">
  <div class="ui success icon message">
    <i class="thumbs up icon"></i>
    <div class="content">
      <div class="header">Success!</div>
      <p>
        We have sent the tickets <em>and</em> the receipt <strong>{{ sale.customer.firstname }}</strong>.
        We are looking forward to have you at the <strong>{{ settings.organization }}</strong>!
      </p>
    </div>
  </div>
</div>
</template>

<script>

import { createNamespacedHelpers } from 'vuex'

const { mapState } = createNamespacedHelpers('Public')

export default {

  props: ['sale'],

  data: () => ({

  }),

  computed: {
    
    ...mapState([ 'settings' ]),

  }
}
</script>