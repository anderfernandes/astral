import { fail, redirect } from '@sveltejs/kit';

export const actions = {
	default: async ({ fetch, request, params }) => {
		const data = await request.formData();
		data.append('_method', 'PUT');

		console.log(data);

		const req = await fetch(`/organizations/${params.id}`, {
			method: 'POST',
			body: data
		});

		if (req.status > 299) {
			console.log(req.status, await req.json());
			return fail(req.status, { message: 'An error ocurred.' });
		}

		redirect(301, `/admin/organizations/${params.id}`);
	}
};
