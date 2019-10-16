<template>
  <div class="ui grid">
    <div class="twelve wide computer sixteen mobile column">
      <div class="ui horizontal list" v-if="products.length > 0">
        <div class="item" v-for="product in products" :key="product.id" @click="addProduct(product)">
          <img :src="product.cover" :alt="product.name" class="ui avatar image">
          <div class="content">
            <div class="header">{{ product.name }}</div>
            $ {{ product.price.toFixed(2) }}
          </div>
        </div>
      </div>
      <div class="ui divider" v-if="products.length > 0"></div>
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
              {{ event.seats }} {{ event.seats == 1 ?'seat' : 'seats' }}
            </div>
            <div class="description">
              <div class="ui labeled button" 
                v-for="ticket in event.type.allowed_tickets" :key="ticket.id"
                @click="addTicket({event, ticket})"
                >
                <div class="ui basic black button">{{ ticket.name }}</div>
                <div class="ui basic black label">$ {{ ticket.price.toFixed(2) }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="four wide computer sixteen mobile column">
      <div class="ui form">
        <div class="field">
          <sui-dropdown placeholder="Customer" search selection :options="customers" v-model="customer_id" />
        </div>
        <div class="field">
          <div class="ui two column grid">
            <div class="column">
              <div class="ui huge left aligned header">
                $
              </div>
            </div>
            <div class="column">
              <div class="ui huge right aligned header">
                {{ total.toFixed(2) }}
              </div>
            </div>
          </div>
        </div>
        <div class="field">
          <div class="ui three column grid">
            <div class="column">
              <div class="ui small header">
                <div class="sub header">Change</div>
                $ 0.00
              </div>
            </div>
            <div class="column">
              <div class="ui small header">
                <div class="sub header">Subtotal</div>
                $ 0.00
              </div>
            </div>
            <div class="column">
              <div class="ui small header">
                <div class="sub header">Tax (8.25%)</div>
                $ 0.00
              </div>
            </div>
          </div>
        </div>
        <div class="field">
          <sui-dropdown placeholder="Customer" search selection :options="payment_methods" v-model="payment_method_id" />
        </div>
        <div class="field">
          <input type="text" placeholder="Card or Check reference">
        </div>
        <div class="field">
          <div class="ui two buttons">
            <div class="ui negative button">
              Cancel
            </div>
            <div class="ui positive button">
              Charge
            </div>
          </div>
        </div>
      </div>
      <div class="ui middle aligned list" v-if="sale.products.length > 0">
        <div class="ui small horizontal divider header">
          <i class="small box icon"></i> Products
        </div>
        <div class="item" v-for="product in sale.products" :key="product.id" @click="removeProduct(product)">
          <img :src="product.cover" :alt="product.name" class="ui avatar image">
          <div class="content">
            <div class="header">{{ product.name }}</div>
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
            <div class="header">{{ ticket.name }}</div>
          </div>
          <div class="right floated content">
            {{ ticket.quantity }} x $ {{ ticket.price.toFixed(2) }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import {format, isToday} from 'date-fns'

export default {
  data: () => ({
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
    await this.fetchProducts()
    await this.fetchEvents()
    await this.fetchCustomers()
    await this.fetchPaymentMethods()
  },
  methods: {
    addTicket(data) {
      this.$store.commit('Cashier/ADD_TICKET', data)
    },
    addProduct(product) {
      this.$store.commit('Cashier/ADD_PRODUCT', product)
    },
    removeProduct(product) {
      this.$store.commit('Cashier/REMOVE_PRODUCT', product)
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
          text: `${customer.firstname} ${customer.lastname}`,
          value: customer.id
        }))
        Object.assign(this, { customers })
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
    format, isToday
  },
  computed: {
    sale() { return this.$store.state.Cashier.sale },
    total() { return this.$store.getters['Cashier/total'] },
  },
}
</script>