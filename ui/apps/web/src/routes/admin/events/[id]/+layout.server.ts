export const load = async ({ fetch, params }) => {
	const req = await fetch(`/events/${params.id}?with=show,event-type`);
	const event: IEvent = await req.json();

	console.log(event);

	return { event };
};
