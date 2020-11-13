<template>
  <div id="public" v-if="!loading" style="min-height:100%">
    <div class="ui borderless fixed menu">
      <div class="ui container">
        <router-link to="/" class="header item">
          <img class="logo" style="margin-right:1.5em" :src="settings.logo" :alt="settings.organization">
        </router-link>
        <router-link to="/" class="item">
          <i class="home icon"></i> Home
        </router-link>
        <div class="right menu">
          <div class="item">
            <router-link to="/cart" class="ui blue button">
              <i class="cart icon"></i> Cart ({{ count }})
            </router-link>
          </div>
          <div class="item" v-if="false">
            <div class="ui right floated item">
              <a href="/login" class="ui primary button">Login</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="ui container" style="min-height:70vh; padding-top:6em; padding-bottom:3rem">
      <transition name="fade" mode="out-in">
        <router-view></router-view>
      </transition>
    </div>
    <div class="ui vertical footer blue inverted segment" style="min-height:27vh; padding-top:2em; padding-bottom:2em">
      <div class="ui center aligned container">
        <div class="ui stackable divided inverted two column grid">
          <div class="four wide column">
            <h4 class="ui inverted header">Shortcuts</h4>
            <router-link to="/" style="color:white"><i class="home icon"></i>Home</router-link>
          </div>
          <div class="twelve wide column">
            <h4 class="ui inverted header">&copy; 2017-{{ new Date().getFullYear() }} {{ settings.organization }}. All rights reserved.</h4>
            <p>{{ settings.address }} | {{ settings.phone }}</p>
            <p> 
              <i class="phone icon"></i> {{ settings.phone }} | 
              <i class="envelope outline icon"></i> <a :href="`mailto:` + settings.email" style="color:white">{{ settings.email }}</a> | 
              <i class="globe icon"></i> <a target="_blank" :href="`http://` + settings.website" style="color:white">{{ settings.website }}</a></p>
          </div>
        </div>
        <div class="ui stackable inverted grid">
          <div class="column">
            <div class="ui divider"></div>
            <div>
              Brought to you with <i class="heart icon"></i> and little help from 
              <a href="https://astral.anderfernandes.com" target="_blank" class="ui basic tiny image label">
                <img src="/astral-logo-dark.png" alt="Astral">
                Astral
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="ui active inline loader" v-else></div>
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

<style>
  .fade-enter-active, .fade-leave-active {
    transition: opacity .75s ease;
  }
  .fade-enter, .fade-leave-active {
    opacity: 0;
  }
  .child-view {
    position: absolute;
    transition: all .75s cubic-bezier(.55,0,.1,1);
  }
  .slide-left-enter, .slide-right-leave-active {
    opacity: 0;
    -webkit-transform: translate(30px, 0);
    transform: translate(30px, 0);
  }
  .slide-left-leave-active, .slide-right-enter {
    opacity: 0;
    -webkit-transform: translate(-30px, 0);
    transform: translate(-30px, 0);
  }
</style>