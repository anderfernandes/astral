import { fail, redirect } from '@sveltejs/kit';

export const actions = {
	default: async ({ request, fetch }) => {
		const form = await request.formData();

		const req = await fetch('/users', {
			method: 'POST',
			body: form
		});

		if (req.status > 299) {
			const res = await req.json();
			console.log(res);
			return fail(req.status, { message: 'An error occurred.' });
		}

		const { data } = await req.json();

		redirect(302, `/admin/users/${data}`);
	}
};
