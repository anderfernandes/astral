<script lang="ts">
	import {
		startOfDay,
		format,
		addDays,
		startOfWeek,
		endOfWeek,
		startOfISOWeek,
		endOfISOWeek,
		endOfDay,
		lastDayOfWeek
	} from 'date-fns';
	import AButton from './AButton.svelte';
	import { arrow_left_thick, arrow_right_thick, calendar_today } from '../lib/icons';
	import ACalendarWeekView from './ACalendarWeekView.svelte';

	const { selected = startOfDay(new Date()), url, create, events } = $props<IACalendarProps>();

	let previous = $derived({
		start: format(startOfWeek(addDays(selected, -7)), 'yyyy-MM-dd'),
		end: format(endOfWeek(addDays(selected, -7)), 'yyyy-MM-dd')
	});

	let next = $derived({
		start: format(startOfWeek(addDays(selected, 7)), 'yyyy-MM-dd'),
		end: format(endOfWeek(addDays(selected, 7)), 'yyyy-MM-dd')
	});
</script>

<div class="mb-3 grid grid-cols-2 gap-3">
	<div class="flex items-center gap-2">
		<!-- <AIcon name="calendar-month-outline" on:click={toggleModal} /> -->
		<h1 class="hidden md:block">{format(selected, 'MMMM yyyy')}</h1>
		<h2 class="block md:hidden">{format(selected, 'MMM yyyy')}</h2>
	</div>
	<div class="flex justify-end gap-2">
		{#if create}
			<AButton text="New Event" href="/admin/events/create" />
		{/if}
		<AButton
			icon={arrow_left_thick}
			href={`/admin/calendar?start=${previous.start}&end=${previous.end}`}
		/>
		<AButton icon={calendar_today} basic href="/admin/calendar" />
		<AButton
			icon={arrow_right_thick}
			href={`/admin/calendar?start=${next.start}&end=${next.end}`}
		/>
	</div>
</div>

<section class="flex flex-col overflow-hidden overflow-y-auto" style="height: calc(100vh - 15rem)">
	<ACalendarWeekView {selected} {events} {url} />
</section>
