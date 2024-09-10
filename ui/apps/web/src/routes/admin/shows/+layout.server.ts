export const load = async ({ fetch }) => {
	const [show_types] = await Promise.all([
		fetch('/show-types')
			.then((res) => res.json())
			.then(({ data }) => data as IShowType[])
	]);

	return { show_types };
};
