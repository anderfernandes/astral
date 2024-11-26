import { fail, redirect } from '@sveltejs/kit';

export const load = async ({ fetch }) => {
	const [users, payment_methods] = await Promise.all([
		fetch(`/users?type=individual`)
			.then((res) => res.json() as Promise<{ data: IUser[] }>)
			.then(({ data }) => data),
		fetch(`/payment-methods?type=card,check,cash`)
			.then((res) => res.json() as Promise<{ data: IPaymentMethod[] }>)
			.then(({ data }) => data)
	]);

	console.log(users);

	return {
		users: users.map((u) => ({ text: `${u.firstname} ${u.lastname}`, value: u.id as number })),
		payment_methods
	};
};

export const actions = {
	default: async ({ fetch, request }) => {
		const data = await request.formData();

		console.log(data);

		const req = await fetch('/memberships', {
			method: 'POST',
			body: data
		});

		if (req.status > 299) {
			console.log(req.status, await req.json());
			return fail(req.status, { message: 'An error occurred' });
		}

		const res: { data: number } = await req.json();

		console.log(res.data);

		redirect(301, '/admin/memberships');
	}
};
