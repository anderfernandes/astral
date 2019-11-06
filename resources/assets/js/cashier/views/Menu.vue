<template>
  <div class="ui container" style="margin-top:3.5rem !important">
    <div class="ui grid">
      <div class="column" style="text-align:right">
        <i
          class="close icon"
          @click="$router.push('/')"
          style="cursor: pointer"
        ></i>
      </div>
    </div>
    <div class="ui four column grid">
      <div class="row">
        <div class="column">
          <router-link class="ui black fluid basic massive button" to="/">
            <i class="inbox icon"></i>
            Cashier
          </router-link>
        </div>
        <div class="column">
          <sui-dropdown button class="black massive basic fluid">
            <i class="file text icon"></i> Reports
            <sui-dropdown-menu>
              <sui-dropdown-item
                @click="handleLinkClick(`/cashier/reports/closeout`)"
                >Closeout</sui-dropdown-item
              >
              <sui-dropdown-item
                @click="handleLinkClick(`/cashier/reports/transaction-detail`)"
                >Transaction Detail</sui-dropdown-item
              >
            </sui-dropdown-menu>
          </sui-dropdown>
        </div>
        <div class="column">
          <div
            class="ui black fluid basic massive button"
            @click="handleLinkClick(`/admin/sales`)"
          >
            <i class="dollar sign icon"></i>
            Sales
          </div>
        </div>
        <div class="column">
          <div
            class="ui black fluid basic massive button"
            @click="handleLinkClick(`/admin/users`)"
          >
            <i class="users icon"></i>
            Users
          </div>
        </div>
      </div>
      <div class="row">
        <div class="column"></div>
        <div class="column">
          <div
            class="ui black fluid basic massive button"
            @click="handleLinkClick(`/admin/members`)"
          >
            <i class="address card icon"></i>
            Members
          </div>
        </div>
        <div class="column">
          <div
            class="ui black fluid basic massive button"
            @click="handleLinkClick(`https://astral.anderfernandes.com/docs`)"
          >
            <i class="help circle icon"></i>
            Help
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    handleLinkClick(url) {
      window.open(url, '_blank')
    }
  }
}
</script>
