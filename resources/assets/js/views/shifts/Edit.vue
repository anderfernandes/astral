<template>
  <div>
    <div class="ui black basic button" @click.prevent="$router.go(-1)">
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

    components : { ShiftForm }

  }

</script>