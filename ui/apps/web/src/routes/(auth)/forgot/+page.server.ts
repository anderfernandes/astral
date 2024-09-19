export const actions = {
	default: async ({ request, fetch }) => {
		const data = await request.formData();

		const req = await fetch('/forgot', { method: 'POST', body: data });

		console.log(req.status, await req.json());
	}
};
