import { fail, redirect } from '@sveltejs/kit';

export const actions = {
	default: async ({ request, fetch }) => {
		const data = await request.formData();

		console.log(data);

		const req = await fetch('/users', {
			method: 'POST',
			body: data
		});

		if (req.status > 299) {
			const res = await req.json();
			console.log(res);
			return fail(req.status, { message: 'An error occurred.' });
		}

		redirect(301, '/admin/users');
	}
};
