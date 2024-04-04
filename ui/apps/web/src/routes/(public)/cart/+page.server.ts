import { redirect } from '@sveltejs/kit';

export const actions = {
	default: async ({ request, fetch, cookies }) => {
		const data = await request.formData();
		console.log(Object.fromEntries(data));
		cookies.set('astral_cart', JSON.stringify(Object.fromEntries(data)), { path: '/' });

		const token = cookies.get('astral_token');

		if (!token || token.length === 0) redirect(303, '/login?redirect=/cart');

		const req = await fetch('/user', {
			headers: { Authorization: 'Bearer ' + token }
		});

		if (req.status !== 200) redirect(301, '/login?redirect=/cart');

		console.log(data);

		redirect(302, '/checkout');
	}
};
