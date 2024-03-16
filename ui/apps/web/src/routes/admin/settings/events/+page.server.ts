import { error, fail } from '@sveltejs/kit';

export const load = async ({ fetch }) => {
	const req = await fetch('/event-types');

	const res: { data: IEventType[] } = await req.json();

	if (res) return { event_types: res.data };

	error(404);
};

export const actions = {
	default: async ({ request, fetch }) => {
		const data = await request.formData();

		if (data.has('id')) {
			data.append('_method', 'PUT');
		}

		console.log(data);

		const req = await fetch(data.has('id') ? `/event-types/${data.get('id')}` : '/event-types', {
			method: 'POST',
			body: data
		});

		if (req.status > 299) return fail(req.status, await req.json());

		return { success: true };
	}
};
