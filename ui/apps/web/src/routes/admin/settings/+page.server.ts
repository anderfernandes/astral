export const actions = {
	default: async ({ fetch, request }) => {
		const req = await fetch('/settings', {
			method: 'POST',
			body: await request.formData()
		});

		console.log(req.status);

		if (req.status === 200) return { success: true };

		return { success: false };
	}
};
