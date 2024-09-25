import { fail } from '@sveltejs/kit';

export const actions = {
	default: async ({ request, fetch }) => {
		const data = await request.formData();

		const req = await fetch('/forgot', { method: 'POST', body: data });

		if (req.status > 299) {
			if (req.status !== 500) console.log(req.status, await req.json());
			return fail(req.status, { message: 'Unable to complete your request at this moment.' });
		}

		return { success: true };
	}
};
