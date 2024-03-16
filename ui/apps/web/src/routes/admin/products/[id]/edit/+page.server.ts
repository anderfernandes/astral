import { fail, redirect } from '@sveltejs/kit';

export const actions = {
	default: async ({ params, request, fetch }) => {
		const data = await request.formData();
		data.append('_method', 'PUT');
		console.log(data);

		const req = await fetch(`/products/${params.id}`, {
			method: 'POST',
			body: data
		});

		if (req.status > 299) {
			console.log(req.status, await req.json());
			return fail(req.status, { message: 'An error has occurred.' });
		}

		redirect(301, `/admin/products/${params.id}`);
	}
};
