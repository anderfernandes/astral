import { fail, redirect } from '@sveltejs/kit';

export const actions = {
	default: async ({ request, fetch, params }) => {
		const data = await request.formData();

		data.append('_method', 'PUT');

		console.log(data);

		const req = await fetch(`/users/${params.id}`, {
			method: 'POST',
			body: data
		});

		if (req.status > 299) {
			// const { message }: IResponseWithValidationErrors = await req.json();
			console.log(req.status, await req.json());
			return fail(req.status, { message: 'An error has occurred.' });
		}

		redirect(302, `/admin/users/${params.id}`);
	}
};
