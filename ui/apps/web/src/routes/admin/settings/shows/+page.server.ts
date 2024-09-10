export const load = async ({ fetch }) => {
	const req = await fetch('/show-types');

	const res: { data: IShowType[] } = await req.json();

	console.log(res);

	return { show_types: res.data };
};
