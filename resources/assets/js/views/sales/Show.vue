<template>
  <div class="ui container">
    
    <sui-dimmer inverted :active="isLoading">
      <sui-loader :content="`Loading Sale #${$route.params.id}...`"></sui-loader>
    </sui-dimmer>

    <div class="ui basic segment">
      
      <modal id="refund">
        <div class="ui icon header" style="padding-bottom: 0" v-if="sale.payments && sale.payments.length > 0">
          <i class="refresh icon"></i> Refund Sale
          <div class="sub header" style="color:white">You are about to refund this sale</div>
        </div>
        <div class="content" style="padding-top: 0">
          <div class="ui inverted form">
            <div class="required field">
              <label for="memo">Memo</label>
              <textarea rows="2" v-model="refund_memo"
                        placeholder="Explain with at least 10 characters why you are refunding this sale"></textarea>
            </div>
          </div>
        </div>
        <div class="actions">
          <div class="ui red cancel inverted button" @click="$store.commit('TOGGLE_MODAL', false)">
            <i class="remove icon"></i> Cancel Refund
          </div>
          <sui-button color="yellow" inverted icon="refresh" :disabled="refund_memo == null || refund_memo.length < 10"
                      @click.prevent="submitRefund">
            Confirm Refund of $ {{ sale.total }}
          </sui-button>
        </div>
      </modal>

      <div class="ui black basic button" @click="$router.push({ name: 'index' })">
        <i class="left chevron icon"></i>
        Back
      </div>
      <div class="ui yellow button" 
            @click="$router.push({ name: 'edit', params: { id: sale.id } })">
        <i class="edit icon"></i>
        Edit Sale
      </div>

      <sui-dropdown class="black labeled icon" icon="copy" button pointing text="Documents">
        <sui-dropdown-menu>
          <sui-dropdown-item>
            <i class="file icon"></i>
            Confirmation
          </sui-dropdown-item>
          <sui-dropdown-item>
            <i class="file icon"></i>
            Invoice
          </sui-dropdown-item>
          <sui-dropdown-item>
            <i class="file icon"></i>
            Receipt
          </sui-dropdown-item>
          <sui-dropdown-item>
            <i class="ticket icon"></i>
            Tickets
          </sui-dropdown-item>
        </sui-dropdown-menu>
      </sui-dropdown>

      <div class="ui right floated red button" @click="$store.commit('TOGGLE_MODAL', true)" 
                  v-if="sale.payments && sale.payments.length > 0 && !sale.refund">
        <i class="refresh icon"></i>
        Refund
      </div>

      <h4 class="ui center aligned horizontal divider header">
        <i class="info circle icon"></i> Sale Data
      </h4>

      <transition name="fade" mode="out-in">
        
        <div id="sale-data" v-if="!isLoading">

          <div class="ui three doubling stackable cards">
            
            <div class="ui raised card">
              <div class="content">
                <div class="ui top attached black center aligned large label">
                  <i class="dollar icon"></i> Sale Information
                </div>
                <div class="header">
                  Sale #{{ sale.id }} 
                  <div class="ui red label" v-if="sale.refund">
                    <i class="reply icon"></i>
                    refund
                  </div>
                  <div :class="getSaleLabelColor(sale.status)">
                    <i :class="getSaleIcon(sale.status)"></i>
                    {{ sale.status }}
                  </div>
                </div>
                <div class="meta" v-if="sale.creator">
                  <i class="user circle icon"></i>
                  {{ sale.creator.id == 1 ? "system" : sale.creator.name }}
                </div>
                <div class="meta">
                  <i class="inbox icon"></i> {{ sale.source }}
                </div>
                <div class="description">
                  <i class="pencil icon"></i>
                  {{ format(new Date(sale.created_at), $dateFormat.long) }}
                  ({{ distanceInWords(new Date(), new Date(sale.created_at), { addSuffix: true }) }})
                </div>
                <div class="description" v-if="sale.created_at != sale.updated_at">
                  <i class="edit icon"></i>
                  {{ format(new Date(sale.updated_at), $dateFormat.long) }}
                  ({{ distanceInWords(new Date(), new Date(sale.updated_at), { addSuffix: true }) }})
                </div>
              </div>
            </div>
            
            <div class="ui raised card" v-if="sale.customer && sale.organization && sale.customer.role">
              <div class="content">
                <div class="ui top attached black center aligned large label">
                  <i class="user icon"></i> Customer Information
                </div>
                <div class="header">{{ sale.customer.name }}</div>
                <div class="meta">
                  <i class="user icon"></i> {{ sale.customer.role.name }}
                </div>
                <div class="meta" v-if="sale.customer.organization.id != 1">
                  <i class="university icon"></i>
                  {{ sale.customer.organization.name }}
                </div>
                <div class="description">
                  <i class="map marker alternate icon"></i>
                  {{ sale.customer.address }} {{ sale.customer.city }}, {{ sale.customer.state }}
                  {{ sale.customer.zip }}
                </div>
                <div class="description">
                  <i class="phone icon"></i> {{ sale.customer.phone }}
                </div>
                <div class="description">
                  <i class="at icon"></i> {{ sale.customer.email }}
                </div>
              </div>
            </div>
            
            <div class="ui raised card" v-if="sale.organization">
              <div class="content">
                <div class="ui top attached black center aligned large label">
                  <i class="university icon"></i> Organization Information</div>
                <div class="header">{{ sale.organization.name }}</div>
                <div class="meta">
                  <i class="university icon"></i> {{ sale.organization.type }}
                </div>
                <div class="description">
                  <i class="map marker alternate icon"></i> 
                  {{ sale.organization.address }}
                </div>
                <div class="description">
                  <i class="phone icon"></i> {{ sale.organization.phone }}
                </div>
                <div class="description" v-if="sale.organization.website">
                  <i class="globe icon"></i> {{ sale.organization.website }}
                </div>
              </div>
            </div>
          
          </div>
          
          <div class="ui two doubling stackable cards">

            <div class="ui raised card" v-if="sale.events && sale.events.length > 0">
              <div class="content">
                <div class="ui top attached black center aligned large label">
                  <i class="calendar check icon"></i> 
                  Events and Tickets
                </div>
                <div class="ui list">  
                  <div class="item" v-for="event in sale.events" :key="event.id">
                    <h3 :class="sale.refund ? 'ui red header' : 'ui header' " v-if="event.show && event.type">
                      <img :src="event.show.cover" :alt="event.show.name" class="ui image">
                      <div class="content">
                        <div class="sub header">
                          {{ format(new Date(event.start), $dateFormat.long) }}
                          <div class="ui circular label" :style="{backgroundColor: event.color, color: 'rgba(255, 255, 255, 0.8)'}">
                            {{ event.type.name }}
                          </div>
                        </div>
                        {{ event.show.name }}
                        <div class="sub header" v-if="event.tickets && event.tickets.length > 0">
                          <div class="ui black label" style="margin-left:0" v-for="ticket in event.tickets" :key="ticket.id">
                            <i class="ticket icon"></i>
                            {{ ticket.amount }}
                            <div class="detail">
                              {{ ticket.name }}
                            </div>
                          </div>
                        </div>
                      </div>
                    </h3>
                  </div>
                </div>
              </div>
            </div>

            <div class="ui raised card" v-if="sale.products && sale.products.length > 0">
              <div class="content">
                <div class="ui top attached black center aligned large label">
                  <i class="box icon"></i> Products
                </div>
                <div class="ui divided list">
                  <div class="item" v-for="product in sale.products" :key="product.id">
                    <h3 class="ui header" v-if="product.type">
                      <img :src="product.cover">
                      <div class="content">
                        <div class="sub header">
                          <div class="ui black label" style="margin-left:0">
                            <i class="box icon"></i>
                            {{ product.quantity }}
                          </div>
                          <div class="ui black label" style="margin-left:0">
                            <i class="dollar icon"></i>
                            {{ parseFloat(product.price).toFixed(2) }} each
                          </div>
                          <div class="ui circular blue label" style="margin-left:0">
                            {{ product.type.name }}
                          </div>
                        </div>
                        <div>{{ product.name }}</div>
                      </div>
                    </h3>
                  </div>
                </div>
              </div>
            </div>

          </div>

          <h4 class="ui horizontal divider center aligned header" v-if="sale.grades && sale.grades.length > 0">
            <i class="book icon"></i> Grades
          </h4>
          <div class="ui center aligned basic segment container" v-if="sale.grades && sale.grades.length > 0">
            <div class="ui black label" v-for="grade in sale.grades" :key="grade.id">
              {{ grade.name }}
            </div>
          </div>

          <h4 class="ui horizontal divider center aligned header">
            <i class="dollar icon"></i> Totals
          </h4>

          <div class="ui tiny five statistics">
            <div class="statistic">
              <div class="label">Subtotal</div>
              <div class="value">
                <i class="dollar sign icon"></i> 
                {{ sale.subtotal }}
              </div>
            </div>
            <div class="statistic">
              <div class="label">Tax</div>
              <div class="value" v-if="tax != undefined">
                <i class="dollar sign icon"></i> 
                {{ tax }}
              </div>
            </div>
            <div class="statistic">
              <div class="label">Total</div>
              <div class="value">
                <i class="dollar sign icon"></i> 
                {{ sale.total }}
              </div>
            </div>
            <div v-if="paid && paid < 0" class="ui red statistic">
              <div class="label">Paid</div>
              <div class="value"><i class="dollar sign icon"></i> {{ paid }}</div>
            </div>
            <div v-if="paid && paid == 0" class="ui yellow statistic">
              <div class="label">Paid</div>
              <div class="value"><i class="dollar sign icon"></i> {{ paid }}</div>
            </div>
            <div v-if="paid && paid > 0" class="ui green statistic">
              <div class="label">Paid</div>
              <div class="value"><i class="dollar sign icon"></i> {{ paid }}</div>
            </div>
            <div :class="balance && balance > 0 ? 'red statistic' : 'green statistic'">
              <div class="label">Balance</div>
              <div class="value">
                <i class="dollar sign icon"></i> {{ balance }}
              </div>
            </div>
          </div>

          <h4 class="ui horizontal divider center aligned header" v-if="sale.payments && sale.payments.length > 0">
            <i class="money icon"></i> Payments
          </h4>

          <table class="ui selectable single line table" v-if="sale.payments && sale.payments.length > 0">
            <thead>
              <tr>
                <th>#</th>
                <th>Method</th>
                <th>Paid</th>
                <th>Tendered</th>
                <th>Change</th>
                <th>Date</th>
                <th>Cashier</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="payment in sale.payments" :key="payment.id" :class="payment.paid < 0 ? 'error' : 'positive'">
                <td>
                  <div class="ui header">{{ payment.id }}</div>
                </td>
                <td>
                  <sui-icon :name="payment.icon" />
                  {{ payment.method }}
                </td>
                <td>$ {{ payment.paid }}</td>
                <td>$ {{ payment.tendered }}</td>
                <td>$ {{ (parseFloat(payment.tendered) - parseFloat(payment.paid)).toFixed(2) }}</td>
                <td>
                  {{ format(new Date(payment.created_at), $dateFormat.long) }}
                  ({{ distanceInWords(new Date(), new Date(payment.created_at), { addSuffix: true }) }})
                </td>
                <td v-if="payment.cashier">
                  <i class="user circle icon"></i>
                  {{ payment.cashier.name }}
                </td>
              </tr>
            </tbody>
          </table>

          <h4 class="ui horizontal divider center aligned header">
            <i class="comment outline icon"></i> Memos
          </h4>

          <transition mode="out-in" name="fade">
            <div class="ui icon message" v-if="sale.memos && sale.memos.length == 0">
              <i class="info circle icon"></i>
              <div class="content">
                <div class="header">No memos so far</div>
                <p>This sale doesn't have any memos.</p>
              </div>
            </div>
          </transition>
            
          <div class="ui comments">
            
              <transition-group appear mode="out-in" name="list">
                <div class="comment" v-for="memo in sale.memos" :key="memo.id">
                  <div class="avatar"><i class="user circle big icon"></i></div>
                  <div class="content" v-if="memo.author">
                    <div class="author">
                      {{ memo.author.name }}
                      <div class="ui tiny black label">{{ memo.author.role }}</div>
                      <div class="metadata">
                        <span class="date">
                          {{ format(new Date(memo.created_at), $dateFormat.long) }}
                          ({{ distanceInWords(new Date(), new Date(memo.created_at), { addSuffix: true }) }})
                        </span>
                      </div>
                    </div>
                    <div class="text">
                      {{ memo.message }}
                    </div>
                  </div>
                </div>
              </transition-group>
            
          </div>

          <div class="ui form">
              <div class="field">
                <label>Write a memo:</label>
                <textarea v-model="memo" 
                          cols="8" 
                          rows="2" 
                          placeholder="Write a memo" 
                          ></textarea>
              </div>
              <transition mode="out-in" name="fade">
                <sui-label basic color="red" pointing 
                            v-if="errors && errors.hasOwnProperty('memo')">
                  {{ errors.memo[0] }}
                </sui-label>
              </transition>
            </div>
            <br>
            <div class="field">
              <sui-button @click="submitMemo" icon="save" labelPosition="left" 
                          color="green" floated="right" :disabled="memo == null || memo.length < 5">
                Save
              </sui-button>
            </div>
            
        </div>

      </transition>
    
      <br><br>
    </div>
  </div>
