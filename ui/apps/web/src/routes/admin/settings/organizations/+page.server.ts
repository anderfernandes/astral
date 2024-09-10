import { fail } from '@sveltejs/kit';

export const load = async ({ fetch }) => {
	const req = await fetch('/organization-types');

	const res: { data: IOrganizationType[] } = await req.json();

	return { organization_types: res.data };
};

export const actions = {
	default: async ({ request, fetch }) => {
		const data = await request.formData();

		if (data.has('id')) data.append('_method', 'PUT');

		const req = await fetch(
			data.has('id') ? `/organization-types/${data.get('id')}` : `/organization-types`,
			{
				method: 'POST',
				body: data
			}
		);

		console.log(data);

		if (req.status > 299) {
			console.log(await req.json());
			return fail(req.status, { message: 'An error has occurred.' });
		}

		return { success: true };
	}
};
