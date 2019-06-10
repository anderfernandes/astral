<template>
  <div class="ui container">
    
    <sui-dimmer :active="isLoading" inverted>
      <sui-loader content="Loading..."></sui-loader>
    </sui-dimmer>
    
    <div class="ui basic segment">
    
      <modal></modal>
    
      <transition name="fade" mode="out-in">
        <div id="form" v-if="!isLoading">
          <!--- Buttons --->
          <div class="ui form">
            <div class="four inline fields" id="sale-form-fixed">
              <div class="field">
                <sui-button basic color="black" icon="left chevron" 
                            @click="$router.push({ name: 'index' })">
                  Back
                </sui-button>
                <sui-button @click="submit" label-position="left" color="green" icon="save"
                            :disabled="!enableSubmit">
                  Save
                </sui-button>
              </div>
              <div class="field"></div>
              <div class="required field" style="text-align: right">
                <label>Status</label>
              </div>
              <div class="required field" style="padding-right: 0">
                <sui-dropdown fluid selection direction="downward" v-if="statuses"
                              v-model="sale.status" label="Status"
                              :options="statuses"
                              placeholder="Sale Status"
                />
              </div>
            </div>
          </div>
          <!-- Form -->
          <div class="ui container">
            
            <br>

            <!--- Sale --->
            <div class="ui segment">
              <div class="ui horizontal divider header">
                <i class="dollar icon"></i> Sale
              </div>
              <sui-form>
                <sui-form-field required>
                  <label>Sell to</label>
                  <sui-dropdown fluid selection direction="upward" v-if="sell_to"
                                v-model="sale.sell_to"
                                :options="sell_to"
                                placeholder="Sell To"
                                :error="errors && errors.hasOwnProperty('sell_to')"></sui-dropdown>
                  <transition mode="out-in" name="fade">
                    <sui-label basic color="red" pointing 
                                v-if="errors && errors.hasOwnProperty('sell_to')">
                      {{ errors.sell_to[0] }}
                    </sui-label>
                  </transition>
                </sui-form-field>
                <sui-form-field required>
                  <label>Customer</label>
                  <sui-dropdown fluid direction="upward" v-if="customers.withOrganization"
                                v-model="sale.customer"
                                :options="customers.withOrganization"
                                placeholder="Customer"
                                search selection></sui-dropdown>
                  <transition mode="out-in" name="fade">
                    <sui-label basic color="red" pointing 
                                v-if="errors && errors.hasOwnProperty('customer')">
                      {{ errors.customer[0] }}
                    </sui-label>
                  </transition>
                </sui-form-field>
                <sui-form-field>
                  <label>Grades</label>
                  <sui-dropdown fluid multiple direction="upward" v-if="grades"
                                v-model="sale.grades"
                                :options="grades"
                                placeholder="Grades"
                                selection
                  />
                </sui-form-field>
  
                <!-- Event Form -->
                <div id="events">
                  <transition-group mode="out-in" name="fade">    
                    <event-form v-if="sale.customer != null" 
                                v-for="(n, i) in numberOfEvents"
                                :key="i"
                    />
                  </transition-group>
                </div>
  
                <br />

                <!-- Add Another Event -->
                <transition appear mode="out-in" name="fade">
                  <sui-button v-if="sale.selected_tickets.length > 0"
                              label-position="left" 
                              color="black" 
                              icon="calendar plus alternate"
                              @click.prevent="$store.commit('SET_NUMBER_OF_EVENTS')"
                              >
                    Add Another Event
                  </sui-button>
                </transition>
                
                <!-- Products -->
                <div class="ui segment" v-if="products.length > 0">
                  <div class="ui horizontal divider header">
                    <i class="box icon"></i> Products
                  </div>
                  <div class="ui form">
                      <div class="field">
                        <sui-dropdown fluid selection multiple search v-if="products"
                                      placeholder="Select products"
                                      :options="products"
                                      v-model="sale.products"
                        />
                    </div>
                  </div>
                  <transition mode="out-in" name="fade">
                    <div id="products" v-if="sale.products.length > 0">
                      <br>
                      <table class="ui selectable single line very compact table">
                      <thead>
                        <tr class="header">
                          <th>Product</th>
                          <th>Amount / Price</th>
                        </tr>
                      </thead>
                        <tbody name="fade" is="transition-group" mode="out-in">
                          <tr v-for="product in sale.selected_products"
                              :key="product.id">
                            <td>
                              <div class="ui small header">
                              <img :src="product.cover">
                                <div class="content">
                                  {{ product.name }}
                                  <div class="ui tiny black label">
                                    {{ product.type.name }}
                                  </div>
                                  <div class="sub header">
                                    {{ product.description }}
                                  </div>
                                </div>
                              </div>
                            </td>
                            <td>
                              <sui-button icon="plus" color="black" basic
                                          @click.prevent="product.amount++" />
                              <sui-button icon="refresh" color="black" basic :disabled="product.amount == 1"
                                          @click.prevent="product.amount = 1" />
                              <sui-button icon="minus" color="black" basic :disabled="product.amount == 1"
                                          @click.prevent="product.amount--" />
                              &nbsp;
                              <div class="ui right labeled input">
                                <input type="text" 
                                        style="width:auto"
                                        size="1"
                                        min="0" 
                                        v-model.number="product.amount"
                                        @input="$store.commit('CALCULATE_TOTALS')" 
                                        placeholder="Amount">
                                <div class="ui basic label">
                                  $ {{ product.price.toFixed(2) }} each
                                </div>
                              </div>
                              &nbsp;
                              <div class="ui red basic icon button" @click="$store.commit('REMOVE_PRODUCT', product)">
                                <i class="trash icon"></i>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </transition>
                </div>
              </sui-form>
            </div>

            <br>

            <!--- Payments --->
            <div class="ui segment">
              <div class="ui horizontal divider header">
                <i class="money icon"></i> Payments
              </div>
              <sui-form>
                <div class="four fields">
                  <div class="required field">
                    <label>Taxable</label>
                    <sui-dropdown v-model="sale.taxable" direction="upward" v-if="taxable"
                                  :options="taxable" icon=""
                                  placeholder="Taxable"
                                  selection />
                  </div>
                </div>
                <div class="four fields">
                  <div class="field">
                    <label>Payment Method</label>
                    <sui-dropdown fluid direction="upward" v-if="payment_methods"
                                  v-model="sale.payment_method"
                                  :options="payment_methods"
                                  placeholder="Payment Method"
                                  selection />
                  </div>
                  <div class="field">
                    <label>Tendered</label>
                    <div class="ui labeled input">
                      <div class="ui basic label">$</div>
                      <input type="text" placeholder="Tendered" 
                        v-model.number="sale.tendered">
                    </div>
                  </div>
                  <sui-form-field :error="parseFloat(change_due) < 0">
                    <label>Change Due</label>
                    <div class="ui labeled input">
                      <div class="ui basic label">$</div>
                      <input placeholder="Change Due" v-model="change_due" readonly>
                    </div>
                  </sui-form-field>
                  <sui-form-field :error="errors && errors.hasOwnProperty('reference')">
                    <label>Reference</label>
                    <sui-input placeholder="Reference" :error="!hasReference" v-model.number="sale.reference" />
                    <transition mode="in-out" name="fade">
                        <sui-label basic color="red" pointing 
                        v-if="errors && errors.hasOwnProperty('reference')">
                          {{ errors.reference[0] }}
                        </sui-label>
                        <sui-label basic color="red" pointing 
                        v-if="!hasReference">
                          What's the reference of the Credit Card or Check?
                        </sui-label>
                    </transition>
                  </sui-form-field>
                </div>
                <div class="ui small horizontal divider header" v-if="sale.payments.length > 0">
                  <i class="money icon"></i>
                  Payments
                </div>
                <table class="ui selectable single table" v-if="sale.payments.length > 0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Method</th>
                      <th>Amount Paid</th>
                      <th>Date</th>
                      <th>Cashier</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="payment in sale.payments" :key="payment.id">
                      <td>
                        <div class="ui header">
                          {{ payment.id }}
                        </div>
                      </td>
                      <td><i class="cc visa icon"></i>
                        {{ payment.method }}
                      </td>
                      <td>$ {{ payment.total }}</td>
                      <td>
                          {{ format(new Date(payment.created_at), $dateFormat.long) }}
                          ({{ distanceInWords(new Date(), new Date(payment.created_at), { addSuffix: true }) }})
                      </td>
                      <td>
                        <i class="user circle icon"></i>
                        {{ payment.cashier.name }}
                      </td>
                    </tr>
                  </tbody>
                </table>
              </sui-form>
            </div>

            <!--- Memos --->
            <div class="ui small horizontal divider header" v-if="sale.memos.length > 0">
              <i class="comments outline icon"></i>
              Memos
            </div>
            <div class="ui comments">
              <div class="comment" v-for="memo in sale.memos" :key="memo.id">
                <div class="avatar">
                  <i class="user circle big icon"></i>
                </div>
                <div class="content">
                  <div class="author">
                    {{ memo.author.name }}
                    <div class="ui black label">{{ memo.author.role }}</div>
                    <div class="metadata">
                      {{ format(new Date(memo.created_at), $dateFormat.long) }}
                      ({{ distanceInWords(new Date(), new Date(memo.created_at), { addSuffix: true }) }})
                    </div>
                  </div>
                  <div class="text">{{ memo.message }}</div>
                </div>
              </div>
            </div>
            <div class="ui form">
              <div class="field">
                <label>Write a memo:</label>
                <textarea v-model="sale.memo" 
                          cols="8" 
                          rows="2" 
                          placeholder="Write a memo" 
                          style="margin-bottom:10em"></textarea>
              </div>
              <transition mode="out-in" name="fade">
                  <sui-label basic color="red" pointing 
                              v-if="errors && errors.hasOwnProperty('memo')">
                    {{ errors.memo[0] }}
                  </sui-label>
                </transition>
            </div>
            
          </div>
          <!--- Totals --->
          <div class="ui grid">
            <div class="sixteen wide column" style="padding: 0 0 0 0 !important">
              <div class="ui bottom fixed sticky" style="width:100%; right:0">
                <div class="ui inverted segment" style="border-radius: 0 !important">
                  <div class="ui container">
                    <div class="ui inverted form">
                      <div class="five fields" v-if="sale">
                        <!--- Subtotal --->
                        <div class="field">
                          <label>Subtotal</label>
                          <div class="ui inverted transparent left icon input">
                            <i class="dollar icon"></i>
                            <input style="color:white; font-weight:bold" type="text" 
                                   :value="subtotal" v-if="subtotal != undefined">
                          </div>
                        </div>
                        <!--- Tax --->
                        <div class="field">
                          <label>Tax ({{ settings.tax * 100 }}%)</label>
                          <div class="ui inverted transparent left icon input">
                            <i class="dollar icon"></i>
                            <input style="color:white; font-weight:bold" type="text" 
                                   :value="tax" v-if="tax != undefined">
                          </div>
                        </div>
                        <!--- Total --->
                        <div class="field">
                          <label>Total</label>
                          <div class="ui inverted transparent left icon input">
                            <i class="dollar icon"></i>
                            <input style="color:white; font-weight:bold" 
                                  type="text" readonly
                                  :value="total" v-if="total != undefined">
                          </div>
                        </div>
                        <!--- Paid --->
                        <div class="field">
                          <label>Paid</label>
                          <div class="ui inverted transparent left icon input">
                            <i class="dollar icon"></i>
                            <input style="color:white; font-weight:bold" type="text" 
                                   :value="sale.paid.toLocaleString('en-US', currencySettings)">
                          </div>
                        </div>
                        <!--- Paid --->
                        <div class="field">
                          <label>Tendered</label>
                          <div class="ui inverted transparent left icon input">
                            <i class="dollar icon"></i>
                            <input style="color:white; font-weight:bold" type="text" 
                                   :value="sale.tendered.toLocaleString('en-US', currencySettings)">
                          </div>
                        </div>
                        <!-- Balance -->
                        <div class="field">
                          <label>Balance</label>
                          <div class="ui inverted transparent left icon input">
                            <i class="dollar icon"></i>
                            <input style="color:white; font-weight:bold" type="text" 
                                   :value="sale.balance.toLocaleString('en-US', currencySettings)">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </transition>
    
    </div>

  </div>
