<template>
  <div class="ui basic segment" style="text-align:center !important">
    <h1 class="ui massive center aligned header">
      <i class="address card outline icon"></i>
    </h1>
    <h1 class="ui center aligned header">
      Secondaries
    </h1>
    <p>
      How many free secondaries? (Maximum for
      <strong>{{ membership_type.name }}</strong> is
      <strong>{{ membership_type.max_secondaries }}</strong
      >)
    </p>
    <h1>{{ free_secondaries.length }}</h1>
    <div class="ui basic icon buttons">
      <div @click="add" class="ui green button">
        <i class="plus icon"></i>
      </div>
      <div @click="subtract" class="ui yellow button">
        <i class="minus icon"></i>
      </div>
    </div>
    <br /><br />

    <div
      class="ui form"
      v-for="(free_secondary, i) in free_secondaries"
      :key="i"
    >
      <div class="ui horizontal divider header">
        <i class="address card outline icon"></i>
        Secondary #{{ i + 1 }}
      </div>
      <div class="two fields">
        <div class="field">
          <input
            type="text"
            v-model.lazy="free_secondary.firstname"
            :placeholder="`Enter the first name of secondary ${i + 1}`"
          />
        </div>
        <div class="field">
          <input
            type="text"
            v-model.lazy="free_secondary.lastname"
            :placeholder="`Enter the last name of secondary ${i + 1}`"
          />
        </div>
      </div>
      <div class="field">
        <input
          v-model.lazy="free_secondary.email"
          type="text"
          @blur="checkMember(free_secondary, i, 'free')"
          :placeholder="`Enter the email of secondary ${i + 1}`"
        />
      </div>
      <div class="field">
        <div class="ui checkbox">
          <input type="checkbox" v-model="free_secondary.use_primary_data" />
          <label
            >Use {{ primary.firstname }} {{ primary.lastname }}'s address for
            this secondary</label
          >
        </div>
      </div>
      <div v-show="!free_secondary.use_primary_data">
        <div class="two fields">
          <div class="field">
            <input
              type="text"
              v-model="free_secondary.address"
              placeholder="Address"
            />
          </div>
          <div class="field">
            <input
              type="text"
              v-model="free_secondary.city"
              placeholder="City"
            />
          </div>
        </div>
        <div class="two fields">
          <div class="field">
            <select v-model="free_secondary.state">
              <option v-for="(state, si) in states" :key="si" :value="state">
                {{ state }}
              </option>
            </select>
          </div>
          <div class="field">
            <input type="text" v-model="free_secondary.zip" placeholder="ZIP" />
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
            v-model="free_secondary.phone"
            placeholder="Phone"
          />
        </div>
        <div class="field">
          <div class="ui checkbox">
            <input type="checkbox" v-model="free_secondary.newsletter" />
            <label>Receive {{ settings.organization }} newsletters</label>
          </div>
        </div>
      </div>
      <br />
    </div>

    <div
      v-show="
        free_secondaries.length >= parseInt(membership_type.max_secondaries)
      "
      class="ui divider"
    ></div>

    <p
      v-show="
        free_secondaries.length >= parseInt(membership_type.max_secondaries)
      "
    >
      How many non-free secondaries? (<strong
        >$ {{ membership_type.secondary_price }} each</strong
      >)
    </p>
    <h1
      v-show="
        free_secondaries.length >= parseInt(membership_type.max_secondaries)
      "
    >
      {{ nonfree_secondaries.length }}
    </h1>
    <div
      class="ui basic icon buttons"
      v-show="
        free_secondaries.length >= parseInt(membership_type.max_secondaries)
      "
    >
      <div @click="addNonfree" class="ui green button">
        <i class="plus icon"></i>
      </div>
      <div @click="subtractNonfree" class="ui yellow button">
        <i class="minus icon"></i>
      </div>
    </div>

    <br /><br />

    <div
      class="ui form"
      v-for="(nonfree_secondary, j) in nonfree_secondaries"
      :key="j + 1000"
    >
      <div class="ui horizontal divider header">
        <i class="address card outline icon"></i>
        Non free Secondary #{{ j + 1 }}
      </div>
      <div class="two fields">
        <div class="field">
          <input
            type="text"
            v-model.lazy="nonfree_secondary.firstname"
            :placeholder="`Enter the first name of non free secondary ${j + 1}`"
          />
        </div>
        <div class="field">
          <input
            type="text"
            v-model.lazy="nonfree_secondary.lastname"
            :placeholder="`Enter the last name of non free secondary ${j + 1}`"
          />
        </div>
      </div>
      <div class="field">
        <input
          v-model.lazy="nonfree_secondary.email"
          type="text"
          :placeholder="`Enter the email of non free secondary ${j + 1}`"
        />
      </div>
      <div class="field">
        <div class="ui checkbox">
          <input type="checkbox" v-model="nonfree_secondary.use_primary_data" />
          <label
            >Use {{ primary.firstname }} {{ primary.lastname }}'s address for
            this secondary</label
          >
        </div>
      </div>
      <div v-show="!nonfree_secondary.use_primary_data">
        <div class="two fields">
          <div class="field">
            <input
              type="text"
              v-model="nonfree_secondary.address"
              placeholder="Address"
            />
          </div>
          <div class="field">
            <input
              type="text"
              v-model="nonfree_secondary.city"
              placeholder="City"
            />
          </div>
        </div>
        <div class="two fields">
          <div class="field">
            <select v-model="nonfree_secondary.state">
              <option v-for="(state, si) in states" :key="si" :value="state">
                {{ state }}
              </option>
            </select>
          </div>
          <div class="field">
            <input
              type="text"
              v-model="nonfree_secondary.zip"
              placeholder="ZIP"
            />
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
            v-model="nonfree_secondary.phone"
            placeholder="Phone"
          />
        </div>
        <div class="field">
          <div class="ui checkbox">
            <input type="checkbox" v-model="nonfree_secondary.newsletter" />
            <label>Receive {{ settings.organization }} newsletters</label>
          </div>
        </div>
      </div>
      <br />
    </div>

    <br /><br />
  </div>
