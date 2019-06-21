<template>
  <div id="index">
    
    <div class="ui black labeled icon button" @click="$router.push({ name : 'shifts.create' })">
      <i class="calendar plus icon"></i>
      Create New Shift
    </div>
    
    <calendar></calendar>
    
  </div>
</template>

<script>

  import Calendar from '../../components/Calendar'

  export default {
    
    components : { Calendar },

  }
</script>

