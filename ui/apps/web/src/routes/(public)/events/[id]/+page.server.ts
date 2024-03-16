export const load = async ({ fetch, params }) => {
	const req = await fetch(`/events/${params.id}`);

	const res: IEvent = await req.json();

	console.log(res);

	return { event: res };
};
