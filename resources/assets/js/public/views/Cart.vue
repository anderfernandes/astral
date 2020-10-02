<template>
  <div id="cart">
    <h1 class="ui dividing header">Cart</h1>
    <div class="ui divided items">
      <div class="item" v-for="item in cart" :key="item.event.id">
        <div class="image">
          <img :src="item.event.show.cover" :alt="item.event.show.name">
        </div>
        <div class="content">
          <div class="header">
            {{ item.event.show.name }}
            <div class="ui black label">{{ item.event.show.type }}</div>
          </div>
          <div class="meta">
            {{ item.event.start }}
          </div>
          <div class="description" v-if="item.tickets.length > 0">
            <div class="ui black basic label" v-for="ticket in item.tickets" :key="ticket.id" v-if="ticket.amount > 0">
              {{ ticket.name }}
              <div class="detail">
                {{ ticket.amount }} X
                $ {{ ticket.price }}
              </div>
            </div>
          </div>
          <div class="extra">
            <router-link class="ui right floated primary button" 
              :to="{ name: 'event', params: { id: item.event.id }}">
              Change Tickets
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  
  computed: {

    cart() { return this.$store.state.Public.sale }

  }

}
</script>