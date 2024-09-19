import { redirect } from '@sveltejs/kit';

export const actions = {
	default: async ({ request, fetch }) => {
		const data = await request.formData();

		const req = await fetch('/register', {
			method: 'POST',
			body: data
		});

		if (req.status === 200) redirect(302, '/login');
		else if (req.status === 422) {
			await req.json();
		} else {
			console.log(req.status);
		}
	}
};
