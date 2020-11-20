<template>
    <div id="stripe">

        <div class="ui active dimmer" v-if="submitted">
          <div class="ui text loader">
            Working on it, please wait...
          </div>
        </div>

        <div class="ui horizontal divider header">
            <i :class="`cc stripe icon`"></i>
            Secure Payment (Powered by Stripe)
        </div>
      
      <!-- Display a payment form -->
        <form id="payment-form">
            
            <p id="card-error" ref="carderror" role="alert"></p>
            
            <div id="card-element"><!--Stripe.js injects the Card Element--></div>
            
            <button id="submit" ref="button" @click.prevent="submit" :disabled="!valid">
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
</template>

<script>

import { createNamespacedHelpers } from 'vuex'

const { mapState, mapGetters } = createNamespacedHelpers('Public')

export default {
  
  props: ['valid', 'customer'],
  
  data: () => ({
      stripe: null,
      cardElement: null,
      clientSecret: null,
      hasError: false,
      errorMessage: null,
      submitted: false,
  }),
  
  async mounted() {
  
    try {
      
      await this.getPaymentIntent()
      this.stripe = Stripe(this.gateway_key)
      this.createStripeElements()

    } catch (e) {

      alert(e.message)

    }

  },

  computed: {

    ...mapState(['sale']),

    ...mapGetters({ 

      total: 'total',

      gateway_key: 'gateway_key',
    
    }),

  },

  methods: {
    
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
          this.errorMessage = `Error getting payment intent: ${e.message}`
        }

    },
    
    createStripeElements() {
        var elements = this.stripe.elements();
        this.cardElement = elements.create('card')
        this.cardElement.mount("#card-element")
        this.cardElement.on("change", event => this.handleErrors(event))
    },
    
    handleErrors(event) {
        this.$refs.button.disabled = !this.valid && event.empty

        this.$refs.carderror.textContent = event.error ? event.error.message : ""
    },

    async submit() {

      if (!this.valid) {
        alert('Please double check the form data and make sure you entered everything correctly.')
        return
      }

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