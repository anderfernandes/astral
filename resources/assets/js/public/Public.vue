<template>
  <div id="cashier" v-if="!loading">
    <div class="ui borderless menu">
      <div class="ui container">
        <div class="header item">
          <img class="logo" style="margin-right:1.5em" src="/logo.png" alt="Mayborn Science Theater">
          {{ settings.organization }}
        </div>
        <div class="right menu">
          <div class="item">
            <i class="cart icon"></i> {{ count }}
          </div>
          <div class="item">
            <div class="ui right floated item">
              <div class="ui primary button">Login</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="ui container" style="min-height:100%">
      <router-view />
    </div>
  </div>
</template>

<script>

import { createNamespacedHelpers } from 'vuex'

const { mapState, mapActions, mapGetters } = createNamespacedHelpers('Public')

import { format, distanceInWordsToNow } from 'date-fns'

export default {
  
  data: () => ({
    loading: true,
  }),

  computed: {

    ...mapState({ 
      
      settings: state => state.settings

    }),

    ...mapGetters({
      
      count: 'count'
      
    })

  },

  methods: {
    
    ...mapActions(['fetchSettings']),
    
    format,
    
    distanceInWordsToNow,
  }, 

  mounted() {
    
    this.loading = true
    
    this.fetchSettings()
    
    this.loading = false
  },

}
</script>