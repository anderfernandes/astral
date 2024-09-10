import {
	addDays,
	endOfDay,
	endOfMonth,
	endOfWeek,
	format,
	startOfDay,
	startOfMonth,
	startOfWeek
} from 'date-fns';

export const load = async ({ url, fetch }) => {
	const view = url.searchParams.has('view') ? url.searchParams.get('view') : 'month';

	let start: string;
	let end: string;
	let previous: { start: string; end: string };
	let next: { start: string; end: string };

	// TODO: previous and next dates need to be better calculated based on timezone

	if (view === 'day') {
		start = url.searchParams.has('start')
			? (url.searchParams.get('start') as string)
			: format(startOfDay(new Date()), 'yyyy-MM-dd');
		end = url.searchParams.has('end')
			? (url.searchParams.get('end') as string)
			: format(endOfDay(new Date()), 'yyyy-MM-dd');
		previous = {
			start: format(startOfDay(start), 'yyyy-MM-dd'),
			end: format(endOfDay(end), 'yyyy-MM-dd')
		};
		next = {
			start: format(addDays(end, 1), 'yyyy-MM-dd'),
			end: format(addDays(end, 1), 'yyyy-MM-dd')
		};
	} else if (view === 'week') {
		start = url.searchParams.has('start')
			? (url.searchParams.get('start') as string)
			: format(startOfWeek(new Date()), 'yyyy-MM-dd');
		end = url.searchParams.has('end')
			? (url.searchParams.get('end') as string)
			: format(endOfWeek(new Date()), 'yyyy-MM-dd');
		previous = {
			start: format(startOfWeek(addDays(start, -6)), 'yyyy-MM-dd'),
			end: format(endOfWeek(addDays(end, -7)), 'yyyy-MM-dd')
		};
		next = {
			start: format(startOfWeek(addDays(end, 6)), 'yyyy-MM-dd'),
			end: format(endOfWeek(addDays(end, 7)), 'yyyy-MM-dd')
		};
	} else {
		// Month
		start = url.searchParams.has('start')
			? (url.searchParams.get('start') as string)
			: format(startOfMonth(new Date()), 'yyyy-MM-dd');
		end = url.searchParams.has('end')
			? (url.searchParams.get('end') as string)
			: format(endOfMonth(new Date()), 'yyyy-MM-dd');
		previous = {
			start: format(startOfMonth(addDays(start, -1)), 'yyyy-MM-dd'),
			end: format(endOfMonth(addDays(start, -1)), 'yyyy-MM-dd')
		};
		next = {
			start: format(startOfMonth(addDays(end, 2)), 'yyyy-MM-dd'),
			end: format(endOfMonth(addDays(end, 2)), 'yyyy-MM-dd')
		};
	}

	const params = new URLSearchParams();
	params.set('start', start);
	params.set('end', end);

	const req = await fetch(`/events?${params.toString()}&calendar`);
	const { data } = (await req.json()) as { data: { date: string; events: IEvent[] }[] };
	return { events: data, view, start, end, previous, next };
};
