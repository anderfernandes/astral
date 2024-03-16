export const load = async ({ fetch }) => {
	const req = await fetch('/show-types');
	const res: { data: IEventType[] } = await req.json();

	return { show_types: res.data };
};
