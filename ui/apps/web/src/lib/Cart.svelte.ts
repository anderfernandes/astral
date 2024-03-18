export class Cart {
	products = $state<IProductWithQuantity[]>([]);
	tickets = $state<ITicketWithQuantity[]>([]);

	constructor() {
		// TODO: Take `ISale` in the constructor.
		// TODO: Map sale tickets and products into their Cart type counterpart
		this.products = [];
		this.tickets = [];
	}

	addTicket(ticket: Required<Pick<ITicket, 'type' | 'event'>>) {
		const i = this.tickets.findIndex(
			(t) => t.type.id === ticket.type.id && t.event.id === ticket.event.id
		);
		if (i === -1) {
			this.tickets.push({ ...ticket, quantity: 1 });
		} else {
			this.tickets[i].quantity++;
		}
	}

	get count() {
		return (
			this.products.reduce((sum, p) => sum + p.quantity, 0) +
			this.tickets.reduce((sum, t) => sum + t.quantity, 0)
		);
	}

	addProduct(product: IProduct) {
		const i = this.products.findIndex((p) => p.id === product.id);
		if (i === -1) {
			this.products.push({ ...product, quantity: 1 });
		} else {
			this.products[i].quantity++;
		}
	}
}
