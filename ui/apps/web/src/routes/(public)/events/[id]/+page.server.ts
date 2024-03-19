export const load = async ({ fetch, params }) => {
	const req = await fetch(`/events/${params.id}`);

	const event: IEvent = await req.json();

	return { event };
};
