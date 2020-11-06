<template>
  <div id="cart">
    <h2 class="ui dividing header">
      <i class="cart icon"></i> Cart
    </h2>
    <div class="ui stackable grid" v-show="cart.length > 0">
      <div class="twelve wide column">
        <div class="ui divided items">
          <div class="item" v-for="item in cart" :key="item.event.id">
            <div class="ui tiny image">
              <img :src="item.event.show.cover" :alt="item.event.show.name">
            </div>
            <div class="content">
              <div class="header">
                {{ item.event.show.name }}
                <div class="ui black label">{{ item.event.type.name }}</div>
                <div class="ui black label">{{ item.event.show.type }}</div>
              </div>
              <div class="meta">
                <i class="calendar alternate icon"></i>
                {{ format(item.event.start, "dddd, MMMM d [@] h:mm A") }}
                ({{ distanceInWordsToNow(item.event.start, { addSuffix: true }) }})
              </div>
              <div class="description" v-if="item.tickets.length > 0">
                <div class="ui black basic label" v-for="ticket in item.tickets" :key="ticket.id" v-show="ticket.amount > 0">
                  {{ ticket.name }} $ {{ ticket.price }}
                  <div class="detail">
                    x {{ ticket.amount }}
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
        <router-link to="/checkout" class="ui fluid yellow button">
          Checkout
        </router-link>
      </div>
    </div>
    <div class="ui blue icon message" v-show="cart.length <= 0">
      <i class="info circle icon"></i>
      <div class="content">
        <div class="header">Your cart is empty!</div>
        <p>Add tickets to your cart and they will appear here.</p>
      </div>
    </div>
  </div>
</template>

<script>

import { format, distanceInWordsToNow } from 'date-fns'

import { createNamespacedHelpers } from 'vuex'

const { mapState, mapActions, mapGetters } = createNamespacedHelpers('Public')

import { loadStripe } from '@stripe/stripe-js'

import axios from 'axios'

export default {

  mounted() {

    //this.stripePromise = loadStripe(this.gateway_key)

  },
  
  computed: {

    ...mapState({
      
      cart: state => state.sale,

      tax_rate: state => state.settings.tax,

    }),

    ...mapGetters({

      subtotal: 'subtotal',

      tax: 'tax',

      total: 'total',

      gateway_key: 'gateway_key'

    }),

  },

  methods: {

    format,

    distanceInWordsToNow,

    stripePromise() { loadStripe(this.gateway_key) },

    async checkout(event) {

      /*const stripe = await this.stripePromise

      const response = await axios.post('/api/public/sales', { sale: this.cart })

      const result = await stripe.redirectToCheckout({
        
        sessionId: response.data.id

      })

      if (result.error)
        alert(result.error.message) */

      

    }

  }

}
</script>