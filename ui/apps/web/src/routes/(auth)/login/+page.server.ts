import { NODE_ENV } from '$env/static/private';
import { fail, redirect } from '@sveltejs/kit';

export const load = async ({ fetch }) => {
	const req = await fetch('/user', { headers: { 'x-forwarded-port': '4000' } });
	console.log(req.headers);
	if (req.status === 200) redirect(303, '/admin');

	// console.log('/login', token);

	// console.log('/login', req.status);

	return;
};

export const actions = {
	default: async ({ request, fetch, cookies, url }) => {
		const req = await fetch('/login', {
			method: 'POST',
			body: await request.formData()
		});

		//console.log(req.status, req.headers);

		if (req.status > 299) {
			const res: IResponseWithValidationErrors = await req.json();

			console.log(req.status, res);

			return fail(req.status, res);
		}

		const { token, path } = (await req.json()) as { token: string; path: string };

		console.log(token);

		cookies.set('astral_token', token, {
			secure: NODE_ENV === 'production',
			path: '/',
			domain: url.hostname,
			httpOnly: true
		});

		redirect(300, url.searchParams.has('redirect') ? '/cart' : path);
	}
};
