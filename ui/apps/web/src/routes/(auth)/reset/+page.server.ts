import { fail, redirect } from '@sveltejs/kit';

export const load = ({ request }) => {
	console.log(request.url);
	return {};
};

export const actions = {
	default: async ({ request, fetch, url }) => {
		const data = await request.formData();

		data.append('token', url.searchParams.get('token') as string);
		data.append('email', url.searchParams.get('email') as string);

		const req = await fetch('/reset', { method: 'POST', body: data });

		if (req.status > 299) {
			console.log(req.status, console.log(await req.json()));
			return fail(req.status, {
				message: 'An error has occurred. Pleased try again in a few minutes.'
			});
		}

		redirect(303, '/login');
	}
};
