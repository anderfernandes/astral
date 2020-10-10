<template>
  <div id="checkout">
    <h2 class="ui dividing header">Checkout</h2>
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
          <th colspan="4" class="right aligned">
            <strong>Tax: $ {{ subtotal }}</strong>
          </th>
        </tr>
        <tr>
          <th colspan="4" class="right aligned">
            <strong>Subtotal: $ {{ tax }}</strong>
          </th>
        </tr>
        <tr>
          <th colspan="4" class="right aligned">
            <strong>Total: $ {{ total }}</strong>
          </th>
        </tr>
      </tfoot>
    </table>
    <form class="ui form">
      <div class="two fields">
        <div class="field">
          <label for="firstname">First Name</label>
          <input name="firstname" placeholder="First Name" type="text">
        </div>
        <div class="field">
          <label for="lastname">Last Name</label>
          <input name="lastname" placeholder="Last Name" type="text">
        </div>
        <div class="field">
          <label for="email">Email</label>
          <input type="email" placeholder="your@email" name="email">
        </div>
      </div>
    </form>
    <img class="ui small image" src="https://bookmesolid.com/wp-content/uploads/2018/12/powered-by-stripe.png" alt="Stripe">
    <!-- Display a payment form -->
    <form id="payment-form">
      <p id="card-error" ref="carderror" role="alert"></p>
      <div id="card-element"><!--Stripe.js injects the Card Element--></div>
      <button id="submit" ref="button" @click.prevent="submit">
        <div class="spinner hidden" id="spinner"></div>
        <span id="button-text">Pay $ {{ total }}</span>
      </button>
      <p class="result-message hidden">
        Payment succeeded, see the result in your
        <a href="" target="_blank">Stripe dashboard.</a> Refresh the page to pay again.
      </p>
    </form>
  </div>
</template>

<script>

//import { loadStripe } from '@stripe/stripe-js'
//import { Elements } from '@stripe/stripe-js/'

import { format, distanceInWordsToNow } from 'date-fns'

import { createNamespacedHelpers } from 'vuex'

const { mapState, mapActions, mapGetters } = createNamespacedHelpers('Public')

const currencySettings = { minimumFractionDigits: 2, maximumFractionDigits: 2 }

export default {

  data: () => ({

    stripe: null,

    cardElement: null,

    clientSecret: null,

  }),
  
  async mounted() {

    await this.getPaymentIntent()

    this.stripe = Stripe(this.gateway_key)

    this.createStripeElements()

    //this.cardElement.on("change", this.handleErrors(event))

  },

  computed: {

    ...mapState([ 'sale' ]),

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

    async getPaymentIntent() {

      const response = await fetch('/api/public/stripe', {
        method: 'POST',
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ total : this.total })
      })

      const data = await response.json()

      this.clientSecret = data.client_secret

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

      const response = await fetch('/api/public/store', {
        method: 'POST',
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ sale: this.sale, payment_intent: data })
      })

      // Route to thank you

    },

  }

}
</script>

<style>

form {
  /*width: 30vw;*/
  /*min-width: 500px;
  align-self: center;
  box-shadow: 0px 0px 0px 0.5px rgba(50, 50, 93, 0.1),
    0px 2px 5px 0px rgba(50, 50, 93, 0.1), 0px 1px 1.5px 0px rgba(0, 0, 0, 0.07);
  border-radius: 7px;
  padding: 40px;*/
}

input {
  border-radius: 6px;
  margin-bottom: 6px;
  padding: 12px;
  border: 1px solid rgba(50, 50, 93, 0.1);
  height: 44px;
  font-size: 16px;
  width: 100%;
  background: white;
}

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