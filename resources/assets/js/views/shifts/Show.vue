<template>
  <div id="show">
    <div class="ui black basic button" @click.prevent="$router.go(-1)">
      <i class="left chevron icon"></i>
      Back
    </div>
    <div class="ui yellow labeled icon button" @click.prevent="$router.push({ name: 'edit', params : { id: shift.id, shift } })">
      <i class="edit icon"></i>
      Edit
    </div>
    <div class="ui header">
      
        Shift #{{ shift.id }}
        <div class="sub header">{{ shift.date }} ~ {{ shift.start }} - {{ shift.end }}</div>
      
    </div>
    <div class="ui black label" v-for="(employee, i) in shift.employees" :key="i">
      <i class="user circle icon"></i>
      {{ employee.name }}
      <div class="detail">{{ employee.position }}</div>
    </div>
  </div>
</template>

<script>

  export default {
  
    props : ["shift"]

  }

</script>
