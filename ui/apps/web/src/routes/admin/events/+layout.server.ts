export const load = async ({ fetch }) => {
	const [event_types, shows] = await Promise.all([
		fetch('/event-types')
			.then((res) => res.json() as Promise<{ data: IEventType[] }>)
			.then((res) => res.data.map(({ id, name }) => ({ id, name }))),
		fetch('/shows')
			.then((res) => res.json() as Promise<{ data: IShow[] }>)
			.then((res) => res.data.map(({ id, name }) => ({ id, name })))
	]);

	return { event_types, shows };
};
