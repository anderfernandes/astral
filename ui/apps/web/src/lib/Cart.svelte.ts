export class Cart {
	products = $state<IProductWithQuantity[]>([]);
	tickets = $state<ITicketWithQuantity[]>([]);
	tax = 0;

	constructor(tax: number) {
		// TODO: Take `ISale` in the constructor.
		// TODO: Map sale tickets and products into their Cart type counterpart
		this.products = [];
		this.tickets = [];
		this.tax = tax;
	}

	get count() {
		return (
			this.products.reduce((a, p) => a + p.quantity, 0) +
			this.tickets.reduce((a, t) => a + t.quantity, 0)
		);
	}

	get totals() {
		const products_totals = this.products.reduce((a, p) => a + p.price * p.quantity, 0);
		const tickets_totals = this.tickets.reduce((a, t) => a + t.type.price * t.quantity, 0);
		const subtotal = products_totals + tickets_totals;
		const tax_rate = this.tax / 100;
		const tax = subtotal * tax_rate;
		const total = subtotal + tax;

		return {
			subtotal: subtotal.toFixed(2),
			tax: tax.toFixed(2),
			total: total.toFixed(2)
		};
	}

	addTicket(ticket: Required<Pick<ITicket, 'type' | 'event'>>) {
		const i = this.tickets.findIndex(
			(t) => t.type.id === ticket.type.id && t.event.id === ticket.event.id
		);
		if (i === -1) {
			if (ticket.event.seats.available <= 0) {
				alert('This event is sold out.');
				return;
			}
			this.tickets.push({ ...ticket, quantity: 1 });
		} else {
			const event_seats_in_sale = this.tickets.filter((t) => t.event.id === ticket.event.id).length;
			if (event_seats_in_sale >= this.tickets[i].event.seats.available) {
				alert(
					'You have the last available ticket for this event on your cart. Go check out before someone else gets it!'
				);
				return;
			}
			this.tickets[i].quantity++;
		}
	}

	addProduct(product: IProduct) {
		const i = this.products.findIndex((p) => p.id === product.id);
		if (i === -1) {
			if (product.stock <= 0) {
				alert('Out of stock!');
				return;
			}
			this.products.push({ ...product, quantity: 1 });
		} else {
			if (this.products[0].quantity >= this.products[0].stock) {
				alert(
					`You have the last ${product.name} on your cart. Go check out before someone else gets it!`
				);
				return;
			}
			this.products[i].quantity++;
		}
		this.save();
	}

	clear() {
		this.products = [];
		this.tickets = [];
	}

	clearTicket(ticket: ITicketWithQuantity) {
		this.tickets = this.tickets.filter(
			(t) => !(t.event.id === ticket.event.id && t.type.id === ticket.type.id)
		);
	}

	clearProduct(product: IProduct) {
		this.products = this.products.filter((p) => p.id !== product.id);
	}

	save() {
		localStorage.setItem('products', JSON.stringify(this.products));
	}

	restore() {
		const products = JSON.parse(localStorage.getItem('products') as string);
		this.products = products;
	}
}
