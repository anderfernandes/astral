<template>
  <div id="braintree">

    <div class="ui horizontal divider header">
        <i :class="`cc paypal icon`"></i>
        Secure Payment (Powered by Braintree and Paypal)
    </div>

    <form ref="form" action="/" id="my-sample-form" method="post">

      <label for="card-number">Card Number</label>
      <div id="card-number"></div>
      

      <label for="cvv">CVV</label>
      <div id="cvv" class="field"></div>

      
      <label for="expiration-date">Expiration Date</label>
      <div id="expiration-date" class="field"></div>

      
      <input ref="submit" type="submit" value="Pay" disabled />
      
    </form>


  </div>
</template>

<script>
export default {

  props: ['valid', 'customer'],
  
  data: () => ({
    
    client_token: null,
    hostedFields: null,
    loading: true,
    hasError: false,
    errorMessage: null,
    submitted: false,

  }),

  async mounted() {

    await this.createClient()
    await this.createHostedFields()

  },

  methods: {

    async createClient() {

      try
      {
        const response = await fetch('/api/public/braintree', {
          method: 'POST',
          headers: { "Content-Type": "application/json", "accept": "application/json" },
          body: JSON.stringify({ total: this.total })
        })
        const data = await response.json()

        this.client_token = data.client_token

      }
      catch (e)
      {
        this.hasError = true
        this.errorMessage = `Error setting up online payment server: ${e.message}`
      }

    },

    async createHostedFields() {

      const clientInstance = await braintree.client.create({
        authorization: this.client_token
      })

      const options = {
        client: clientInstance,
        fields: {
          number: {
            selector: '#card-number',
            placeholder: 'Credit Card',
          },
          cvv: {
            selector: '#cvv',
            placeholder: 'CVV',
          },
          expirationDate: {
            selector: '#expiration-date',
            placeholder: 'Expiration Date',
          }
        }
      }

      const hostedFieldsInstance = braintree.hostedFields.create(options)

      // Tokenize card

      // Error handling

    }

  }
}
</script>

<style>
#card-number {
  border: 1px solid #333;
  -webkit-transition: border-color 160ms;
  transition: border-color 160ms;
}

#card-number.braintree-hosted-fields-focused {
  border-color: #777;
}

#card-number.braintree-hosted-fields-invalid {
  border-color: tomato;
}

#card-number.braintree-hosted-fields-valid {
  border-color: limegreen;
}
</style>