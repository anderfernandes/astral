import { fail } from '@sveltejs/kit';

export const load = async ({ fetch }) => {
	const req = await fetch('/membership-types');

	const res: { data: IMembershipType[] } = await req.json();

	return { membership_types: res.data };
};

export const actions = {
	default: async ({ request, fetch }) => {
		const data = await request.formData();

		if (data.has('id')) data.append('_method', 'PUT');

		const req = await fetch(
			data.has('id') ? `/membership-types/${data.get('id')}` : `/membership-types`,
			{
				method: 'POST',
				body: data
			}
		);

		if (req.status > 299) {
			console.log(await req.json());
			return fail(req.status, { message: 'An error has occurred.' });
		}

		return { success: true };
	}
};
