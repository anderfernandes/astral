<script lang="ts">
	import { page } from '$app/stores';
	import { addHours, endOfDay, endOfWeek, startOfDay, startOfISOWeek, startOfWeek } from 'date-fns';
	import { ACalendar } from 'ui';

	let { data } = $props();

	let { organization } = data;

	let selected = $derived(
		$page.url.searchParams.has('start')
			? addHours(
					new Date($page.url.searchParams.get('start') as string),
					new Date().getTimezoneOffset() / 60
				)
			: startOfDay(new Date())
	);

	let events = $derived(data.events);
</script>

<svelte:head>
	<title>Calendar | Astral &middot; {organization.name}</title>
</svelte:head>

<ACalendar {events} create="/admin/events/create" {selected} />