</template>

<script>
  import { mapGetters } from "vuex"
  import axios          from "axios"
  import Modal from '../../components/Modal.vue'
  
  export default {
    
    data: () => ({
      sale        : {},
      refund_memo : null,
      memo        : null,
    }),
    
    components: { Modal },
    
    async created() {

      this.isLoading = await true
      await this.fetchSale()
      document.title = `Astral - Sale #${ this.sale.id }`
      this.isLoading = await false
    },
    
    computed: {
    
      ...mapGetters(['errors', 'currencySettings']),

      tax() {
        if (this.sale.tax != undefined)
          return this.sale.tax.toLocaleString("en-US", this.currencySettings)
        else return 0
      },
      paid() {
        if (this.sale.payments != undefined)
          return this.sale.payments.reduce((total, current) => total + parseFloat(current.paid), 0)
                     .toLocaleString("en-US", this.currencySettings)
        else return 0
      },
      balance() {
        return (parseFloat(this.sale.total) - parseFloat(this.paid)).toLocaleString("en-US", this.currencySettings)
      },
    
    // Loading spinner
      isLoading: {
        set(value) { this.$store.commit("SET_IS_LOADING", value) },
        get()      { return this.$store.getters.isLoading }
      },
    
    },
    
    methods : {
      
      async fetchSale() {
        try {
          const response = await axios.get(`/api/sale/${this.$route.params.id}`)
          this.sale = await response.data
        } catch (error) {
          alert(`Error in fetchSale: ${error.message}`)
        }
      },
    
      async submitMemo() {
        
        const data = {
          sale_id    : this.sale.id,
          memo       : this.memo,
          creator_id : 3,
        }

        try {
          
          const response = await axios.post(`/api/memos`, data)
          
          this.memo = null
          
          await this.fetchSale()
          
          this.$store.commit("SET_ALERT", {
            type    : "success",
            title   : "Success!",
            icon    : "thumbs up",
            message : response.data.message,
          })

          this.$store.commit("TOGGLE_SHOW_ALERT", true)

        } catch (error) {
          alert(`Error saving memo: ${error.message}`)
        }

      },

      async submitRefund(event) {
        
        event.preventDefault()

        this.$store.commit('TOGGLE_MODAL', false)

        try {
          const data = {
            creator_id : 3,
            memo       : this.refund_memo,
          }
          
          const response = await axios.post(`/api/sales/${this.$route.params.id}/refund`, data)

          await this.fetchSale()
            
            this.$store.commit("SET_ALERT", {
              type    : "success",
              title   : "Success!",
              icon    : "thumbs up",
              message : response.data.message,
            })

            this.$store.commit("TOGGLE_SHOW_ALERT", true)

        } catch (error) {
          alert(`Error submitting sale: ${ error.message }`)
        }
      }
    }
  }
</script>

<style scoped>
  textarea { font: inherit }
</style>

