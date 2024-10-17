export const actions = {
	default: async ({ fetch, request }) => {
		const body = await request.formData();

		const req = await fetch('/settings', {
			method: 'POST',
			body
		});

		console.log(body);

		if (req.status === 200) return { success: true };

		return { success: false };
	}
};
