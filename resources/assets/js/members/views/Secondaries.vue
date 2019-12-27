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
    <div class="ui icon buttons">
      <div @click="add" class="ui basic green button">
        <i class="plus icon"></i>
      </div>
      <div @click="subtract" class="ui basic yellow button">
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

      <div
        class="ui yellow icon message"
        v-show="free_secondary.exists && !free_secondary.is_member"
      >
        <i class="info circle icon"></i>
        <div class="content">
          <div class="header">
            {{ free_secondary.firstname }} {{ free_secondary.lastname }} already
            exists.
          </div>
          <p>
            Use this opportunity to double check/update this user's information.
          </p>
        </div>
      </div>

      <div class="ui red icon message" v-show="free_secondary.is_member">
        <i class="info circle icon"></i>
        <div class="content">
          <div class="header">
            {{ free_secondary.firstname }} {{ free_secondary.lastname }} can't
            be added as secondary!
          </div>
          <p>
            {{ free_secondary.firstname }} {{ free_secondary.lastname }} is
            already a member and cannot be added as a secondary.
          </p>
        </div>
      </div>

      <div class="two fields">
        <sui-form-field :error="free_secondary.is_member">
          <sui-input
            v-model.lazy="free_secondary.firstname"
            :error="free_secondary.is_member"
            :placeholder="`Enter the first name of secondary ${i + 1}`"
          />
        </sui-form-field>
        <sui-form-field :error="free_secondary.is_member">
          <sui-input
            v-model.lazy="free_secondary.lastname"
            :error="free_secondary.is_member"
            :placeholder="`Enter the first name of secondary ${i + 1}`"
          />
        </sui-form-field>
      </div>
      <sui-form-field :error="free_secondary.is_member">
        <sui-input
          v-model.lazy="free_secondary.email"
          @blur="checkMember(free_secondary, i, 'free')"
          :error="free_secondary.is_member"
          :placeholder="`Enter the email of secondary ${i + 1}`"
        />
      </sui-form-field>
      <div class="field">
        <sui-checkbox
          :label="
            `Use ${primary.firstname} ${primary.lastname}'s address for
            this secondary`
          "
          v-model="free_secondary.use_primary_data"
          :disabled="free_secondary.is_member"
        />
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
      class="ui segment"
      v-show="
        free_secondaries.length >= parseInt(membership_type.max_secondaries) &&
          are_primaries_valid
      "
    >
      <div class="ui checkbox">
        <input type="checkbox" v-model="need_nonfree" />
        <label
          >{{ primary.firstname }} {{ primary.lastname }} needs additional non
          free secondaries</label
        >
      </div>
    </div>

    <p v-show="need_nonfree">
      How many non-free secondaries? (<strong
        >$ {{ membership_type.secondary_price }} each</strong
      >)
    </p>

    <h1 v-show="need_nonfree">
      {{ nonfree_secondaries.length }}
    </h1>
    <div class="ui icon buttons" v-show="need_nonfree">
      <div @click="addNonfree" class="ui basic green button">
        <i class="plus icon"></i>
      </div>
      <div @click="subtractNonfree" class="ui basic yellow button">
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

      <div
        class="ui yellow icon message"
        v-show="nonfree_secondary.exists && !nonfree_secondary.is_member"
      >
        <i class="info circle icon"></i>
        <div class="content">
          <div class="header">
            {{ nonfree_secondary.firstname }}
            {{ nonfree_secondary.lastname }} already exists.
          </div>
          <p>
            Use this opportunity to double check/update this user's information.
          </p>
        </div>
      </div>

      <div class="ui red icon message" v-show="nonfree_secondary.is_member">
        <i class="info circle icon"></i>
        <div class="content">
          <div class="header">
            {{ nonfree_secondary.firstname }}
            {{ nonfree_secondary.lastname }} can't be added as secondary!
          </div>
          <p>
            {{ nonfree_secondary.firstname }}
            {{ nonfree_secondary.lastname }} is already a member and cannot be
            added as a secondary.
          </p>
        </div>
      </div>

      <div class="two fields">
        <sui-form-field :error="nonfree_secondary.is_member">
          <sui-input
            v-model.lazy="nonfree_secondary.firstname"
            :error="nonfree_secondary.is_member"
            :placeholder="`Enter the first name of secondary ${j + 1}`"
          />
        </sui-form-field>
        <sui-form-field :error="nonfree_secondary.is_member">
          <sui-input
            v-model.lazy="nonfree_secondary.lastname"
            :error="nonfree_secondary.is_member"
            :placeholder="`Enter the first name of secondary ${j + 1}`"
          />
        </sui-form-field>
      </div>
      <sui-form-field :error="nonfree_secondary.is_member">
        <sui-input
          v-model.lazy="nonfree_secondary.email"
          @blur="checkMember(nonfree_secondary, j, 'nonfree')"
          :error="nonfree_secondary.is_member"
          :placeholder="`Enter the email of secondary ${j + 1}`"
        />
      </sui-form-field>
      <div class="field">
        <sui-checkbox
          :label="
            `Use ${primary.firstname} ${primary.lastname}'s address for
            this secondary`
          "
          v-model="nonfree_secondary.use_primary_data"
          :disabled="nonfree_secondary.is_member"
        />
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
    </div>
    <div class="ui divider"></div>
    <div
      v-show="are_primaries_valid && are_secondaries_valid"
      class="ui centered yellow labeled icon button"
      @click="$router.push('/details')"
    >
      <i class="left chevron icon"></i>
      Back
    </div>
    <div
      v-show="are_primaries_valid && are_secondaries_valid"
      class="ui green right labeled icon button"
      @click="$router.push('/payment')"
    >
      <i class="right chevron icon"></i>
      Next
    </div>
  </div>
