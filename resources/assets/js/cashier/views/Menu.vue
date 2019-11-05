<template>
  <div class="ui container" style="margin-top:3.5rem !important">
    <div class="ui grid">
      <div class="column" style="text-align:right">
        <i class="close icon" @click="$router.push('/')" style="cursor: pointer"></i>
      </div>
    </div>
    <div class="ui four column grid">
      <div class="row">
        <div class="column">
          <div class="ui secondary vertical menu">
            <div class="item">
              <div class="header">Cashier</div>
              <div class="menu">
                <div class="item">Cashier</div>
              </div>
            </div>
          </div>
        </div>
        <div class="column">
          <div class="ui secondary vertical menu">
            <div class="item">
              <div class="header">Reports</div>
              <div class="menu">
                <div class="item">Closeout Report</div>
                <div class="item">Transaction Detail Report</div>
              </div>
            </div>
          </div>
        </div>
        <div class="column">
          <div class="ui secondary vertical menu">
            <div class="item">
              <div class="header">Sales</div>
              <div class="menu">
                <div class="item">All Sales</div>
                <div class="item">Find</div>
              </div>
            </div>
          </div>
        </div>
        <div class="column">
          <div class="ui secondary vertical menu">
            <div class="item">
              <div class="header">Users</div>
              <div class="menu">
                <div class="item">All Users</div>
                <div class="item">Add User</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {};
</script>