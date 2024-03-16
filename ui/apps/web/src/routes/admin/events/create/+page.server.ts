import { fail, redirect } from '@sveltejs/kit';

export const actions = {
	default: async ({ request, fetch }) => {
		const data = await request.formData();
		console.log(data);
		const req = await fetch('/events', {
			method: 'POST',
			body: data
		});

		if (req.status > 299) {
			console.log(req.status, await req.json());
			return fail(req.status, { message: 'An error has occurred.' });
		}

		const res: { data: number } = await req.json();

		redirect(300, `/admin/events/${res.data}`);
	}
};
