<script lang="ts">
	import {
		eachDayOfInterval,
		endOfISOWeek,
		endOfWeek,
		format,
		startOfDay,
		startOfISOWeek,
		startOfWeek
	} from 'date-fns';

	let { selected = new Date(), url, events } = $props<IACalendarProps>();

	// const start = $derived(startOfWeek(selected))
	// const end = $derived(endOfWeek(selected))

	const days = $derived(
		eachDayOfInterval({
			start: startOfWeek(selected),
			end: endOfWeek(selected)
		})
	);
</script>

<div class="grid grid-cols-7 gap-1">
	{#each days as day}
		{@const allDayEvents = events.filter(
			(e) => e.is_all_day && startOfDay(new Date(e.start)).toDateString() === day.toDateString()
		)}
		<div
			class="grid gap-1"
			class:today={startOfDay(new Date()).toDateString() === day.toDateString()}
		>
			<div
				class="rounded p-1 text-center text-sm font-semibold"
				class:font-bold={startOfDay(new Date()).toDateString() === day.toDateString()}
			>
				<span class="block md:hidden">
					{format(day, 'EEE')}<br />{day.getDate()}
				</span>
				<span class="hidden md:block">
					{format(day, 'EEE d')}
				</span>
			</div>

			<div class="grid h-8 auto-cols-auto grid-flow-col gap-2 border border-zinc-300">
				{#each allDayEvents as allDayEvent}
					<p class="flex items-center justify-center rounded text-xs">
						{allDayEvent.title}
					</p>
				{/each}
			</div>
		</div>
	{/each}
	{#each events as event}
		{@const start = new Date(event.start)}
		<a
			href={`/admin/events/${event.id}`}
			class="col-span-1 h-10 rounded bg-black p-1 text-xs text-white dark:bg-white dark:text-black"
			style={`grid-column-start:${start.getDay() + 1}`}
		>
			<span
				>{format(start, start.getMinutes() > 0 ? 'h:mmaaaa' : `haaaaa`)} - Event #{event.id}</span
			>
		</a>
	{/each}
</div>

<style lang="postcss">
	.today {
		@apply rounded bg-zinc-100 dark:bg-zinc-700;
	}
</style>
