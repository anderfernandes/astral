import { redirect } from '@sveltejs/kit';

export const actions = {
	default: async ({ request, fetch, cookies }) => {
		const token = cookies.get('astral_token');

		if (!token || token.length === 0) redirect(303, '/login');

		const req = await fetch('/user', {
			headers: { Authorization: 'Bearer ' + token }
		});

		if (req.status !== 200) redirect(302, '/login');

		const data = await request.formData();

		console.log(data);

		redirect(302, '/checkout');
	}
};
