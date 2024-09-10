import { fail, redirect } from '@sveltejs/kit';

export const actions = {
	default: async ({ request, fetch, params }) => {
		const data = await request.formData();
		console.log(data);
		const req = await fetch(`/events/${params.id}`, {
			method: 'POST',
			body: data
		});

		if (req.status > 299) {
			const { errors } = await req.json();
			console.log(req.status, errors);

			return fail(req.status, {
				message: 'An error has occurred.',
				errors,
				type_id: data.get('type_id')
			});
		}
		await req.json();

		redirect(303, `/admin/calendar`);
	}
};
