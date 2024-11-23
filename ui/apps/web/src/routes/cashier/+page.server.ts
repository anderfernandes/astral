import { fail } from '@sveltejs/kit';

export const load = async ({ fetch, url }) => {
	console.log(url.toString());
	const [days, customers, payment_methods, products] = await Promise.all([
		fetch(`/events?end=${new Date().getFullYear()}-12-31&calendar`)
			.then((res) => res.json())
			.then((res) => res.data as { date: string; events: IEvent[] }[]),
		fetch('/users')
			.then((res) => res.json())
			.then((res) => res.data as IUser[])
			.then((data) =>
				data.map((user) => ({ id: user.id, name: `${user.firstname} ${user.lastname}` }))
			),
		fetch('/payment-methods')
			.then((res) => res.json())
			.then((res) => res.data as IPaymentMethod[]),
		fetch('/products?in_cashier')
			.then((res) => res.json())
			.then((res) => res.data as IProduct[])
	]);

	console.log(products);

	return { days, customers, payment_methods, products };
};

export const actions = {
	default: async ({ fetch, request }) => {
		const data = await request.formData();
		data.append('source', 'cashier');
		console.log(data);
		const req = await fetch('/sales', {
			method: 'POST',
			body: data
		});

		if (req.status > 299) {
			const res: IResponseWithValidationErrors = await req.json();
			console.log(res);
			return fail(req.status, res);
		}

		return { success: true };
	}
};
