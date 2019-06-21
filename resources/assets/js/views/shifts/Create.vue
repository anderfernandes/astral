<template>
  <div id="create">
    <div class="ui basic black button" @click="$router.push({ name : 'shifts.index' })">
      <i class="left chevron icon"></i>
      Back
    </div>
    <br><br>
    <shift-form></shift-form>
  </div>
</template>

<script>

  import ShiftForm from '../../components/forms/Shifts.vue'

  export default {
    
    components : { ShiftForm },

  }
</script>

