import { redirect } from '@sveltejs/kit';

export const load = async ({ cookies, fetch }) => {
	const token = cookies.get('astral_token');

	if (!token || token.length === 0) redirect(303, '/login');

	const req = await fetch('/user', {
		headers: { Authorization: 'Bearer ' + token }
	});

	if (req.status !== 200) redirect(302, '/login');

	const data = new FormData();
	data.set('products[0][id]', '3');
	data.set('products[0][quantity]', '3');

	const request = await fetch('/stripe/session/create', { method: 'POST', body: data });
	const { client_secret }: { client_secret: string } = await request.json();

	return { client_secret };
};
