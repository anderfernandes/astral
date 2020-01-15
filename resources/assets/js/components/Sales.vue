<template>
  <div class="ui grid">
    <div class="ui eight wide column" v-for="sale in sales" :key="sale.id">
      <div class="ui grid" style="margin-top: 2rem">
        <div class="eight wide column">
        <div class="ui grid">
          <div class="ui eight wide column" v-for="event in sale.events" :key="event.id">
            <img class="ui medium centered image" :src="event.show.cover" :alt="event.show.name">
          </div>
        </div>
        </div>
        <div class="eight wide column">
          <div class="ui fluid card">
            <div class="content">
              <div class="header">
                <i class="calendar alternate icon"></i>
                {{ moment(sale.start).calendar(null, { nextWeek: "dddd, MMMM D, YYYY", sameElse: "dddd, MMMM D, YYYY"}) }}
              </div>
              <div class="description">
                {{ sale.customer.name }} (#{{ sale.id }}) <br />
                {{ sale.customer.organization }} <br />
                <i class="at icon"></i> {{ sale.customer.email }} <br />
                <i class="phone icon"></i> {{ sale.customer.phone }}
              </div>
              <div class="description">
                Created by <i class="user circle icon"></i> <strong>{{ sale.creator }}</strong><br />
                on {{ moment(sale.created_at).format("dddd, MMMM D, YYYY") }}
              </div>
              <div class="description">
                <div class="ui label" v-for="ticket in sale.tickets" :key="ticket.id">
                  {{ ticket.type }} ({{ ticket.quantity }})
                </div>
              </div>
            </div>
            <div class="extra content">
              <div class="right floated meta">
                <div class="ui green tag label">$ {{ parseFloat(sale.total).toFixed(2) }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import axios from 'axios'

export default {
  name: 'Sales',
  data() {
    return {
      sales: [],
    }
  },
  created() {
    this.fetchSales()
    setInterval(() => this.fetchSales(), 10000)
  },
  methods: {
    fetchSales() {
      axios.get('/api/calendar-events')
        .then(response => this.sales = response.data)
    }
  }
}
</script>

<style>
</style>