</template>

<script>

  import { mapActions, mapGetters, mapMutations } from 'vuex'
  import axios     from "axios"
  import format    from "date-fns/format"
  import Modal     from "../Modal.vue"
  import EventForm from "../forms/EventSale.vue"

  const SERVER = "http://10.51.150.214:8000"

  export default {
    data: () => ({
      active_tab: 0,
    }),

    components: { Modal, EventForm },
    
    watch: {

      "sale.products": {
        handler : function(newValue) { this.$store.commit('SET_SELECTED_PRODUCTS', newValue) },
        deep    : true,
      },
      
      "sale.selected_products" : {
        handler: function() { 
          //this.sale.selected_products
          this.$store.commit('CALCULATE_TOTALS') 
        },
        deep   : true,
      },
      
      "sale.taxable"        : function() { 
        this.$store.commit('CALCULATE_TOTALS') 
        if (this.sale.payment_method != 1 && this.sale.payment_method != null)
          this.setTendered()
      },
      
      "sale.tendered"       : function() { 
        this.$store.commit('CALCULATE_TOTALS') 
      },
      
      "sale.payment_method" : function() { this.setTendered() }
    },

    async created() {
      
      this.isLoading = await true

      await this.fetchSettings()
      await this.fetchCustomers()
      await this.fetchOrganizations()
      await this.fetchGrades()
      await this.fetchProducts()
      await this.fetchPaymentMethods()
      
      if (this.$route.name == "create") {
        document.title = "Astral -  Create New Sale"
      } else if (this.$route.name == "edit") {
        document.title = `Astral -  Edit Sale #${this.$route.params.id}`
        await this.fetchSale()
      }
      
      this.isLoading = await false
    },

    methods: {
      // Set tendered to sale total automatically if sale isn't cash, set it to 0 if it is cash
      setTendered() {
        this.sale.tendered = this.sale.payment_method == 1 ? 0 : this.total
      },

      async fetchSale() {
        try {
          const response = await axios.get(`${SERVER}/api/sale/${this.$route.params.id}`)
          
          let sale = await response.data

          // Set sell to
          sale.sell_to = sale.sell_to_organization ? 1 : 0
          // Set grades
          sale.grades = sale.grades.map(grade => grade.id) // only id of grades
          // Set customer
          sale.customer = sale.customer.id
          // Subtotal
          sale.subtotal = parseFloat(sale.subtotal)
          // Tax
          sale.tax = parseFloat(sale.tax)
          // Total
          sale.total = parseFloat(sale.total)
          // Paid
          sale.paid = parseFloat(sale.paid)
          // Balance
          sale.balance = parseFloat(sale.balance)
          // Setting taxable
          sale.taxable = parseInt(sale.taxable)

          await this.$store.commit('SET_NUMBER_OF_EVENTS', sale.events.length || 0 )

          // Need dates before we reassign events array to have only id of the events
          sale.dates = await sale.events.map(event => format(new Date(event.start), "dddd, MMMM D, YYYY"))

          this.$route.query.type = sale.events.length > 0 ? sale.events[0].type.id : 1

          sale.tickets = await sale.events.map(event => event.tickets.map(ticket => ticket.id))

          sale.selected_tickets = sale.events.map(event => event.tickets.map(ticket => ({
            active      : ticket.active,
            amount      : ticket.amount,
            description : ticket.description,
            event       : ticket.event,
            id          : ticket.id,
            in_cashier  : ticket.in_cashier,
            name        : ticket.name,
            price       : ticket.price,
            public      : ticket.public,
            type        : ticket.type
          })))


          sale.events = sale.events.map(event => event.id)

          sale.products = sale.products.map(product => product.id)

          sale.payment_method = 1

          Object.assign(this.sale, sale)

        } catch (error) {
          alert(`Error in fetchSale: ${error.message}`)
        }
      },
      
      ...mapActions(['fetchCustomers', 'fetchOrganizations', 'fetchGrades', 'fetchProducts', 
        'fetchPaymentMethods', 'fetchSettings']),
      
      async submit(event) {

        event.preventDefault()
        
        let data = {
          balance        : this.balance,
          change_due     : this.change_due,
          creator_id     : this.sale.creator_id,
          customer       : this.sale.customer,
          dates          : this.sale.dates,
          events         : this.sale.events,
          grades         : this.sale.grades,
          memo           : this.sale.memo,
          memos          : this.sale.memos,
          paid           : this.sale.paid,
          payment_method : this.sale.payment_method,
          payments       : this.sale.payments,
          products       : this.sale.selected_products,
          reference      : this.sale.reference,
          sell_to        : this.sale.sell_to,
          status         : this.sale.status,
          subtotal       : this.subtotal,
          tax            : this.tax,
          taxable        : this.sale.taxable,
          tendered       : this.sale.tendered,
          tickets        : this.sale.selected_tickets,
          total          : this.total,
          
        }

        try {
          let response = {}
          
          if (this.$route.name == "create") {
            response = await axios.post(`${SERVER}/api/sales`, data)
            let sale = response.data.data
          }
            
          else if (this.$route.name == "edit") {
            response = await axios.post(`${SERVER}/api/sales/${this.$route.params.id}`, data)
          }

          const sale = response.data.data

          this.$store.commit("SET_ALERT", {
              type    : "success",
              title   : "Success!",
              icon    : "thumbs up",
              message : response.data.message,
            })
          
          this.$store.commit("TOGGLE_SHOW_ALERT", true)

          this.$router.push({ name: "show", params: { id: sale.id } })

        } catch (error) {
          alert(`Error trying to save sale: ${error.message}`)
        }
      }
    },

    computed : {

      hasReference() {
        return this.sale.payment_method == 1 ? true : this.sale.reference != null || this.sale.payment_method == null
      },
      
      sale: {
        set(value) { this.$store.commit("SET_SALE", value) },
        get()      { return this.$store.getters.sale       },
      },

      enableSubmit() {
        let hasSellTo            = this.sale.sell_to != null
        let hasSaleStatus        = this.sale.status != null
        let hasProductsOrTickets = (this.sale.tickets.length > 0 || this.sale.products.length > 0)
        return (hasSellTo && hasSaleStatus && hasProductsOrTickets && this.hasReference)
      },
      
      ...mapGetters(['customers', 'organizations', 'statuses', 'sell_to', 'taxable', 
        'grades', 'products', 'payment_methods', 'errors', 'settings', 'currencySettings',
        'numberOfEvents']),
      // Loading spinner
      isLoading: {
        set(value) { this.$store.commit("SET_IS_LOADING", value) },
        get()      { return this.$store.getters.isLoading }
      },
      
      subtotal() { 
        return this.sale.subtotal.toLocaleString("en-US", this.currencySettings) 
      },
      
      tax()      { 
        return this.sale.tax.toLocaleString("en-US", this.currencySettings)      
      },
      
      total() { 
        return this.sale.total.toLocaleString("en-US", this.currencySettings)    
      },
      
      change_due() {
        return this.sale.change_due.toLocaleString("en-US", this.currencySettings)    
      }
    },
  }
</script>

<style scoped>
  
  textarea { font: inherit }

  #sale-form-fixed {
    position: fixed;
    width: 77.3%;
    z-index: 100;
    background-color: white;
    margin-top: -3rem;
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
  }

</style>