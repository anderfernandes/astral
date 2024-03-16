import { error } from '@sveltejs/kit';

// TODO: redirect to the right places upon success or failure
export const load = async ({ fetch, params, url }) => {
	console.log(url.toString());

	const req = await fetch(`/verify/${params.id}/${params.hash}`);

	console.log(req.status, req.headers);

	if (req.status === 302) return {};

	console.log(await req.json());

	error(404);
};
