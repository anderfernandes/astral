<template>
  <div class="ui grid">
    <div class="twelve wide computer sixteen mobile column" v-if="!loading">
      <sui-tab active-index="0">
        <sui-tab-pane icon="ticket" title="Tickets" :label="events.length.toString()" v-if="events.length > 0">
          <div class="ui divided items" v-if="events">
            <div class="item" v-for="event in events" :key="event.id">
              <div class="ui tiny image">
                <img :src="event.show.cover" :alt="event.show.name">
              </div>
              <div class="content">
                <div class="header">
                  {{ event.show.name }}
                </div>
                <div class="meta">
                  <div class="ui black label">{{ event.show.type }}</div>
                  <div class="ui inverted label" :style="{ backgroundColor: event.type.color }">{{ event.type.name }}</div>
                </div>
                <div class="meta">
                  {{ isToday(event.start) ? 'Today' : format('dddd') }}
                  @{{ format(event.start, 'h:mm A') }} |
                  {{ event.seats }} {{ event.seats == 1 ?'seat' : 'seats' }} available
                </div>
                <div class="description">
                    <div class="ui basic black button"
                      v-for="ticket in event.type.allowed_tickets" :key="ticket.id"
                      @click="addTicket({event, ticket})"
                    >
                      {{ ticket.name }} $ {{ ticket.price.toFixed(2) }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </sui-tab-pane>
        <sui-tab-pane icon="box" title="Products" :label="products.length.toString()" v-if="products.length > 0">
          <div class="ui six link cards">
            <div class="card" v-for="product in products" :key="product.id" @click="addProduct(product)">
              <div class="image">
                <img :src="product.cover" :alt="product.name">
              </div>
              <div class="content">
                <div class="header">
                  {{ product.name }}
                </div>
                <div class="meta">
                  <div class="ui basic black label">$ {{ product.price.toFixed(2) }}</div>
                </div>
              </div>
            </div>
          </div>
        </sui-tab-pane>
      </sui-tab>
    </div>
    <div class="four wide computer sixteen mobile column" v-if="!loading">
      <div class="ui form">
        <div class="field">
          <sui-dropdown placeholder="Customer" search selection :options="customers" v-model="customer_id" />
        </div>
        <div class="field">
          <div class="ui labeled input error">
            <div class="ui basic label">$</div>
            <input type="text" placeholder="Tendered" focus v-model="tendered" style="text-align:right">
          </div>
        </div>
        <div class="field" v-if="settings.tax">
          <div class="ui four column grid">
            <div class="column">
              <div class="ui small header">
                <div class="sub header">Subtotal</div>
                $ {{ sale.subtotal.toFixed(2) }}
              </div>
            </div>
            <div class="column">
              <div class="ui small header">
                <div class="sub header">Tax ({{ (settings.tax * 100).toFixed(2) }}%)</div>
                $ {{ sale.tax.toFixed(2) }}
              </div>
            </div>
            <div class="column">
              <div class="ui small header">
                <div class="sub header">Total</div>
                $ {{ sale.total.toFixed(2) }}
              </div>
            </div>
            <div class="column">
              <div class="ui small header">
                <div class="sub header">Change</div>
                $ {{ sale.change.toFixed(2) }}
              </div>
            </div>
          </div>
        </div>
        <div class="field">
          <sui-dropdown placeholder="Customer" search selection :options="payment_methods" v-model="sale.payment_method_id" />
        </div>
        <div class="field">
          <input type="text" placeholder="Card or Check reference" v-model="sale.reference">
        </div>
        <div class="field">
          <input type="text" placeholder="Memo" v-model="sale.memo">
        </div>
        <div class="field">
          <div class="ui two buttons">
            <div class="ui negative button">
              Cancel
            </div>
            <sui-button positive :disabled="!((sale.tickets.length > 0 || sale.products.length > 0) && (sale.total >= 0) && (sale.balance >= 0))" @click.prevent="submit">
              Charge $ {{ sale.total.toFixed(2) }}
            </sui-button>
          </div>
        </div>
      </div>
      <div class="ui middle aligned list" v-if="sale.products.length > 0">
        <div class="ui small horizontal divider header">
          <i class="small box icon"></i> Products
        </div>
        <div class="item" v-for="product in sale.products" :key="product.id">
          <img :src="product.cover" :alt="product.name" class="ui avatar image">
          <div class="content">
            <div class="header">
              {{ product.name }}
              <i class="yellow minus circle icon" @click="removeProduct(product)"></i>
              <i class="red times circle outline icon" @click="clearProduct(product)"></i>
            </div>
          </div>
          <div class="right floated content">
            {{ product.quantity }} x $ {{ product.price.toFixed(2) }}
          </div>
        </div>
      </div>
      <div class="ui small horizontal divider header" v-if="sale.tickets.length > 0">
        <i class="small ticket icon"></i> Tickets
      </div>
      <div class="ui middle aligned list" v-for="t in sale.tickets" :key="t.id" style="margin: 0.5em 0">
        <div class="item" v-for="ticket in t.tickets" :key="ticket.id">
          <img :src="t.event.show.cover" :alt="t.event.show.name" class="ui avatar image">
          <div class="content">
            <div class="header">
              {{ ticket.name }}
              <i class="yellow minus circle icon" @click="removeTicket({ t, ticket })"></i>
              <i class="red times circle outline icon" @click="clearTicket({ t, ticket })"></i>
            </div>
          </div>
          <div class="right floated content">
            {{ ticket.quantity }} x $ {{ ticket.price.toFixed(2) }}
          </div>
        </div>
      </div>
    </div>
    <div class="ui sixteen wide column" v-else>
      <sui-loader active centered inline content="Loading..." />
    </div>
  </div>
</template>

<script>

import {format, isToday} from 'date-fns'
import axios from 'axios'

export default {
  data: () => ({
    loading: true,
    // Dropdown options
    events: [],
    customers: [],
    products: [],
    payment_methods: [],
    // POST data
    payment_method_id: 1,
    customer_id: 1,
  }),

  async created() {
    this.loading = true
    await this.$store.dispatch('fetchSettings')
    await this.fetchProducts()
    await this.fetchEvents()
    await this.fetchCustomers()
    await this.fetchPaymentMethods()
    this.loading = false
  },

  methods: {
    addTicket(payload) {
      this.$store.commit('Cashier/ADD_TICKET', payload)
    },
    removeTicket(payload) {
      // Vue did not like the word "event" as a variable/object name in an event handler...
      const data = {
        event: payload.t.event,
        ticket: payload.ticket
      }
      this.$store.commit('Cashier/REMOVE_TICKET', data)
    },
    clearTicket(payload) {
      // Vue did not like the word "event" as a variable/object name in an event handler...
      const data = {
        event: payload.t.event,
        ticket: payload.ticket
      }
      this.$store.commit('Cashier/CLEAR_TICKET', data)
    },
    addProduct(product) {
      this.$store.commit('Cashier/ADD_PRODUCT', product)
    },
    removeProduct(product) {
      this.$store.commit('Cashier/REMOVE_PRODUCT', product)
    },
    clearProduct(product) {
      this.$store.commit('Cashier/CLEAR_PRODUCT', product)
    },
    async fetchEvents() {
      try {
        const response = await axios.get('/api/cashier/events')
        Object.assign(this, { events: response.data.data })
      } catch (error) {
        alert(`Error in fetchEvents: ${ error.message }`)
      }
    },
    async fetchCustomers() {
      try {
        const response = await axios.get('/api/cashier/users')
        const customers = response.data.data.map(customer => ({
          text: `${customer.fullname}`,
          value: customer.id
        }))
        Object.assign(this, { customers })
        Object.assign(this.sale, { customer_id: customers[0].value })
      } catch (error) {
        alert(`Error in fetchEvents: ${ error.message }`)
      }
    },
    async fetchPaymentMethods() {
      try {
        const response = await axios.get('/api/cashier/payment-methods')
        const payment_methods = response.data.data.map(payment_method => ({
          text: payment_method.name,
          value: payment_method.id,
          icon: payment_method.icon,
        }))
        Object.assign(this, { payment_methods })
      } catch (error) {
        alert(`Error in fetchPaymentMethods: ${ error.message }`)
      }
    },
    async fetchProducts() {
      try {
        const response = await axios.get('/api/cashier/products')
        const products = response.data.data.map(product => ({
          text: product.name,
          value: product.id,
          cover: product.cover,
          stock: product.stock,
          id: product.id,
          name: product.name,
          price: product.price,
        }))
        Object.assign(this, { products });
      } catch (error) {
        alert(`Error in fetchProducts: ${error.message}`)
      }
    },
    async submit() {
      this.loading = true
      const response = await axios.post('/api/cashier/sales', this.sale)
      this.loading = false
      this.$router.push({ name: 'after-sale' })
    },
    format, isToday
  },

  computed: {
    sale() { return this.$store.state.Cashier.sale },
    settings() { return this.$store.state.Sale.settings },
    tendered: {
      set(value) { 
        this.$store.commit('Cashier/SET_TENDERED', value == '' ? 0 : parseFloat(value)) 
      },
      get() { return this.$store.state.Cashier.sale.tendered },
    }
  },

  watch: {
    sale: {
      handler() {
        if (this.sale.payment_method_id != 1)
          Object.assign(this.sale, { tendered: this.sale.total })
        else
          Object.assign(this.sale, { tendered: 0 })
        this.$store.commit('Cashier/CALCULATE_TOTALS', this.settings.tax) 
      },
      deep: true,
    },
    customer_id() { Object.assign(this.sale, { customer_id: this.customer_id }) },
    
  },
}
</script>

<style>
  i.red.times.circle.outline.icon:hover, 
  i.yellow.minus.circle.icon { 
    cursor: pointer 
  }
</style>