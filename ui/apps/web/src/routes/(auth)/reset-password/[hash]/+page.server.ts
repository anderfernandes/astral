import { fail, redirect } from '@sveltejs/kit';

export const load = async ({ params, url }) => {
	if (!url.searchParams.has('email') || !url.searchParams.get('email')?.includes('@'))
		fail(404, { data: 'Not found.' });

	return {
		email: url.searchParams.get('email'),
		token: params.hash
	};
};

export const actions = {
	default: async ({ request, fetch }) => {
		const req = await fetch('/forgot-password', {
			method: 'POST',
			body: await request.formData()
		});

		if (req.status === 200) redirect(301, '/login');

		const res: IResponseWithValidationErrors = await req.json();

		console.log(res);

		if (req.status === 422) return fail(req.status, res);

		return { success: false };
	}
};
