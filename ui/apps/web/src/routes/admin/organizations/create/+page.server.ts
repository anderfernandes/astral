import { fail, redirect } from '@sveltejs/kit';

export const actions = {
	default: async ({ fetch, request }) => {
		const data = await request.formData();

		const req = await fetch('/organizations', {
			method: 'POST',
			body: data
		});

		if (req.status > 299) {
			console.log(req.status, await req.json());
			return fail(req.status, { message: 'An error ocurred.' });
		}

		const res: { data: number } = await req.json();

		redirect(302, `/admin/organizations/${res.data}`);
	}
};
