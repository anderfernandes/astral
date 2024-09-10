import { format } from 'date-fns';

export const load = async ({ fetch }) => {
	const start = format(new Date(), 'yyyy-MM-dd');
	const [events, products] = await Promise.all([
		fetch(`/events?start=${start}&end=2024-12-31`)
			.then((res) => res.json())
			.then((res) => res.data as IEvent[]),
		fetch('/products')
			.then((res) => res.json())
			.then((res) => res.data as IProduct[])
	]);

	return { events, products };
};
