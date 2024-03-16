import { fail } from '@sveltejs/kit';

export const actions = {
	default: async ({ request, fetch }) => {
		const req = await fetch('/forgot', {
			method: 'POST',
			body: await request.formData()
		});

		console.log(req.status);

		const res: IResponseWithValidationErrors = await req.json();

		if (req.status === 200) return { success: true };

		console.log(res);

		const { errors, message } = res;

		if (req.status === 422) return fail(req.status, { errors, message });

		if (req.status === 404) return fail(req.status, { success: true });

		fail(req.status, {
			title: `Error ${req.status}`,
			message: 'Please try again in a few minutes.'
		});
	}
};
