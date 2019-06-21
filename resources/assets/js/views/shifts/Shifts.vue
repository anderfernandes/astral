<template>
  <div id="app">
    <transition mode="out-in" name="fade">
      <router-view />
    </transition>
    
    <sui-modal v-model="open" basic>
      <div class="ui icon header" style="padding-bottom: 0" v-if="alert != null">
        <sui-icon :name="alert.icon"></sui-icon> {{ alert.title }}
      </div>
      <div class="content" style="padding-top: 0" v-if="alert != null">
        <p>{{ alert.message }}</p>
      </div>
      <div class="actions" v-if="alert != null">
        <sui-button :color="buttonColor" inverted icon="check" @click="open = false">
          Gotcha!
        </sui-button>
      </div>
    </sui-modal>

  </div>
</template>

<script>
  
  export default {

    created() { this.$router.push({ name: "shifts.index" }) },
  
    computed: {
        
        alert: {
          set(value) { this.$store.commit('SET_ALERT', value) },
          get()      { return this.$store.getters.alert },
        },
        
        open : {
          set(value) { 
            this.$store.commit('TOGGLE_SHOW_ALERT', value)
            if (value == false)
              this.alert = null
          },
          get()      { return this.$store.getters.show_alert }
        },

        buttonColor() {
          switch (this.alert.type) {
            case "info"    : return "blue"
            case "warning" : return "yellow"
            case "error"   : return "red"
            case "success" : return "green"
          }
        }
      },
    }

</script>


