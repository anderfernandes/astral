<template>
  <div id="checkout" v-show="!loading">

    <h2 class="ui dividing header">Checkout</h2>

    <div class="ui blue icon message" v-show="hasError">
      <i class="info circle icon"></i>
      <div class="content">
        <div class="header">Unable to checkout</div>
        <p>
          {{ settings.organization }} has not finished setting up online sales. 
          Please let them know you saw this message so that they can fix it.
        </p>
      </div>
    </div>
    
    <div id="checkout-ui" v-show="(sale.length > 0) && !hasError">
      
      <table class="ui very basic single line celled table">
        <thead>
          <tr>
            <th>Show</th>
            <th>Date</th>
            <th>Tickets</th>
            <th>Subtotal</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in sale" :key="item.event.id">
            <td>
              <h4 class="ui image header">
                <img :src="item.event.show.cover" :alt="item.event.show.name" class="ui mini rounded image" />
                <div class="content">
                  {{ item.event.show.name }}
                  <div class="sub header">
                    <div class="ui black label" style="margin-left: 0">
                      {{ item.event.show.type }}
                    </div>
                  </div>
                </div>
              </h4>
            </td>
            <td>
              {{ format(item.event.start, "dddd, MMMM d [@] h:mm A") }}
              ({{ distanceInWordsToNow(item.event.start, { addSuffix: true }) }})
            </td>
            <td>
              <div class="ui basic black label" v-for="ticket in item.tickets" v-show="ticket.amount > 0" :key="ticket.id">
                {{ ticket.name }} $ {{ ticket.price }}
                <div class="detail"> x {{ ticket.amount }}</div>
              </div>
            </td>
            <td class="right aligned">
              $ {{ ticketsSubtotal(item.tickets) }}
            </td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <th colspan="3" class="right aligned">
              <strong>Subtotal:</strong>
            </th>
            <th class="right aligned">
              <strong>$ {{ subtotal }}</strong>
            </th>
          </tr>
          <tr>
            <th colspan="3" class="right aligned">
              <strong>Tax:</strong>
            </th>
            <th class="right aligned">
              <strong>$ {{ tax }}</strong>
            </th>
          </tr>
          <tr>
            <th colspan="3" class="right aligned">
              <strong>Total:</strong>
            </th>
            <th class="right aligned">
              <strong>$ {{ total }}</strong>
            </th>
          </tr>
        </tfoot>
      </table>
      
      <form class="ui form">
        <div class="four fields">
          <div class="field">
            <label for="firstname">First Name</label>
            <input v-model="customer.firstname" placeholder="First Name" type="text">
          </div>
          <div class="field">
            <label for="lastname">Last Name</label>
            <input v-model="customer.lastname" placeholder="Last Name" type="text">
          </div>
          <div class="field">
            <label for="email">Email</label>
            <input v-model="customer.email" type="email" placeholder="your@email">
          </div>
          <div class="field">
            <label for="email">Phone</label>
            <input
              type="text"
              v-mask="['(###) ###-####']"
              v-model="customer.phone"
              placeholder="Phone"
            />
          </div>
        </div>
        <div class="three fields">
          <div class="field">
            <label for="address">Address</label>
            <input v-model="customer.address" min="2" max="127" placeholder="Address" type="text">
          </div>
          <div class="field">
            <label for="city">City</label>
            <input v-model="customer.city" min="2" max="32" placeholder="City" type="text">
          </div>
          <div class="field">
            <label for="state">State</label>
            <sui-dropdown
              large
              placeholder="State"
              search
              selection
              disabled
              :options="state_options"
              v-model="customer.state"
            />
          </div>
          <div class="field">
            <label for="zip">ZIP</label>
            <input v-model="customer.zip" min="5" max="5" placeholder="ZIP" type="text">
          </div>
        </div>
        <div class="ui checkbox field">
            <input type="checkbox" class="ui checkbox" v-model="customer.newsletter">
            <label for="newsletter">Receive {{ settings.organization }} newsletter</label>
        </div>
      </form>

      <br />

      <!--- Stripe or Braintree --->
      <stripe ref="stripe" :valid="valid" :customer="customer" v-if="settings.gateway == 'stripe'" />
      <braintree ref="braintree" :valid="valid" :customer="customer" v-if="settings.gateway == 'braintree'" />
    
    </div>

    <div class="ui blue icon message" v-show="sale.length <= 0">
      <i class="info circle icon"></i>
      <div class="content">
        <div class="header">There are no items in your cart</div>
        <p>Come back when you add tickets to your cart.</p>
      </div>
    </div>

    <br><br>

  </div>
