import { fail } from '@sveltejs/kit';

export const actions = {
	memo: async ({ request, fetch }) => {
		const data = await request.formData();

		const req = await fetch('/sales/memos', {
			method: 'POST',
			body: data
		});

		const res = await req.json();

		console.log(res);

		if (req.status > 299) {
			return fail(req.status, { message: 'Unable to save sale memo, please try again later.' });
		}

		return { success: true };
	},
	refund: async ({ fetch, params }) => {
		const req = await fetch(`/sales/${params.id}`, {
			method: 'DELETE'
		});

		console.log(req.status);

		if (req.status > 299)
			return fail(req.status, { message: 'Unable to refund sale. Please try again later.' });

		return { success: true };
	}
};
