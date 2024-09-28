import { fail } from '@sveltejs/kit';

export const actions = {
	default: async ({ fetch, request, params }) => {
		const data = await request.formData();

		const req = await fetch(`/events/${params.id}/memos`, {
			method: 'POST',
			body: data
		});

		if (req.status > 299) {
			if (req.status === 500) console.log(await req.json());
			return fail(req.status, { message: 'An error has occurred' });
		}

		return { success: true };
	}
};