</template>

<script>

import { mask } from 'vue-the-mask'

import { format, distanceInWordsToNow } from 'date-fns'

import { createNamespacedHelpers } from 'vuex'

import Stripe from './Stripe.vue'

import Braintree from './Braintree.vue'

const { mapState, mapActions, mapGetters } = createNamespacedHelpers('Public')

const currencySettings = { minimumFractionDigits: 2, maximumFractionDigits: 2 }

export default {

  directives: { mask },

  components: { Stripe, Braintree },

  data: () => ({

    loading: true,

    hasError: false,

    customer: {

      firstname: "",

      lastname: "",

      email: "",

      address: "",

      city: "",
      
      state: "Texas",

      zip: "",

      newsletter: true,

      phone: "",

    },

    state_options: [
      
      { key: "TX", text: "Texas", value: "Texas" }

    ],

    submitted: false,

  }),
  

  async mounted() {

    if (this.sale.length > 0) {

      try {

        await this.fetchStates()

      } catch (e) {
        
        this.hasError = true

      }

    }

    if (!this.gateway_key)
      this.hasError = true

    this.loading = false

  },

  computed: {

    ...mapState([ 'sale', 'settings' ]),

    ...mapGetters({ 
      
      subtotal: 'subtotal',

      tax: 'tax',

      total: 'total',

      gateway_key: 'gateway_key',
    
    }),

    valid() {

      if (
        this.customer.firstname.length >= 3 && 
        this.customer.lastname.length >= 3 && 
        this.customer.email.includes("@") && 
        this.customer.email.length >= 3 && 
        this.customer.address.length >= 3 &&
        this.customer.city.length >= 3 &&
        this.customer.state.length >= 3 &&
        this.customer.zip.length == 5 &&
        this.customer.phone.length == 14)
        return true
      else
        return false

    }

  },

  methods: {

    format,

    distanceInWordsToNow,

    ticketsSubtotal(tickets) {

      const subtotal = tickets.reduce((total, ticket) => total + (ticket.price * ticket.amount), 0)

      return subtotal.toLocaleString('en-US', currencySettings)

    },

    handleErrors(event) {

      this.$refs.button.disabled = event.empty

      this.$refs.carderror.textContent = event.error ? event.error.message : ""

    },

    async submit() {

      this.submitted = true

      const result = await this.stripe.confirmCardPayment(this.clientSecret, { payment_method: { card: this.cardElement } })

      const data = await result.paymentIntent.id

      const response = await fetch('/api/public/sales', {
        method: 'POST',
        headers: { "Content-Type": "application/json", "accept": "application/json" },
        body: JSON.stringify({ 
          sale: this.sale,
          customer: this.customer, 
          payment_intent: data 
        })
      })

      const res = await response.json()

      // Route to thank you, clear cart
      
      this.$store.commit("Public/CLEAR_CART")

      this.$router.push({ name: 'confirmation', params: { sale: res.data } })

      this.submitted = false

    },

    async fetchStates() {
      
      try {
        
        const response = await fetch('/api/states')
        
        const states = await response.json()

        this.state_options = states.map((state, i) => ({
          
          key: i,

          text: state,

          value: state,

        }))

      } catch (error) {
        
        alert(`Error in fetchStates: ${error.message}`)

      }
    }

  }

}
</script>