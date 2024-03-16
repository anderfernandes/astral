import { fail } from '@sveltejs/kit';

export const actions = {
	default: async ({ request, fetch }) => {
		const req = await fetch('/register', {
			method: 'POST',
			body: await request.formData()
		});

		console.log(req.status);

		if (req.status === 201) return { success: true };

		const res: IResponseWithValidationErrors = await req.json();

		console.log(res);

		if (req.status === 422) return fail(req.status, res);

		return { success: false };
	}
};
