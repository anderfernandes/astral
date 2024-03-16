<script lang="ts">
	import {
		addMonths,
		eachDayOfInterval,
		endOfMonth,
		format,
		startOfDay,
		startOfMonth
	} from 'date-fns';
	import AIcon from './AIcon.svelte';
	import {
		arrow_left_thick,
		arrow_right_thick,
		chevron_double_left,
		chevron_double_right
	} from '../lib/icons';

	interface IMiniCalendarProps {
		name?: string;
		value?: Date;
		onchange?(value: Date): void;
	}

	let { value, onchange, name } = $props<IMiniCalendarProps>();

	/**
	 * State responsible for rendering calendar.
	 */
	let selected = $state(startOfDay(new Date()));

	const days = $derived(
		eachDayOfInterval({
			start: startOfMonth(selected),
			end: endOfMonth(selected)
		})
	);

	$effect(() => {
		//console.log(name, value);
	});
</script>

<div class="grid w-72 text-sm">
	<div class="flex items-center gap-2">
		<AIcon
			data={arrow_left_thick}
			size={2}
			onclick={() => {
				selected = addMonths(selected, -1);
			}}
		/>
		<AIcon
			data={chevron_double_left}
			size={2}
			onclick={() => {
				selected = addMonths(selected, -12);
			}}
		/>
		<div class="w-full grow text-center font-semibold">{format(selected, 'MMMM yyyy')}</div>
		<AIcon
			data={chevron_double_right}
			size={2}
			onclick={() => {
				selected = addMonths(selected, 12);
			}}
		/>
		<AIcon
			data={arrow_right_thick}
			size={2}
			onclick={() => {
				selected = addMonths(selected, 1);
			}}
		/>
	</div>

	<div class="grid grid-cols-7">
		<div class="flex h-4 w-4 items-center justify-center p-4">Sun</div>
		<div class="flex h-4 w-4 items-center justify-center p-4">Mon</div>
		<div class="flex h-4 w-4 items-center justify-center p-4">Tue</div>
		<div class="flex h-4 w-4 items-center justify-center p-4">Wed</div>
		<div class="flex h-4 w-4 items-center justify-center p-4">Thu</div>
		<div class="flex h-4 w-4 items-center justify-center p-4">Fri</div>
		<div class="flex h-4 w-4 items-center justify-center p-4">Sat</div>
	</div>
	<div class="grid grid-cols-7">
		{#each days as day}
			<button
				class="flex h-4 w-4 items-center justify-center rounded p-4"
				class:today={day.toDateString() === startOfDay(new Date()).toDateString()}
				class:selected={day.toDateString() === value?.toDateString()}
				style={`grid-column-start: ${day.getDate() === 1 ? day.getDay() + 1 : 'inherit'}`}
				onclick={(e) => {
					e.preventDefault();
					if (onchange) onchange(day);
					value = day;
				}}>{day.getDate()}</button
			>
		{/each}
	</div>
</div>

<style lang="postcss">
	.selected {
		@apply bg-black text-white dark:bg-white dark:text-black;
	}
	.today {
		@apply font-bold underline;
	}
</style>
