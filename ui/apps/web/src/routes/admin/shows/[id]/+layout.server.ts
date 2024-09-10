export const load = async ({ fetch, params }) => {
	const [show] = await Promise.all([
		fetch(`/shows/${params.id}`)
			.then((res) => res.json())
			.then((data) => data as IShow)
	]);

	return { show };
};
