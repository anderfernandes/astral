<template>
  <div id="checkout">
    
    <h2 class="ui dividing header">Checkout</h2>
    
    <div id="checkout-ui" v-if="sale.length > 0">
      
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
      
      <img class="ui small image" src="https://bookmesolid.com/wp-content/uploads/2018/12/powered-by-stripe.png" alt="Stripe">
      
      <!-- Display a payment form -->
      <form id="payment-form">
        
        <p id="card-error" ref="carderror" role="alert"></p>
        
        <div id="card-element"><!--Stripe.js injects the Card Element--></div>
        
        <button id="submit" ref="button" @click.prevent="submit" v-show="valid">
          <div class="spinner hidden" id="spinner"></div>
          <span id="button-text">Pay $ {{ total }}</span>
        </button>
        
        <br /><br />
        
        <p class="result-message hidden">
          Payment succeeded, see the result in your
          <a href="" target="_blank">Stripe dashboard.</a> Refresh the page to pay again.
        </p>
        
      </form>
    </div>

    <div class="ui blue icon message" v-else-if="sale.length <= 0">
      <i class="info circle icon"></i>
      <div class="content">
        <div class="header">There are no items in your cart</div>
        <p>Come back when you add tickets to your cart.</p>
      </div>
    </div>

  </div>
</template>

<script>

//import { loadStripe } from '@stripe/stripe-js'
//import { Elements } from '@stripe/stripe-js/'

import { mask } from 'vue-the-mask'

import { format, distanceInWordsToNow } from 'date-fns'

import { createNamespacedHelpers } from 'vuex'

const { mapState, mapActions, mapGetters } = createNamespacedHelpers('Public')

const currencySettings = { minimumFractionDigits: 2, maximumFractionDigits: 2 }

export default {

  directives: { mask },

  data: () => ({

    loading: true,

    hasError: false,

    stripe: null,

    cardElement: null,

    clientSecret: null,

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

    ]

  }),
  

  async mounted() {

    if (this.sale.length > 0) {

      await this.getPaymentIntent()

      try {
        
        this.stripe = Stripe(this.gateway_key)

        this.createStripeElements()

      } catch (error) {
        
        this.hasError = true

      }

      await this.fetchStates()

    }

    this.loading = false

    //this.cardElement.on("change", this.handleErrors(event))

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

    async getPaymentIntent() {

      try {

        const response = await fetch('/api/public/stripe', {
          method: 'POST',
          headers: { "Content-Type": "application/json", "accept": "application/json" },
          body: JSON.stringify({ total : this.total })
      })

      const data = await response.json()

      this.clientSecret = data.client_secret

      } catch (e) {
        
        this.hasError = true

      }

    },

    ticketsSubtotal(tickets) {

      const subtotal = tickets.reduce((total, ticket) => total + (ticket.price * ticket.amount), 0)

      return subtotal.toLocaleString('en-US', currencySettings)

    },

    createStripeElements() {

      var elements = this.stripe.elements();

      this.cardElement = elements.create('card')
      
      this.cardElement.mount("#card-element")

      this.cardElement.on("change", event => this.handleErrors(event))

    },

    handleErrors(event) {

      this.$refs.button.disabled = event.empty

      this.$refs.carderror.textContent = event.error ? event.error.message : ""

    },

    async submit() {

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

      // Route to thank you, clear cart
      alert("Sale confirmed!")

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

<style>

.result-message {
  line-height: 22px;
  font-size: 16px;
}

.result-message a {
  color: rgb(89, 111, 214);
  font-weight: 600;
  text-decoration: none;
}

.hidden {
  display: none;
}

#card-error {
  color: rgb(105, 115, 134);
  text-align: left;
  font-size: 13px;
  line-height: 17px;
  margin-top: 12px;
}

#card-element {
  border-radius: 4px 4px 0 0 ;
  padding: 12px;
  border: 1px solid rgba(50, 50, 93, 0.1);
  height: 44px;
  width: 100%;
  background: white;
}

#payment-request-button {
  margin-bottom: 32px;
}

/* Buttons and links */
button {
  margin-top: 1rem;
  background: #5469d4;
  color: #ffffff;
  font-family: Arial, sans-serif;
  border-radius: 4px;
  border: 0;
  padding: 12px 16px;
  font-size: 16px;
  font-weight: 600;
  cursor: pointer;
  display: block;
  transition: all 0.2s ease;
  box-shadow: 0px 4px 5.5px 0px rgba(0, 0, 0, 0.07);
  width: 50%;
  float: right;
}

button:hover {
  filter: contrast(115%);
}

button:disabled {
  opacity: 0.5;
  cursor: default;
}

/* spinner/processing state, errors */
.spinner,
.spinner:before,
.spinner:after {
  border-radius: 50%;
}

.spinner {
  color: #ffffff;
  font-size: 22px;
  text-indent: -99999px;
  margin: 0px auto;
  position: relative;
  width: 20px;
  height: 20px;
  box-shadow: inset 0 0 0 2px;
  -webkit-transform: translateZ(0);
  -ms-transform: translateZ(0);
  transform: translateZ(0);
}

.spinner:before,
.spinner:after {
  position: absolute;
  content: "";
}

.spinner:before {
  width: 10.4px;
  height: 20.4px;
  background: #5469d4;
  border-radius: 20.4px 0 0 20.4px;
  top: -0.2px;
  left: -0.2px;
  -webkit-transform-origin: 10.4px 10.2px;
  transform-origin: 10.4px 10.2px;
  -webkit-animation: loading 2s infinite ease 1.5s;
  animation: loading 2s infinite ease 1.5s;
}

.spinner:after {
  width: 10.4px;
  height: 10.2px;
  background: #5469d4;
  border-radius: 0 10.2px 10.2px 0;
  top: -0.1px;
  left: 10.2px;
  -webkit-transform-origin: 0px 10.2px;
  transform-origin: 0px 10.2px;
  -webkit-animation: loading 2s infinite ease;
  animation: loading 2s infinite ease;
}

@-webkit-keyframes loading {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

@keyframes loading {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

</style>