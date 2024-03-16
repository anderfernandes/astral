import { endOfWeek, format, startOfWeek } from 'date-fns';

export const load = async ({ fetch, url }) => {
	const searchParams = new URLSearchParams(url.search);

	if (!searchParams.has('start'))
		searchParams.set('start', format(startOfWeek(new Date()), 'yyyy-MM-dd'));
	if (!searchParams.has('end'))
		searchParams.set('end', format(endOfWeek(new Date()), 'yyyy-MM-dd'));

	const req = await fetch('/events?' + searchParams.toString());
	const res: { data: IEvent[] } = await req.json();

	console.log(searchParams.toString());
	console.log(res);

	return { events: res.data };
};
