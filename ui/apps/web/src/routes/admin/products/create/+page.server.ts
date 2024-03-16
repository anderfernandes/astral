import { fail, redirect } from '@sveltejs/kit';

export const actions = {
	default: async ({ fetch, request }) => {
		const data = await request.formData();

		console.log(data);

		const req = await fetch('/products', {
			method: 'POST',
			body: data
		});

		if (req.status > 299) {
			console.log(req.status, await req.json());
			return fail(req.status, { message: 'An error has occurred.' });
		}

		const res: { data: number } = await req.json();

		redirect(301, `/admin/products/${res.data}`);
	}
};
