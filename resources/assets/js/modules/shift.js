const today = new Date()

export default ({
  state : {
  	shifts : [{
      date  : today,
    	id    : 1,
      start : new Date(today.setHours(8, 30, 0)),
      end   : new Date(today.setHours(12, 30, 0)),
      employees : [
      	{ id: 1, name: "Anderson",  position: "Float"   },
        { id: 2, name: "Anjelicca", position: "Cashier" },
        { id: 3, name: "Cliff",     position: "Console" },
      ],
    }],
  },
  
  mutations : {
  
  	ADD_SHIFT(state, payload) {
      
      const shift = state.shifts.findIndex(shift => shift.id == payload.id) //?
      
      if (shift == -1) {
        let id = state.shifts[state.shifts.length - 1].id
        id++
        Object.assign(payload, { id })
    	  state.shifts.push(payload)
      }
      else
      state.shifts.splice(shift, 1, payload)
    },

    REMOVE_SHIFT(state, payload) {
      
      let i =  state.shifts.findIndex(shift => shift.id == payload)
      
      state.shifts.splice(i, 1)
    }
  
  },
  
  getters : {
  	shifts : state => {
    	let shiftsByDay = [[], [], [], [], [], [], []]
      //state.shifts.forEach(shift => shiftsByDay[shift.start.getDay()].push(shift))
      state.shifts.forEach(shift => shiftsByDay[shift.start.getDay()].push(shift))
      return shiftsByDay
    }
  }
})