</template>

<script>
  import { mask } from 'vue-the-mask'

  const validate = secondary =>
    Object.entries(secondary).every(([key, value]) => !(value === ''))

  export default {
    data: () => ({
      free_secondaries: [],
      nonfree_secondaries: [],
      need_nonfree: false,
      states: []
    }),
    directives: { mask },
    async mounted() {
      Object.assign(this, {
        free_secondaries: this.$store.state.Members.free_secondaries
      })
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
        if (this.free_secondaries.length > 0) {
          this.free_secondaries.pop()
          this.nonfree_secondaries = []
          this.need_nonfree = false
        }
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
        //i = type == 'free' ? i : i - 1000
        try {
          const response = await fetch('/api/members/check-primary', {
            method: 'post',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(user)
          })
          const data = await response.json()

          const secondary =
            type == 'free'
              ? this.free_secondaries[i]
              : this.nonfree_secondaries[i]

          this.$set(secondary, 'exists', data.exists)
          this.$set(
            secondary,
            'is_member',
            data.type == 'member' ? true : false
          )
          if (data.exists && data.type != 'member') {
            this.$set(secondary, 'use_primary_data', false)
            Object.assign(secondary, {
              firstname: data.user.firstname,
              lastname: data.user.lastname,
              email: data.user.email,
              address: data.user.address,
              city: data.user.city,
              state: data.user.state,
              zip: data.user.zip,
              country: data.user.country,
              phone: data.user.phone
            })
          }
        } catch (error) {
          alert(`Error in checkPrimary: ${error.message}`)
        }
      }
    },
    watch: {
      need_nonfree(new_value) {
        if (new_value == false) this.nonfree_secondaries = []
      },
      free_secondaries(new_value) {
        this.$store.commit(
          'Members/SET_FREE_SECONDARIES',
          this.free_secondaries
        )
      },
      nonfree_secondaries(new_value) {
        this.$store.commit(
          'Members/SET_NONFREE_SECONDARIES',
          this.nonfree_secondaries
        )
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
      },
      are_primaries_valid() {
        return this.free_secondaries.length > 0
          ? this.free_secondaries.every(validate)
          : true
      },
      are_secondaries_valid() {
        return this.nonfree_secondaries.length > 0
          ? this.nonfree_secondaries.every(validate)
          : true
      }
    }
  }
</script>
