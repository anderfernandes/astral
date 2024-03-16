export const load = async ({ fetch, params }) => {
	const req = await fetch(`/shows/${params.id}`);

	const show: IShow = await req.json();

	console.log(show);

	return { show };
};
