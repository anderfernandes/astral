<template>
  <div>
    <div class="ui horizontal divider header">
      <i class="calendar alternate outline icon"></i>
      Week of {{ weekOf }}
    </div>
    <div class="ui form">
      <div class="three fields">
        <div class="field"></div>
        <div class="field"></div>
        <div class="field">
          <div class="ui right floated black icon buttons">
            <div class="ui button" @click.prevent="toDate(-7)">
              <i class="chevron left icon"></i>
            </div>
            <div class="ui button">
              <i class="calendar alternate icon"></i>
            </div>
            <div class="ui button" @click="toDate(7)">
              <i class="chevron right icon"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="ui vertical segments">
      <div class="ui basic segment" v-for="(date, i) in days" :key="i">
        <div class="ui small header">
          {{ date.toDateString() }}
        </div>
        <div v-for="shift in shifts[date.getDay()]" :key="shift.id">
          <div class="ui inverted segment" v-if="shift.date.toDateString() == date.toDateString()">
            <div class="content">
              <div class="ui black top left attached label">
                <div class="detail">
                  Shift #{{ shift.id }}
                  <i class="clock icon"></i>
                  {{ shift.start | time }} - {{ shift.end   | time }}
                </div>
              </div>
              <div class="ui black top right attached label">
                <i class="eye icon" @click.prevent="$router.push({ name: 'show',  params : { id: shift.id, shift  }})"></i>
                <i class="edit icon" @click.prevent="$router.push({ name: 'edit', params : { id: shift.id, data: shift  }})"></i>
                <i class="trash icon" @click.prevent="remove(shift.id)"></i>
              </div>
              <br>
              <div class="ui inverted black label" v-for="employee in shift.employees" :key="employee.id">
                <i class="user circle icon"></i>
                {{ employee.name }}
                <div class="detail">{{ employee.position }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    
    data: () => ({
  
      today : new Date(),
    
    }),
    
    computed : {

      weekOf() {

        let month = new Date(this.today.setDate(this.today.getDate() - this.today.getDay())).toDateString().split(' ')[1]
        let day   = new Date(this.today.setDate(this.today.getDate() - this.today.getDay())).toDateString().split(' ')[2]
        let year  = new Date(this.today.setDate(this.today.getDate() - this.today.getDay())).toDateString().split(' ')[3]

        return `${month} ${day}, ${year}`

      },
    
      shifts() { return this.$store.getters.shifts },
    
      days() {
        // Array that will hold days of the week
        let days = []
        for (let day = 0; day < 7; day++) {
          let y = this.today.getFullYear()
          let m = this.today.getMonth()
          let d = (this.today.getDate() - this.today.getDay()) + day
          let date = new Date(y, m, d)
          days.push(date)
        }
        return days
      },
      
    },
    
    methods : {

      remove(shift) {

        this.$store.commit('REMOVE_SHIFT', shift)

      },
    
      toDate(days) {
        
        this.today = new Date(this.today.setDate(this.today.getDate() + days))
        
      },
    
      getTodaysEvents(date) {
      
        let todays_events = this.shifts.filter(shift => shift.start.toDateString() == date.toDateString())
        
        return todays_events
      
      }
    
    },
    
    filters : {
    
      time(date) {
      
        let time = date.getMinutes() == 0 
                    ? date.getHours() > 12 ? date.getHours() - 12 : date.getHours()
                    : `${date.getHours()}:${date.getMinutes()}`
                    
        let ap = date.toLocaleTimeString().split(' ')[1]
      
        return `${time} ${ap}`
      
      }
    
    }

  }
</script>

<style scoped>
  .ui.black.inverted.label {
    border: 1px solid white !important;
  }
</style>
