import { redirect } from '@sveltejs/kit';

export const load = async ({ cookies }) => {
	const token = cookies.get('astral_token');

	if (!token || token.length === 0) redirect(303, '/login');
};
