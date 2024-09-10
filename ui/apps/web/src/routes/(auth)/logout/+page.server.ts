import { NODE_ENV } from '$env/static/private';
import { redirect } from '@sveltejs/kit';

export const actions = {
	default: async ({ cookies, fetch, url }) => {
		cookies.delete('astral_token', {
			path: '/',
			domain: url.hostname,
			secure: NODE_ENV === 'production',
			httpOnly: true
		});

		await fetch('/logout', { method: 'POST' });

		// console.log('/logout', res.status);

		// console.log(cookies.getAll());

		redirect(302, '/');
	}
};
