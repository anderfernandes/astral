<template>
  <div id="cart">
    <h1 class="ui dividing header">Cart</h1>
    <div class="ui grid">
      <div class="twelve wide column">
        <div class="ui divided items">
          <div class="item" v-for="item in cart" :key="item.event.id">
            <div class="ui tiny image">
              <img :src="item.event.show.cover" :alt="item.event.show.name">
            </div>
            <div class="content">
              <div class="header">
                {{ item.event.show.name }}
                <div class="ui black label">{{ item.event.show.type }}</div>
              </div>
              <div class="meta">
                <i class="calendar alternate icon"></i>
                {{ format(item.event.start, "dddd, MMMM d [@] h:mm A") }}
                ({{ distanceInWordsToNow(item.event.start, { addSuffix: true }) }})
              </div>
              <div class="description" v-if="item.tickets.length > 0">
                <div class="ui black basic label" v-for="ticket in item.tickets" :key="ticket.id" v-if="ticket.amount > 0">
                  {{ ticket.name }} $ {{ ticket.price }}
                  <div class="detail">
                    {{ ticket.amount }}
                  </div>
                </div>
              </div>
              <div class="extra">
                <router-link class="ui right floated primary button" 
                  :to="{ name: 'event', params: { id: item.event.id }}">
                  <i class="edit outline icon"></i>
                  Change Tickets
                </router-link>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="four wide column">
        <div class="ui divided list">
          <div class="item">
            <h4 class="ui right floated content">+ $ {{ subtotal }}</h4>
            <h4 class="content">
              <div class="header">Subtotal</div>
            </h4>
          </div>
          <div class="item">
            <h4 class="ui right floated content">+ $ {{ tax }}</h4>
            <div class="content">
              <h4 class="header">Tax ({{ tax_rate }}%)</h4>
            </div>
          </div>
          <div class="item">
            <h1 class="ui right floated content">$ {{ total }}</h1>
            <div class="content">
              <h1 class="header">Total</h1>
            </div>
          </div>
        </div>
        <div class="ui fluid yellow button">
          Checkout
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import { format, distanceInWordsToNow } from 'date-fns'

import { createNamespacedHelpers } from 'vuex'

const { mapState, mapActions, mapGetters } = createNamespacedHelpers('Public')

export default {
  
  computed: {

    ...mapState({
      
      cart: state => state.sale,

      tax_rate: state => state.settings.tax,

    }),

    ...mapGetters({

      subtotal: 'subtotal',

      tax: 'tax',

      total: 'total'

    })

  },

  methods: {

    format,

    distanceInWordsToNow,

  }

}
</script>