<style>
  .observer {
    height: 1px !important;
  }

  textarea {
    font: inherit;
  }

  #top {
    position: fixed;
    z-index: 1;
    padding: 0 0 0 0 !important;
    margin-top: -1em;
    width: 100vw !important;
  }

  .fade-enter-active, .fade-leave-active {
    transition: opacity 0.5s;
  }

  .fade-enter, .fade-leave-to {
    opacity: 0;
  }

  .ui.segment#event-type:hover {
    background-color: transparent !important;
    border-width: 1px;
    border-color: white;
    cursor: pointer;
    transition: all 0.5s;
  }

  .ui.segment#event-type {
    cursor: pointer;
    transition: all 0.5s;
  }

  .card#event-type:hover > .content > .description {
    color: black !important;
  }

  .sale.box.header .ui.label {
    border-color: white !important;
    border-width: 1px !important;
    color: white !important;
    background-color: transparent !important;
  }

  .ui.sale.segment {
    cursor: pointer !important;
  }

  .list-enter-active, .list-leave-active, .list-move {
    transition: 0.5s cubic-bezier(0.6, 0.12, 0.34, 0.95);
    transition-property: opacity, transform;
  }

  .list-enter {
    opacity: 0;
    transform: translateX(50px) scaleY(0.5);
  }

  .list-enter-to {
    opacity: 1;
    transform: translateX(0) scaleY(1);
  }

  .list-leave-active { position: absolute; }
  .list-leave-to {
    opacity: 0;
    transform: scaleY(0);
    transform-origin: center-top;
  }

  /*.list-enter, .list-leave-to {
    opacity: 0;
    transition: translateY(30px);
  }*/

  .ui.sale.segment .header, .ui.sale.segment .meta {
    color: white !important;
  }

  /** OPEN SALE STYLES **/

  /** Switching color of sale box **/
  .ui.open.sale.segment       { 
    transition: all 0.5s;
    background-color: #6435c9 !important;
    border: white 1px solid !important;
  }

  .ui.open.sale.segment:hover { 
    transition: all 0.5s;
    background-color: white   !important; 
    border: #6435c9 1px solid !important;
  }

  /** Switching text color of sale box **/
  .ui.open.sale.segment .header, 
  .ui.open.sale.segment .meta { 
    transition: all 0.5s;
    color: white !important;
  }

  .ui.open.sale.segment:hover .header,
  .ui.open.sale.segment:hover .meta,
  .ui.open.sale.segment:hover .ui.black.button,
  .ui.open.sale.segment:hover .ui.label:not(.violet) { 
    transition: all 0.5s;
    color: #6435c9 !important;
  }

  .ui.open.sale.segment:hover .ui.event-type.label {
    transition: all 0.5s;
    color: white !important;
  }

  .ui.open.sale.segment:hover .ui.label:not(.event-type) {
    transition: all 0.5s;
    border: #6435c9 1px solid !important;
    color: #6435c9 !important;
  }

  /** COMPLETE SALE STYLES **/

  /** Switching color of sale box **/
  .ui.complete.sale.segment       { 
    transition: all 0.5s;
    background-color: #21ba45 !important;
    border: white 1px solid !important;
  }

  .ui.complete.sale.segment:hover { 
    transition: all 0.5s;
    background-color: white   !important; 
    border: #21ba45 1px solid !important;
  }

  /** Switching text color of sale box **/
  .ui.complete.sale.segment .header, 
  .ui.complete.sale.segment .meta { 
    transition: all 0.5s;
    color: white !important;
  }

  .ui.complete.sale.segment:hover .header,
  .ui.complete.sale.segment:hover .meta,
  .ui.complete.sale.segment:hover     .ui.black.button,
  .ui.complete.sale.segment:hover .ui.label:not(.green) { 
    transition: all 0.5s;
    color: #21ba45 !important;
  }

  .ui.complete.sale.segment:hover .ui.event-type.label {
    transition: all 0.5s;
    color: white !important;
  }

  .ui.complete.sale.segment:hover .ui.label:not(.event-type) {
    transition: all 0.5s;
    border: #21ba45 1px solid !important;
    color : #21ba45 !important;
  }

  /** TENTATIVE SALE STYLES **/

  /** Switching color of sale box **/
  .ui.tentative.sale.segment       { 
    transition: all 0.5s;
    background-color: #fbbd08 !important;
    border: white 1px solid !important;
  }

  .ui.tentative.sale.segment:hover { 
    transition: all 0.5s;
    background-color: white   !important; 
    border: #fbbd08 1px solid !important;
  }

  /** Switching text color of sale box **/
  .ui.tentative.sale.segment .header, 
  .ui.tentative.sale.segment .meta { 
    transition: all 0.5s;
    color: white !important;
  }

  .ui.tentative.sale.segment:hover .header,
  .ui.tentative.sale.segment:hover .meta,
  .ui.tentative.sale.segment:hover .ui.black.button,
  .ui.tentative.sale.segment:hover .ui.label:not(.yellow) { 
    transition: all 0.5s;
    color: #fbbd08 !important;
  }

  .ui.tentative.sale.segment:hover .ui.event-type.label {
    transition: all 0.5s;
    color: white !important;
  }

  .ui.tentative.sale.segment:hover .ui.label:not(.event-type) {
    transition: all 0.5s;
    border: #fbbd08 1px solid !important;
  }

  /** NO SHOW SALE STYLES **/

  /** Switching color of sale box **/
  .ui.no.show.sale.segment       { 
    transition: all 0.5s;
    background-color: db2828 !important;
    border: white 1px solid !important;
  }

  .ui.no.show.sale.segment:hover { 
    transition: all 0.5s;
    background-color: white   !important; 
    border: #f2711c 1px solid !important;
  }

  /** Switching text color of sale box **/
  .ui.no.show.sale.segment .header, 
  .ui.no.show.sale.segment .meta { 
    transition: all 0.5s;
    color: white !important;
  }

  .ui.no.show.sale.segment:hover .header,
  .ui.no.show.sale.segment:hover .meta,
  .ui.no.show.sale.segment:hover .ui.black.button,
  .ui.no.show.sale.segment:hover .ui.label:not(.orange) { 
    transition: all 0.5s;
    color: #f2711c !important;
  }

  .ui.no.show.sale.segment:hover .ui.event-type.label {
    transition: all 0.5s;
    color: white !important;
  }

  .ui.no.show.sale.segment:hover .ui.label:not(.event-type) {
    transition: all 0.5s;
    border: #f2711c 1px solid !important;
    color: #f2711c !important;
  }

  /** CANCELED SALE STYLES **/

  /** Switching color of sale box **/
  .ui.canceled.sale.segment       { 
    transition: all 0.5s;
    background-color: db2828 !important;
    border: white 1px solid !important;
  }

  .ui.canceled.sale.segment:hover { 
    transition: all 0.5s;
    background-color: white   !important; 
    border: #db2828 1px solid !important;
  }

  /** Switching text color of sale box **/
  .ui.canceled.sale.segment .header, 
  .ui.canceled.sale.segment .meta { 
    transition: all 0.5s;
    color: white !important;
  }

  .ui.canceled.sale.segment:hover .header,
  .ui.canceled.sale.segment:hover .meta,
  .ui.canceled.sale.segment:hover .ui.black.button,
  .ui.canceled.sale.segment:hover .ui.label:not(.red) { 
    transition: all 0.5s;
    color: #db2828 !important;
  }

  .ui.canceled.sale.segment:hover .ui.event-type.label {
    transition: all 0.5s;
    color: white !important;
  }

  .ui.canceled.sale.segment:hover .ui.label:not(.event-type) {
    transition: all 0.5s;
    border: #db2828 1px solid !important;
    color: #db2828 !important;
  }


  /** CONFIRMED SALE STYLES **/

  /** Switching color of sale box **/
  .ui.confirmed.sale.segment       { 
    transition: all 0.5s;
    background-color: white !important;
    border: #21ba45 1px solid !important;
  }

  .ui.confirmed.sale.segment .ui.label:not(.event-type) {
    background-color: white !important;
    border: #21ba45 1px solid !important;
    color: #21ba45 !important;
  }

  .ui.confirmed.sale.segment:hover { 
    transition: all 0.5s;
    background-color: black   !important; 
    border: black 1px solid !important;
  }

  /** Switching text color of sale box **/
  .ui.confirmed.sale.segment .header, 
  .ui.confirmed.sale.segment .meta { 
    transition: all 0.5s;
    color: #21ba45 !important;
  }

  .ui.confirmed.sale.segment:hover .header,
  .ui.confirmed.sale.segment:hover .meta,
  .ui.confirmed.sale.segment:hover .ui.black.button,
  .ui.confirmed.sale.segment:hover .ui.label:not(.green) { 
    transition: all 0.5s;
    color: #21ba45 !important;
  }

  .ui.confirmed.sale.segment:hover .ui.event-type.label {
    transition: all 0.5s;
    color: white !important;
  }

  .ui.confirmed.sale.segment:hover .ui.label:not(.event-type) {
    transition: all 0.5s;
    border: #21ba45 1px solid !important;
    background-color: black !important;
  }

  /** CANCELED LABEL STYLES **/
  .ui.confirmed.sale.segment:hover .ui.red.label,
  .ui.confirmed.sale.segment       .ui.red.label,
  .ui.complete.sale.segment:hover  .ui.red.label,
  .ui.complete.sale.segment        .ui.red.label,
  .ui.no.show.sale.segment:hover   .ui.red.label,
  .ui.no.show.sale.segment         .ui.red.label,
  .ui.open.sale.segment:hover      .ui.red.label,
  .ui.open.sale.segment            .ui.red.label,
  .ui.tentative.sale.segment:hover .ui.red.label,
  .ui.tentative.sale.segment .ui.red.label {
    transition: all 0.5s;
    border: #db2828 1px solid !important;
    background-color: #db2828 !important;
    color: white !important;
  }

  /** Slider **/
  input[type=range] {
    -webkit-appearance: none; /* Hides the slider so that custom slider can be made */
    width: 100%; /* Specific width is required for Firefox. */
    background: transparent; /* Otherwise white in Chrome */
  }

  input[type=range]::-webkit-slider-thumb {
    -webkit-appearance: none;
  }

  input[type=range]:focus {
    outline: none; /* Removes the blue border. You should probably do some kind of focus styling for accessibility reasons though. */
  }

  input[type=range]::-ms-track {
    width: 100%;
    cursor: pointer;

    /* Hides the slider so custom styles can be added */
    background: transparent;
    border-color: transparent;
    color: transparent;
  }

  input[type=range] {
    -webkit-appearance: none; /* Hides the slider so that custom slider can be made */
    width: 100%; /* Specific width is required for Firefox. */
    background: transparent; /* Otherwise white in Chrome */
  }

  /* Special styling for WebKit/Blink */
  input[type=range]::-webkit-slider-thumb {
    height: 1.5em;
    width: 1.5em;
    background: #FFFFFF -webkit-gradient(linear, left top, left bottom, from(transparent), to(rgba(0, 0, 0, 0.5)));
    background: #FFFFFF -webkit-linear-gradient(transparent, rgba(0, 0, 0, 0.5));
    background: #FFFFFF linear-gradient(transparent, rgba(0, 0, 0, 0.5));
    border-radius: 100%;
    -webkit-box-shadow: 0 1px 2px 0 rgba(34, 36, 38, 0.15), 0 0 0 1px rgba(34, 36, 38, 0.15) inset;
    box-shadow: 0 1px 2px 0 rgba(34, 36, 38, 0.15), 0 0 0 1px rgba(34, 36, 38, 0.15) inset;
    -webkit-transition: background 0.3s ease;
    transition: background 0.3s ease;
    margin-top: -7px;
  }

  input[type=range]::-webkit-slider-thumb:hover {
    cursor: pointer;
  }

  input[type=range]::-webkit-slider-runnable-track {
    border-radius: 4px;
    background-color: rgba(0, 0, 0, 0.05);
    height: 0.4em;
    border-color: white;
  }
</style>

