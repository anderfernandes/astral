export const load = async ({ url, fetch }) => {
	const req = await fetch('/verify?token=' + url.searchParams.get('token'));

	if (req.status > 299) {
		console.log(req.status, await req.json());
		return {};
	}

	console.log(req.status);

	return {};
};
