<template>
  <div
    class="ui basic segment"
    style="text-align:center !important"
    v-if="!loading"
  >
    <h1 class="ui massive center aligned header">
      <i class="address card outline icon"></i>
    </h1>
    <h1 class="ui center aligned header">
      Payment
    </h1>
    <p>
      How is
      <strong>{{ primary.firstname }} {{ primary.lastname }}</strong> paying for
      their <strong>{{ membership_type.name }}</strong
      >?
    </p>

    <br />

    <div class="ui five tiny statistics">
      <div class="statistic">
        <div class="label">Subtotal</div>
        <div class="value">$ {{ subtotal | currency }}</div>
      </div>
      <div class="statistic">
        <div class="label">Tax ({{ tax_rate * 100 }}%)</div>
        <div class="value">$ {{ tax | currency }}</div>
      </div>
      <div class="statistic">
        <div class="label">Total</div>
        <div class="value">$ {{ total | currency }}</div>
      </div>
      <div class="statistic">
        <div class="label">Tendered</div>
        <div class="value">$ {{ tendered | currency }}</div>
      </div>
      <sui-statistic ingroup :color="balance >= 0 ? 'green' : 'red'">
        <sui-statistic-label>
          Balance
        </sui-statistic-label>
        <sui-statistic-value>
          ${{ balance | currency }}
        </sui-statistic-value>
      </sui-statistic>
    </div>

    <div class="ui divider"></div>

    <br />

    <div class="ui form">
      <div class="four fields">
        <sui-form-field>
          <label>Tendered</label>
          <div class="ui labeled input">
            <div class="ui basic label">$</div>
            <input v-model="tendered" type="text" @input="calculateTotals" />
          </div>
        </sui-form-field>
        <sui-form-field>
          <label>Change Due</label>
          <div class="ui labeled input">
            <div class="ui basic label">$</div>
            <input readonly :value="change_due | currency" type="text" />
          </div>
        </sui-form-field>
        <sui-form-field v-if="payment_methods">
          <label>Payment Method</label>
          <select v-model="payment_method_id" @change="handleCashSelection">
            <option
              v-for="payment_method in payment_methods"
              :value="payment_method.value"
              :key="payment_method.key"
              >{{ payment_method.text }}</option
            >
          </select>
        </sui-form-field>
        <sui-form-field>
          <label>Reference</label>
          <sui-input placeholder="Check or CC" v-model="reference" />
        </sui-form-field>
      </div>
      <div class="field">
        <label>Memo</label>
        <textarea
          v-model="memo"
          placeholder="Anything we should know about this sale?"
          rows="2"
        ></textarea>
      </div>
    </div>

    <br />

    <div
      v-show="valid"
      class="ui centered yellow labeled icon button"
      @click="$router.push('/secondaries')"
    >
      <i class="left chevron icon"></i>
      Back
    </div>
    <div
      v-show="valid"
      class="ui green right labeled icon button"
      @click="$router.push('/confirm')"
    >
      <i class="right chevron icon"></i>
      Next
    </div>
  </div>
</template>

<script>
  export default {
    data: () => ({
      loading: true
    }),
    async created() {
      this.loading = true
      await this.$store.dispatch('fetchPaymentMethods')
      await this.$store.dispatch('fetchSettings')
      this.calculateTotals()
      this.loading = false
    },
    methods: {
      handleCashSelection() {
        if (this.payment_method_id !== 1) this.tendered = this.total
      },
      calculateTotals() { this.$store.dispatch('Members/calculateTotals') }
    },
    computed: {
      payment_methods() {
        return this.$store.state.Sale.payment_methods
      },
      tax_rate() {
        return this.$store.state.Sale.settings.tax
      },
      payment_method_id: {
        set(value) {
          this.$store.commit('Members/SET_PAYMENT_METHOD_ID', value)
        },
        get() {
          return this.$store.state.Members.payment_method_id
        }
      },
      primary() {
        return this.$store.state.Members.primary
      },
      secondaries() {
        return this.$store.state.Members.secondaries
      },
      membership_type() {
        return this.$store.state.Members.membership_type
      },
      subtotal() {
        return this.$store.state.Members.subtotal
      },
      tax() {
        return this.$store.state.Members.tax
      },
      balance() {
        return this.$store.state.Members.balance
      },
      total() {
        return this.$store.state.Members.total
      },
      tendered: {
        set(value) {
          this.$store.commit('Members/SET_TENDERED', parseFloat(value))
        },
        get() {
          return this.$store.state.Members.tendered.toLocaleString(
            'en-US',
            this.$store.getters.currencySettings
          )
        }
      },
      change_due() {
        return this.$store.state.Members.change_due
      },
      reference: {
        set(value) {
          this.$store.commit('Members/SET_REFERENCE', value)
        },
        get() {
          return this.$store.state.Members.reference
        }
      },
      memo: {
        set(value) {
          this.$store.commit('Members/SET_MEMO')
        },
        get() {
          return this.$store.state.Members.memo
        }
      },
      valid() {
        const hasReference = this.payment_method_id === 1 ? true : this.reference.length >= 4
        return (this.tendered > 0) && (this.tendered >= this.balance) && (this.payment_method_id != null) && hasReference
      }
    }
  }
</script>
