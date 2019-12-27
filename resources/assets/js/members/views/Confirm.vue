<template>
  <div class="ui basic segment" style="text-align:center !important">
    <h1 class="ui massive center aligned header">
      <i class="address card outline icon"></i>
    </h1>
    <h1 class="ui center aligned header">
      Confirmation
    </h1>
    <p>
      Please confirm the information below:
    </p>

    <div class="ui horizontal divider header">
      <i class="address card icon"></i>
      Primary
    </div>

    <div class="ui header">
      <div class="content">{{ primary.firstname }} {{ primary.lastname }}</div>
      <div class="sub header">
        <div class="ui black label">{{ membership_type.name }}</div>
      </div>
      <div class="sub header">{{ primary.email }}</div>
      <div class="sub header">{{ primary.address }}</div>
      <div class="sub header" v-show="primary.address">
        {{ primary.address }}, {{ primary.state }} {{ primary.zip }}
      </div>
      <div v-show="primary.phone" class="sub header">{{ primary.phone }}</div>
    </div>

    <div
      class="ui horizontal divider header"
      v-show="free_secondaries.length > 0"
    >
      <i class="address card icon"></i>
      Free Secondaries
    </div>

    <div class="ui two cards">
      <div
        class="card"
        v-for="(free_secondary, i) in free_secondaries"
        :key="i"
      >
        <div class="content">
          <div class="header">
            {{ free_secondary.firstname }} {{ free_secondary.lastname }}
          </div>
          <div class="description" v-if="free_secondary.address">
            {{ free_secondary.address }}
          </div>
          <div class="description" v-if="free_secondary.address">
            {{ free_secondary.city }}, {{ free_secondary.state }}
            {{ free_secondary.zip }}
          </div>
          <div class="description" v-if="free_secondary.phone">
            {{ free_secondary.phone }}
          </div>
          <div class="description" v-show="free_secondary.use_primary_data">
            <div class="ui basic label">use primary data</div>
          </div>
        </div>
      </div>
    </div>

    <div
      class="ui horizontal divider header"
      v-show="nonfree_secondaries.length > 0"
    >
      <i class="address alternate card icon"></i>
      Non free Secondaries
    </div>

    <div class="ui two cards">
      <div
        class="card"
        v-for="(nonfree_secondary, i) in nonfree_secondaries"
        :key="i"
      >
        <div class="content">
          <div class="header">
            {{ nonfree_secondary.firstname }} {{ nonfree_secondary.lastname }}
          </div>
          <div class="description" v-if="nonfree_secondary.address">
            {{ nonfree_secondary.address }}
          </div>
          <div class="description" v-if="nonfree_secondary.address">
            {{ nonfree_secondary.city }}, {{ nonfree_secondary.state }}
            {{ nonfree_secondary.zip }}
          </div>
          <div class="description" v-if="nonfree_secondary.phone">
            {{ nonfree_secondary.phone }}
          </div>
          <div class="description" v-show="nonfree_secondary.use_primary_data">
            <div class="ui basic label">use primary data</div>
          </div>
        </div>
      </div>
    </div>

    <br />

    <div
      class="ui centered yellow labeled icon button"
      @click="$router.push('/payment')"
    >
      <i class="left chevron icon"></i>
      Back
    </div>
    <div
      class="ui blue right labeled icon button"
      @click="$router.push('/thank-you')"
    >
      <i class="thumbs up icon"></i>
      Confirm
    </div>
  </div>
</template>

<script>
  export default {
    computed: {
      primary() {
        return this.$store.state.Members.primary
      },
      free_secondaries() {
        return this.$store.state.Members.free_secondaries
      },
      nonfree_secondaries() {
        return this.$store.state.Members.nonfree_secondaries
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
      tendered() {
        return this.$store.state.Members.tendered.toLocaleString(
          'en-US',
          this.$store.getters.currencySettings
        )
      },
      change_due() {
        return this.$store.state.Members.change_due
      },
      reference() {
        return this.$store.state.Members.reference
      },
      memo() {
        return this.$store.state.Members.memo
      }
    }
  }
</script>
