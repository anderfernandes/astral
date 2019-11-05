let getDefaultState = () => ({
  sale: {
    reference: null,
    payment_method_id: 1,
    memo: null,
    cashier_id: parseInt(localStorage.getItem("u")),
    customer_id: null,
    subtotal: 0,
    tax: 0,
    total: 0,
    tendered: "",
    change: 0,
    balance: 0,
    products: [],
    tickets: []
  }
});

export default {
  namespaced: true,

  state: getDefaultState(),

  mutations: {
    ADD_PRODUCT(state, product) {
      if (state.sale.products.some(p => p.id === product.id)) {
        // Product already exists, add one more
        let existingProduct = state.sale.products.find(
          p => p.id === product.id
        );
        let index = state.sale.products.findIndex(p => p.id === product.id);
        state.sale.products.splice(index, 1, {
          id: product.id,
          name: product.name,
          price: product.price,
          cover: product.cover,
          quantity: existingProduct.quantity + 1
        });
      } else {
        // Product does not exist, add one
        state.sale.products.push({
          id: product.id,
          name: product.name,
          price: product.price,
          cover: product.cover,
          quantity: 1
        });
      }
    },

    REMOVE_PRODUCT(state, product) {
      let existingProduct = state.sale.products.find(p => p.id === product.id);
      let index = state.sale.products.findIndex(p => p.id === product.id);
      if (existingProduct && existingProduct.quantity > 1) {
        // If product exists, take one out of quantity
        state.sale.products.splice(index, 1, {
          id: product.id,
          name: product.name,
          price: product.price,
          cover: product.cover,
          quantity: existingProduct.quantity - 1
        });
      } else {
        state.sale.products.splice(index, 1);
      }
    },

    CLEAR_PRODUCT(state, product) {
      let existingProduct = state.sale.products.find(p => p.id === product.id);
      let index = state.sale.products.findIndex(p => p.id === product.id);
      if (existingProduct) {
        state.sale.products.splice(index, 1);
      }
    },

    // If it exists, splice. If it doesn't, push
    ADD_TICKET(state, payload) {
      let existingEventIndex = state.sale.tickets.findIndex(
        t => t.event.id === payload.event.id
      );
      if (existingEventIndex != -1) {
        let currentEvent = state.sale.tickets[existingEventIndex];
        // Checking if ticket exist in that event
        let existingTicketIndex = currentEvent.tickets.findIndex(
          t => t.id === payload.ticket.id
        );
        if (existingTicketIndex != -1) {
          // Find current amount of tickets
          let existingTicket = currentEvent.tickets[existingTicketIndex];
          // Update ticket objects
          Object.assign(
            currentEvent.tickets.splice(existingTicketIndex, 1, {
              id: payload.ticket.id,
              name: payload.ticket.name,
              price: payload.ticket.price,
              quantity: existingTicket.quantity + 1
            })
          );
        } else {
          // Add new ticket to event
          currentEvent.tickets.push({
            id: payload.ticket.id,
            name: payload.ticket.name,
            price: payload.ticket.price,
            quantity: 1
          });
        }
      } else {
        state.sale.tickets.push({
          event: {
            id: payload.event.id,
            start: payload.event.start,
            type: {
              id: payload.event.type.id,
              name: payload.event.type.name
            },
            show: {
              id: payload.event.show.id,
              name: payload.event.show.name,
              cover: payload.event.show.cover,
              type: {
                id: payload.event.show.type.id,
                name: payload.event.show.type.name
              }
            }
          },
          tickets: [
            {
              id: payload.ticket.id,
              name: payload.ticket.name,
              price: payload.ticket.price,
              quantity: 1
            }
          ]
        });
      }
    },

    REMOVE_TICKET(state, payload) {
      // Checking if the event of the ticket we want to remove exists
      let existingEventIndex = state.sale.tickets.findIndex(
        t => t.event.id === payload.event.id
      );
      if (existingEventIndex != -1) {
        let currentEvent = state.sale.tickets[existingEventIndex];
        // If ticket exists, we will subtract one. Otherwise, we will remove all of them
        let existingTicketIndex = currentEvent.tickets.findIndex(
          t => t.id === payload.ticket.id
        );
        if (existingTicketIndex != -1) {
          let existingTicket = currentEvent.tickets[existingTicketIndex];
          if (existingTicket.quantity > 1)
            Object.assign(
              currentEvent.tickets.splice(existingTicketIndex, 1, {
                id: payload.ticket.id,
                name: payload.ticket.name,
                price: payload.ticket.price,
                quantity: existingTicket.quantity - 1
              })
            );
          else {
            currentEvent.tickets.splice(existingTicketIndex, 1);
            if (currentEvent.tickets.length < 1)
              state.sale.tickets.splice(existingEventIndex, 1);
          }
        } else {
          currentEvent.tickets.splice(existingTicketIndex, 1);
          if (currentEvent.tickets.length < 1)
            state.sale.tickets.splice(existingEventIndex, 1);
        }
      }
    },

    CLEAR_TICKET(state, payload) {
      let existingEventIndex = state.sale.tickets.findIndex(
        t => t.event.id === payload.event.id
      );
      if (existingEventIndex != -1) {
        let currentEvent = state.sale.tickets[existingEventIndex];
        let existingTicketIndex = currentEvent.tickets.findIndex(
          t => t.id === payload.ticket.id
        );
        if (existingTicketIndex != -1) {
          // Remove ticket from tickets array
          currentEvent.tickets.splice(existingTicketIndex, 1);
          // Remove event/ticket object from ticket payload array if there are no other tickets
          if (currentEvent.tickets.length < 1)
            state.sale.tickets.splice(existingEventIndex, 1);
        }
      }
    },

    SET_TENDERED(state, tendered) {
      Object.assign(state.sale, {
        tendered: tendered.toLocaleString("en-US", {
          minimumFractionDigits: 2,
          maximumFractionDigits: 2
        })
      });
    },

    CALCULATE_TOTALS(state, tax_rate) {
      let products_total = state.sale.products.reduce(
        (total, product) => total + product.quantity * product.price,
        0
      );
      let tickets_total =
        state.sale.tickets.length == 0
          ? 0
          : state.sale.tickets.reduce((accumulator, event) => {
              let event_total =
                event.tickets.length == 0
                  ? 0
                  : event.tickets.reduce(
                      (ttl, tck) => ttl + tck.quantity * tck.price,
                      0
                    );
              return accumulator + event_total;
            }, 0);
      let subtotal = products_total + tickets_total;
      let tax = subtotal * tax_rate;
      tax = tax.toLocaleString("en-US", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
        useGrouping: false
      });
      tax = parseFloat(tax);
      let total = tax + subtotal;
      total = total.toLocaleString("en-US", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
        useGrouping: false
      });
      total = parseFloat(total);
      let change = parseFloat(state.sale.tendered || 0) - total;
      change = change <= 0 ? 0 : change;

      let balance = parseFloat(state.sale.tendered) - total;

      Object.assign(state.sale, {
        subtotal,
        tax,
        total,
        change,
        balance
      });
    },

    RESET(state) {
      const s = getDefaultState();
      Object.keys(s).forEach(key => {
        state[key] = s[key];
      });
    }
  },

  getters: {}
};
