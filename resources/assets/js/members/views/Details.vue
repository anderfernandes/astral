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
      Details
    </h1>
    <p>
      Please select the desired membership package.
    </p>

    <div class="ui link cards" v-if="types">
      <div class="card" v-for="type in types" :key="type.id">
        <div
          class="ui right corner green label"
          v-if="membership_type.id == type.id"
        >
          <i class="check icon"></i>
        </div>
        <div class="content" @click="setMembershipType(type)">
          <div class="header">
            {{ type.name }}
          </div>
          <div class="description">
            <div class="ui green label">$ {{ type.price }}</div>
            <div class="ui black label">
              <i class="calendar alternate icon"></i>
              {{ type.duration }} days
            </div>
          </div>
          <div class="description">{{ type.description }}</div>
        </div>
        <div class="extra content">
          <div class="ui basic black label">
            <i class="address card icon"></i>
            {{ type.max_secondaries }}
            free
            {{
              parseInt(type.max_secondaries) == 1 ? 'secondary' : 'secondaries'
            }}
            ($ {{ type.secondary_price }} / extra)
          </div>
        </div>
      </div>
    </div>

    <br />

    <div class="ui form" v-show="membership_type.id && !loading">
      <div class="ui two fields">
        <div class="field">
          <div class="ui labeled icon input">
            <div class="ui basic label">Start Date</div>
            <flatpickr v-model.lazy="start" :config="flatpickr_config" />
            <i class="calendar alternate icon"></i>
          </div>
        </div>
        <div class="field">
          <div class="ui labeled icon input">
            <div class="ui basic label">End Date</div>
            <flatpickr v-model.lazy="end" :config="flatpickr_config" />
            <i class="calendar alternate icon"></i>
          </div>
        </div>
      </div>
    </div>
    <div
      v-show="allow_next"
      class="ui centered yellow labeled icon button"
      @click="$router.push('/primary')"
    >
      <i class="left chevron icon"></i>
      Back
    </div>
    <div
      v-show="allow_next"
      class="ui green right labeled icon button"
      @click="$router.push('/secondaries')"
    >
      <i class="right chevron icon"></i>
      Next
    </div>
  </div>
</template>

<script>
  import flatpickr from 'vue-flatpickr-component'
  import 'flatpickr/dist/flatpickr.css'
  import addDays from 'date-fns/add_days'

  export default {
    data: () => ({
      loading: true,
      types: [],
      flatpickr_config: {
        dateFormat: 'l, F j, Y',
        minDate: 'today'
      }
    }),
    components: { flatpickr },
    async created() {
      this.loading = true
      await this.fetchMembershipTypes()
      this.loading = false
    },
    methods: {
      async fetchMembershipTypes() {
        try {
          const response = await fetch('/api/membership-types')
          const types = await response.json()
          Object.assign(this, { types })
        } catch (error) {
          alert(`Error in fetchMembershipTypes: ${error.message}`)
        }
      },
      setMembershipType(type) {
        this.$store.commit('Members/SET_MEMBERSHIP_TYPE', type)
      }
    },
    watch: {
      membership_type(new_value) {
        this.$store.commit('Members/SET_FREE_SECONDARIES', [])
        this.$store.commit('Members/SET_NONFREE_SECONDARIES', [])
      }
    },
    computed: {
      membership_type() {
        return this.$store.state.Members.membership_type
      },
      start: {
        get() {
          return this.$store.state.Members.start
        },
        set(value) {
          this.$store.commit('Members/SET_START', value)
          this.$store.commit(
            'Members/SET_END',
            addDays(value, parseInt(this.membership_type.duration))
          )
        }
      },
      end: {
        get() {
          return this.$store.state.Members.end
        },
        set(value) {
          this.$store.commit('Members/SET_END', value)
        }
      },
      allow_next() {
        if (this.membership_type != null && this.start && this.end) return true
        else return false
      }
    }
  }
</script>
