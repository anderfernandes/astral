<template>
  <div class="ui form">
    
    <div class="two fields">
      <div class="field">
        <label>Start Date</label>
        <input type="date" v-model="shift.start_date">
      </div>
      <div class="field">
        <label>Start Time</label>
        <input type="time" v-model="shift.start_time">
      </div>
    </div>

    <div class="two fields">
      <div class="field">
        <label>End Date</label>
        <input type="date" v-model="shift.end_date">
      </div>
      <div class="field">
        <label>End Time</label>
        <input type="time" v-model="shift.end_time">
      </div>
    </div>

    <div class="two fields" v-for="employee in shift.employees" :key="employee.id">
      <div class="field">
        <label>Employee</label>
        <select class="ui fluid dropdown" v-model="employee.name">
          <option value=""></option>
          <option value="Anderson">Anderson</option>
          <option value="Anjelicca">Anjelicca</option>
          <option value="Fred">Fred</option>
          <option value="Cliff">Cliff</option>
        </select>
      </div>
      <div class="field">
        <label>Position</label>
        <div class="ui action input">
          <select class="ui dropdown" v-model="employee.position">
            <option value=""></option>
            <option value="Cashier">Cashier</option>
            <option value="Usher">Usher</option>
            <option value="Console">Console</option>
            <option value="Float">Float</option>
          </select>  
          <div class="ui basic red icon button" @click="remove(employee)">
            <i class="trash icon"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="two fields">
      <div class="field">
        <div class="ui blue labeled icon button" @click="add">
          <i class="plus icon"></i> Add Another Employee
        </div>
      </div>
      <div class="field" style="text-align: right">
        <div class="ui labeled icon green button" @click="submit">
          <i class="save icon"></i> Save
        </div>
        <div class="ui labeled icon yellow button">
          <i class="erase icon"></i> Star Over
        </div>
      </div>

    </div>

  </div>
</template>

<script>

  import { format } from "date-fns/format"

  export default {
    
    data : () => ({

  	  shift : {
        employees  : [],
        start      : new Date(),
        end        : new Date(),
      }
  
    }),
  
    computed : {

      format,
      
      'shift.start_date': {
        set(value) { Object.assign(this.shift, { start : new Date(value) }) },
        get()      { return this.format(this.shift.start, "YYYY-MM-DD")          },
      },

      'shift.start_time': {
        set(value) { Object.assign(this.shift, { start : new Date(value) }) },
        get()      { return this.format(this.shift.start, "hh:mm A")          },
      },

    },

    created() {
      if (this.$route.name == "shifts.edit")
        Object.assign(this.shift, {
          id        : this.$route.params.data.id,
          employees : this.$route.params.data.employees,
          date      : this.$route.params.data.date.toISOString().split('T')[0],
          from      : this.$route.params.data.start.toTimeString().split(' ')[0],
          to        : this.$route.params.data.end.toTimeString().split(' ')[0],
        })
    },
    
    // updated() { console.log("# of employees: ",this.shift.employees.length) },
    
    methods : {
    
      add() {
        id++
        this.shift.employees.push({
          id,
          name     : null,
          position : null,
        })
      
      },
      
      remove(employee) {
        let i = this.shift.employees.findIndex(emp => emp.id == employee.id)
        this.shift.employees.splice(i, 1)
      },
    
      submit() {

        let id = this.shift.id
        
        let employees = this.shift.employees
        
        let start = this.date
        start.setHours(this.shift.from.split(':')[0], this.shift.from.split(':')[1])
        
        let end = new Date(this.shift.date)
        end.setHours(this.shift.to.split(':')[0], this.shift.to.split(':')[1])
        
        
        this.$store.commit('ADD_SHIFT', {
          id, employees, start, end, date : new Date(this.date)
        })
        
        this.shift = {
          employees : [{
            id       : null,
            employee : null,
            position : null,
          }],
          date      : new Date().toISOString().split('T')[0],
          from      : "08:00",
          to        : "12:00"
      }
        
        this.$router.push("/")
      }
    
    },

  }
</script>
