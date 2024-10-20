import { fail, redirect } from '@sveltejs/kit';

export const actions = {
	default: async ({ request, fetch }) => {
		const data = await request.formData();

		const req = await fetch('/register', {
			method: 'POST',
			body: data
		});

		if (req.status === 201) redirect(302, '/login');
		else if (req.status === 422) {
			return fail(req.status, await req.json());
		} else {
			console.log(req.status);
		}
	}
};
