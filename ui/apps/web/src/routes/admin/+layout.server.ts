import { redirect } from '@sveltejs/kit';

export const load = async ({ cookies, fetch }) => {
	const token = cookies.get('astral_token');

	if (!token || token.length === 0) redirect(303, '/login');

	const req = await fetch('/user', {
		headers: { Authorization: 'Bearer ' + token }
	});

	console.log(req.status);

	if (req.status !== 200) redirect(302, '/login');

	const account = (await req.json()) as IUser;

	return {
		account
	};
};
