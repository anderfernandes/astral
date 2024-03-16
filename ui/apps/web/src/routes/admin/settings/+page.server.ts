import { fail } from '@sveltejs/kit';

export const actions = {
	default: async ({ fetch, request }) => {
		const req = await fetch('/settings', {
			method: 'POST',
			body: await request.formData()
		});

		if (req.status === 200) return { success: true };

		const res: IResponseWithValidationErrors = await req.json();

		console.log(res);

		if (req.status === 422) return fail(req.status, res);

		return { success: false };
	}
};
