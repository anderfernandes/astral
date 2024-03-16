import { fail } from '@sveltejs/kit';

export const load = async ({ fetch }) => {
	const req = await fetch('/ticket-types');

	const res: { data: ITicketType[] } = await req.json();

	return { ticket_types: res.data };
};

export const actions = {
	default: async ({ request, fetch }) => {
		const data = await request.formData();

		if (data.has('id')) {
			data.append('_method', 'PUT');
		}

		console.log(data);

		const req = await fetch(data.has('id') ? `/ticket-types/${data.get('id')}` : '/ticket-types', {
			method: 'POST',
			body: data
		});

		if (req.status > 299) return fail(req.status, await req.json());

		return { success: true };
	}
};
