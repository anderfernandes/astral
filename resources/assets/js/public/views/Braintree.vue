<template>
  <div id="braintree">

    <div class="ui active dimmer" v-if="submitted">
      <div class="ui text loader">
        Working on it, please wait...
      </div>
    </div>

    <div class="ui horizontal divider header">
        <i :class="`cc paypal icon`"></i>
        Secure Payment (Powered by Braintree and Paypal)
    </div>

    <div id="dropin-container"></div>
    <form id="checkout-form">
      <div id="payment-form"></div>
      <input type="submit" :value="`Pay ${total}`">
    </form>

  </div>
</template>

<script>
import { createNamespacedHelpers } from 'vuex'

const { mapGetters, mapState } = createNamespacedHelpers('Public')

export default {

  props: ['valid', 'customer'],
  
  data: () => ({
    
    loading: true,
    hasError: false,
    errorMessage: null,
    submitted: false,

  }),

  async mounted() {

    await this.createClient()
    
  },

  methods: {

    async createClient() {

      try
      {
        const response = await fetch('/api/public/braintree', {
          method: 'POST',
          headers: { "Content-Type": "application/json", "accept": "application/json" },
          body: JSON.stringify({ total: parseFloat(this.total) })
        })
        const data = await response.json()

        //this.client_token = data.client_token

        braintree.setup(data.client_token, 'dropin', {
          container: 'dropin-container',
          form: 'checkout-form',
          onReady: () => { alert('Done loading braintree') },
          onPaymentMethodReceived: obj => {
            
            this.submitted = true
            
            const request = {
              method: 'POST',
              headers: { "Content-Type": "application/json", "accept": "application/json" },
              body: JSON.stringify({ 
                sale: this.sale,
                customer: this.customer, 
                total: this.total,
                braintree: obj
              })
            }

            /*
            const response = await fetch('/api/public/sales', request)

            const res = await response.json()
            */

            fetch('/api/public/sales', request)
              .then(response => response.json())
              .then(res => {
                // Route to thank you, clear cart
          
                this.$store.commit("Public/CLEAR_CART")

                this.$router.push({ 
                  name: 'confirmation', 
                  params: {
                    sale: res.data,
                    message: res.message,
                    type: res.type,
                  },
                })

                this.submitted = false
              })

          }
        })

      }
      catch (e)
      {
        this.hasError = true
        this.errorMessage = `Error setting up online payment server: ${e.message}`
      }

    },

    async submit() {

      try {
        //alert(document.querySelector('[name="payment_method_nonce"]').value)
      } catch (e) {
        //alert(e)
      }

    }

  },

  computed: {
    
    ...mapGetters({ total: 'total' }),
    
    ...mapState(['sale']),
  }
}
</script>

<style>
input[type=submit] {
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

input[type=submit]:hover {
  filter: contrast(115%);
}

input[type=submit]:disabled {
  opacity: 0.5;
  cursor: default;
}
</style>