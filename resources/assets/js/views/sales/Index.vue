<template>
  <div class="ui container" style="min-height:100vh !important">

    <sui-dimmer :active="isLoading" inverted>
      <sui-loader content="Loading sales, please wait..." />
    </sui-dimmer>

    <div class="ui basic segment" v-if="!isLoading">

      <modal id="event-type">
        <sui-header icon="info circle">Select an event type</sui-header>
        <sui-modal-content scrolling>
          <div class="ui two column grid">
            <div class="column"  v-for="event_type in event_types" :key="event_type.id">
              <sui-segment :style="{ backgroundColor: event_type.color, color: 'white' }" id="event-type"
                        @click="$router.push({ name: 'create', query: { type: event_type.id } }); $store.commit('TOGGLE_MODAL', false)"
                       >
                <div class="ui inverted small header">
                  {{ event_type.name }}
                  <div class="ui small label" style="background-color: transparent; border: 1px solid white !important; color: white">
                    {{ event_type.public ? "public" : "private" }}
                  </div>
                  <div class="sub header">{{ event_type.description }}</div> <br>
                  <div class="sub header" v-if="event_type.allowed_tickets && event_type.allowed_tickets.length > 0">
                    <div class="ui tiny label" v-for="ticket in event_type.allowed_tickets" :key="ticket.id"
                        style="background-color: transparent; border-width: 1px; border-color:white; color: white">
                        <i class="ticket icon"></i> {{ ticket.name }}
                        <div class="detail">$ {{ parseFloat(ticket.price).toFixed(2) }}</div>
                    </div>
                  </div>
                </div>
              </sui-segment>
            </div>
          </div>
        </sui-modal-content>
        <sui-modal-actions>
            <sui-button inverted @click="$store.commit('TOGGLE_MODAL', false)" icon="close">
              Close
            </sui-button>
        </sui-modal-actions>
      </modal>
      
      <div class="ui form">
        <div class="five inline fields">
          <div class="field">
            <div class="ui fluid icon input">
              <input v-model="query.id" type="number" min="1" placeholder="Sale #">
              <i class="search icon"></i>
            </div>
          </div>
          <div class="field">
            <sui-dropdown placeholder="All Customers"
                          v-model="query.customer_id" 
                          :options="customers.withoutOrganization" 
                          search fluid selection />
          </div>
          <div class="field">
            <sui-dropdown placeholder="All Organizations"
                          v-model="query.organization_id" 
                          :options="organizations" 
                          search fluid selection />
          </div>
          <div class="field">
            <sui-dropdown placeholder="All Sales Statuses" 
                          v-model="query.status" 
                          :options="statuses" 
                          fluid selection />
          </div>
          <div class="field" style="padding-right:0">
            <sui-dropdown placeholder="All Cashiers" 
                          v-model="query.cashier_id" 
                          :options="cashiers" 
                          search fluid selection />
          </div>
        </div>
      </div>

      <div v-if="sales && sales.length > 0">  
        <transition-group name="list" tag="div" appear>
          <div :class="`ui ${sale.status} sale segment`" v-for="sale in sales" :key="sale.id" 
              :style="getSaleColor(sale.status)" 
              @click="$router.push({name: 'show', params: { id: sale.id }})">
            <div class="ui items">
              <sale-box :sale="sale" :key="sale.id"></sale-box>
            </div>
          </div>
        </transition-group>
      </div>
      
      <observer @intersect="fetchSales"></observer>

      <sui-button icon="pencil" circular color="black" @click="$store.commit('TOGGLE_MODAL', true)"
                  style="position:fixed; z-index: 999; right: 11rem; bottom: 3rem">
        Create Sale
      </sui-button>

    </div>
  </div>
</template>

<script>

  import { mapActions, mapGetters } from 'vuex'
  import SaleBox  from '../../components/SaleBox'
  import Observer from '../../components/Observer'
  import Modal    from '../../components/Modal'
  
  export default {

    components: { SaleBox, Observer, Modal },

    methods: {
      ...mapActions(['fetchSales', 'fetchCustomers', 'fetchOrganizations', 'fetchCashiers', 'fetchEventTypes'])
    },

    watch : {
      query : {
        handler : function() {
          this.page = 1
          this.fetchSales()
        },
        deep    : true,
      }
    },

    computed: {

      page : {
        set(value) { this.$store.commit('SET_PAGE', value) },
        get()      { return this.$store.getters.page },
      },

      ...mapGetters(['sales', 'customers', 'organizations', 'cashiers', 'event_types', 'query']),

      statuses() {
        return [
          { key: "all",       text: "All Sale Statuses",      value: null,      icon: ""             },
          { key: "open",      text: "Open",                   value: "open",      icon: "unlock"     },
          { key: "confirmed", text: "Confirmed",              value: "confirmed", icon: "thumbs up"  },
          { key: "complete",  text: "Completed",              value: "complete",  icon: "check"      },
          { key: "tentative", text: "Tentative",              value: "tentative", icon: "help"       },
          { key: "canceled",  text: "Canceled",               value: "canceled",  icon: "remove"     },
          { key: "no show",   text: "No Show",                value: "no show",   icon: "thumbs down"},
        ]
      },
      
      // Loading spinner
      isLoading: {
        set(value) { this.$store.commit("SET_IS_LOADING", value) },
        get()      { return this.$store.getters.isLoading }
      },
    

    },
    async created() {
      
      document.title = `Astral - Sales`
      
      this.isLoading = await true
      await this.$store.commit("SET_PAGE", 1)
      await this.fetchEventTypes()
      await this.fetchCustomers()
      await this.fetchOrganizations()
      await this.fetchCashiers()
      await this.fetchSales()
      
      this.isLoading = await false
    },
  }
</script>