</template>

<script>
  import { mask } from 'vue-the-mask'

  const secondary_data_fields = {
    firstname: '',
    lastname: '',
    email: '',
    address: '',
    city: '',
    country: 'United States',
    state: 'Texas',
    zip: '',
    phone: '',
    newsletter: true,
    use_primary_data: true
  }

  export default {
    data: () => ({
      free_secondaries_amount: 0,
      nonfree_secondaries_amount: 0,
      free_secondaries: [],
      nonfree_secondaries: [],
      states: []
    }),
    directives: { mask },
    async mounted() {
      await this.fetchStates()
      await this.$store.dispatch('fetchSettings')
    },
    methods: {
      add() {
        if (
          this.free_secondaries.length <
          parseInt(this.membership_type.max_secondaries)
        )
          this.free_secondaries.push({
            firstname: '',
            lastname: '',
            email: '',
            address: '',
            city: '',
            country: 'United States',
            state: 'Texas',
            zip: '',
            phone: '',
            newsletter: true,
            use_primary_data: true
          })
      },
      subtract() {
        if (this.free_secondaries.length > 0) this.free_secondaries.pop()
      },
      addNonfree() {
        this.nonfree_secondaries.push({
          firstname: '',
          lastname: '',
          email: '',
          address: '',
          city: '',
          country: 'United States',
          state: 'Texas',
          zip: '',
          phone: '',
          newsletter: true,
          use_primary_data: true
        })
      },
      subtractNonfree() {
        if (this.nonfree_secondaries.length > 0) this.nonfree_secondaries.pop()
      },
      async fetchStates() {
        try {
          const response = await fetch('/api/states')
          const states = await response.json()
          Object.assign(this, { states })
        } catch (error) {
          alert(`Error in fetchStates: ${error.message}`)
        }
      },
      async checkMember(user, i, type) {
        try {
          const response = await fetch('/api/members/check-primary', {
            method: 'post',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(user)
          })
          const data = await response.json()

          if (type == 'free') this.$set(this.free_secondaries, i, ...data)
          else this.$set(this.nonfree_secondaries, i, ...data)
        } catch (error) {
          alert(`Error in checkPriamry: ${error.message}`)
        }
      }
    },
    computed: {
      membership_type() {
        return this.$store.state.Members.membership_type
      },
      primary() {
        return this.$store.state.Members.primary
      },
      settings() {
        return this.$store.getters.settings
      }
    }
  }
</script>
