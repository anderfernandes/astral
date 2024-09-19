export const load = async ({ url, fetch }) => {
	const req = await fetch('/verify?token=' + url.searchParams.get('token'));

	if (req.status === 500) console.log(req.status, await req.json());

	console.log(req.status);

	return {};
};
