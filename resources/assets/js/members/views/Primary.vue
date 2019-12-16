<template>
  <div class="ui basic segment" style="text-align:center !important">
    <h1 class="ui massive center aligned header">
      <i class="address card outline icon"></i>
    </h1>
    <h1 class="ui center aligned header">
      Primary
    </h1>
    <p>
      Please enter the customer's First Name, Last Name and Email to see if they
      already are in our database. If they are, a membership will be created. If
      they aren't, a user account will be created, followed by a membership.
    </p>

    <div class="ui form">
      <div class="two fields">
        <div class="field">
          <input
            type="text"
            v-model.lazy="firstname"
            placeholder="First Name"
          />
        </div>
        <div class="field">
          <input type="text" v-model.lazy="lastname" placeholder="Last Name" />
        </div>
      </div>
      <div class="field">
        <div class="ui action input">
          <input
            type="text"
            v-model.lazy="email"
            placeholder="Email"
            @blur="checkPrimary"
            @keyup.enter="checkPrimary"
          />
          <div class="ui black button" @click="checkPrimary">Check</div>
        </div>
      </div>
    </div>

    <sui-message
      :icon="message_icon"
      :color="message_color"
      :header="check_primary.message"
      v-if="check_primary"
    >
      <p v-html="message_content"></p>
    </sui-message>

    <sui-loader :active="checking_primary" inline
      >Looking for {{ firstname }} {{ lastname }}...</sui-loader
    >

    <div
      class="ui form"
      v-show="check_primary && check_primary.type == 'warning'"
    >
      <div class="two fields">
        <div class="field">
          <input type="text" v-model="address" placeholder="Address" />
        </div>
        <div class="field">
          <input type="text" v-model="city" placeholder="City" />
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <select v-model="state">
            <option v-for="(state, i) in states" :key="i" :value="state">
              {{ state }}
            </option>
          </select>
        </div>
        <div class="field">
          <input type="text" v-model="zip" placeholder="ZIP" />
        </div>
      </div>
      <div class="field">
        <input
          type="text"
          value="United States"
          disabled
          placeholder="Address"
        />
      </div>
      <div class="field">
        <input
          type="text"
          v-mask="['(###) ###-####']"
          v-model="phone"
          placeholder="Phone"
        />
      </div>
      <div class="field">
        <div class="ui checkbox">
          <input type="checkbox" v-model="newsletter" />
          <label>Receive {{ settings.organization }} newsletters</label>
        </div>
      </div>
    </div>
    <br />
    <div
      v-show="allow_next"
      class="ui centered yellow labeled icon button"
      @click="$router.push('/')"
    >
      <i class="left chevron icon"></i>
      Back
    </div>
    <div
      v-show="allow_next"
      class="ui green right labeled icon button"
      @click="$router.push('/details')"
    >
      <i class="right chevron icon"></i>
      Next
    </div>
  </div>
</template>

<script>
  import { mask } from 'vue-the-mask'
  export default {
    data: () => ({
      loading: true,
      checking_primary: false,
      states: []
    }),
    directives: { mask },
    async mounted() {
      this.loading = true
      await this.fetchStates()
      await this.$store.dispatch('fetchSettings')
      this.loading = false
    },
    methods: {
      async checkPrimary() {
        this.checking_primary = true
        await this.$store.dispatch('Members/checkPrimary')
        this.checking_primary = false
      },
      async fetchStates() {
        try {
          const response = await fetch('/api/states')
          const states = await response.json()
          Object.assign(this, { states })
        } catch (error) {
          alert(`Error in fetchStates: ${error.message}`)
        }
      }
    },
    computed: {
      firstname: {
        get() {
          return this.$store.state.Members.primary.firstname
        },
        set(value) {
          this.$store.commit('Members/SET_FIRSTNAME', value)
        }
      },
      lastname: {
        get() {
          return this.$store.state.Members.primary.lastname
        },
        set(value) {
          this.$store.commit('Members/SET_LASTNAME', value)
        }
      },
      email: {
        get() {
          return this.$store.state.Members.primary.email
        },
        set(value) {
          this.$store.commit('Members/SET_EMAIL', value)
        }
      },
      address: {
        get() {
          return this.$store.state.Members.primary.address
        },
        set(value) {
          this.$store.commit('Members/SET_ADDRESS', value)
        }
      },
      city: {
        get() {
          return this.$store.state.Members.primary.city
        },
        set(value) {
          this.$store.commit('Members/SET_CITY', value)
        }
      },
      state: {
        get() {
          return this.$store.state.Members.primary.state
        },
        set(value) {
          this.$store.commit('Members/SET_STATE', value)
        }
      },
      zip: {
        get() {
          return this.$store.state.Members.primary.zip
        },
        set(value) {
          this.$store.commit('Members/SET_ZIP', value)
        }
      },
      phone: {
        get() {
          return this.$store.state.Members.primary.phone
        },
        set(value) {
          this.$store.commit('Members/SET_PHONE', value)
        }
      },
      newsletter: {
        get() {
          return this.$store.state.Members.primary.newsletter
        },
        set(value) {
          this.$store.commit('Members/SET_NEWSLETTER', value)
        }
      },
      check_primary() {
        return this.$store.state.Members.check_primary
      },
      message_icon() {
        switch (this.check_primary.type) {
          case 'success':
            return 'thumbs up'
          case 'member':
            return 'address card'
          case 'warning':
            return 'warning circle'
          default:
            return null
        }
      },
      message_color() {
        switch (this.check_primary.type) {
          case 'success':
            return 'green'
          case 'member':
            return 'blue'
          case 'warning':
            return 'yellow'
          default:
            return null
        }
      },
      message_content() {
        if (this.check_primary.type == 'member')
          return `Membership #${this.check_primary.membership.number}
          ${
            this.check_primary.membership.expired
              ? 'has expired'
              : 'has not expired'
          }.
          <a href="/admin/members/${
            this.check_primary.membership.id
          }">Click here</a> to view membership details.`
        else if (this.check_primary.type == 'warning')
          return `Please fill out the form below with ${this.firstname} ${this.lastname}'s data.`
        else
          return `All you have to do now is add secondaries if customer wants them.`
      },
      settings() {
        return this.$store.getters.settings
      },
      allow_next() {
        if (!this.check_primary) return false
        else {
          // If user is in database and is not a member
          if (this.check_primary.type == 'success') return true
          // If user is in database and is a member
          else if (this.check_primary.type == 'member') return false
          // If user is not in datababse
          else if (this.check_primary.type == 'warning') {
            if (
              this.firstname.length > 2 &&
              this.lastname.length > 2 &&
              this.email.length > 2 &&
              this.email.includes('@') &&
              this.state &&
              this.zip.length == 5 &&
              this.phone.length == 14
            )
              return true
            else return false
          } else return false
        }
      }
    }
  }
</script>
