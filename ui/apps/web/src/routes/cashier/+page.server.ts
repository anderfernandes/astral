import { fail, redirect } from '@sveltejs/kit';

export const load = async ({ fetch }) => {
	const [events, customers, payment_methods, products] = await Promise.all([
		fetch('/events?start=2024-01-01&end=2024-12-31')
			.then((res) => res.json())
			.then((res) => res.data as IEvent[]),
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

	console.log(customers);

	return { events, customers, payment_methods, products };
};

export const actions = {
	default: async ({ request, fetch }) => {
		const data = await request.formData();
		console.log(data);
		const req = await fetch('/sales', {
			method: 'POST',
			body: data
		});

		if (req.status > 299) {
			console.log(req.status, await req.json());
			return fail(req.status, { message: 'An error has occurred.' });
		}

		redirect(301, '/cashier');
	}
};
