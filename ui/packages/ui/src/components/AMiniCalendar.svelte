<script lang="ts">
	import {
		addMonths,
		eachDayOfInterval,
		endOfMonth,
		endOfWeek,
		format,
		startOfDay,
		startOfMonth,
		startOfWeek
	} from 'date-fns';

	import chunk from 'lodash/chunk';
	import type { HTMLButtonAttributes } from 'svelte/elements';

	interface IMiniCalendarProps extends Pick<HTMLButtonAttributes, 'onclick'> {
		value?: Date;
		onchange?(d?: Date): void;
	}

	let { value = $bindable(), onclick, onchange }: IMiniCalendarProps = $props();

	let selected = $state(value || startOfDay(new Date()));

	const weeks = $derived(
		chunk(
			eachDayOfInterval({
				start: startOfWeek(startOfMonth(selected)),
				end: endOfWeek(endOfMonth(selected))
			}),
			7
		)
	);

	$effect(() => {});
</script>

{#snippet daySnippet(d: Date)}
	<td class="relative p-0 text-center text-sm focus-within:relative focus-within:z-20">
		<button
			class:text-muted-foreground={d.getMonth() !== (value || new Date()).getMonth()}
			class:selected={value && d.toDateString() === (value || new Date()).toDateString()}
			class:bg-accent={new Date().toDateString() === d.toDateString()}
			class="inline-flex h-8 w-8 items-center justify-center whitespace-nowrap rounded-md p-0 text-sm font-normal transition-colors hover:bg-accent hover:text-accent-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 aria-selected:opacity-100"
			role="gridcell"
			tabindex="-1"
			type="button"
			onclick={(e) => {
				value = d;
				//console.log(d);
				if (onclick) onclick(e);
				if (onchange) onchange(value);
			}}
		>
			{d.getDate()}
		</button>
	</td>
{/snippet}

<div class="flex flex-col space-y-4 bg-background sm:flex-row sm:space-x-4 sm:space-y-0">
	<div class="rdp-caption_start rdp-caption_end space-y-4">
		<div class="relative flex items-center justify-center pt-1">
			<div class="text-sm font-medium" aria-live="polite" id="react-day-picker-9">
				{format(selected || new Date(), 'MMMM yyyy')}
			</div>
			<div class="flex items-center space-x-1">
				<button
					onclick={() => {
						selected = addMonths(selected, -1);
					}}
					name="previous-month"
					aria-label="Go to previous month"
					class="rdp-button_reset rdp-button absolute left-1 inline-flex h-7 w-7 items-center justify-center whitespace-nowrap rounded-md border border-input bg-transparent p-0 text-sm font-medium opacity-50 shadow-sm transition-colors hover:bg-accent hover:text-accent-foreground hover:opacity-100 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50"
					type="button"
					><svg
						width="15"
						height="15"
						viewBox="0 0 15 15"
						fill="none"
						xmlns="http://www.w3.org/2000/svg"
						class="h-4 w-4"
						><path
							d="M8.84182 3.13514C9.04327 3.32401 9.05348 3.64042 8.86462 3.84188L5.43521 7.49991L8.86462 11.1579C9.05348 11.3594 9.04327 11.6758 8.84182 11.8647C8.64036 12.0535 8.32394 12.0433 8.13508 11.8419L4.38508 7.84188C4.20477 7.64955 4.20477 7.35027 4.38508 7.15794L8.13508 3.15794C8.32394 2.95648 8.64036 2.94628 8.84182 3.13514Z"
							fill="currentColor"
							fill-rule="evenodd"
							clip-rule="evenodd"
						></path></svg
					>
				</button>
				<button
					onclick={() => {
						selected = addMonths(selected, 1);
					}}
					name="next-month"
					aria-label="Go to next month"
					class="rdp-button_reset rdp-button absolute right-1 inline-flex h-7 w-7 items-center justify-center whitespace-nowrap rounded-md border border-input bg-transparent p-0 text-sm font-medium opacity-50 shadow-sm transition-colors hover:bg-accent hover:text-accent-foreground hover:opacity-100 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50"
					type="button"
					><svg
						width="15"
						height="15"
						viewBox="0 0 15 15"
						fill="none"
						xmlns="http://www.w3.org/2000/svg"
						class="h-4 w-4"
						><path
							d="M6.1584 3.13508C6.35985 2.94621 6.67627 2.95642 6.86514 3.15788L10.6151 7.15788C10.7954 7.3502 10.7954 7.64949 10.6151 7.84182L6.86514 11.8418C6.67627 12.0433 6.35985 12.0535 6.1584 11.8646C5.95694 11.6757 5.94673 11.3593 6.1356 11.1579L9.565 7.49985L6.1356 3.84182C5.94673 3.64036 5.95694 3.32394 6.1584 3.13508Z"
							fill="currentColor"
							fill-rule="evenodd"
							clip-rule="evenodd"
						></path></svg
					></button
				>
			</div>
		</div>
		<table class="w-full border-collapse space-y-1" role="grid">
			<thead class="rdp-head">
				<tr class="flex">
					<th
						scope="col"
						class="w-8 rounded-md text-[0.8rem] font-normal text-muted-foreground"
						aria-label="Sunday"
					>
						Su
					</th>
					<th
						scope="col"
						class="w-8 rounded-md text-[0.8rem] font-normal text-muted-foreground"
						aria-label="Monday"
					>
						Mo
					</th>
					<th
						scope="col"
						class="w-8 rounded-md text-[0.8rem] font-normal text-muted-foreground"
						aria-label="Tuesday"
					>
						Tu
					</th>
					<th
						scope="col"
						class="w-8 rounded-md text-[0.8rem] font-normal text-muted-foreground"
						aria-label="Wednesday"
					>
						We
					</th>
					<th
						scope="col"
						class="w-8 rounded-md text-[0.8rem] font-normal text-muted-foreground"
						aria-label="Thursday"
					>
						Th
					</th>
					<th
						scope="col"
						class="w-8 rounded-md text-[0.8rem] font-normal text-muted-foreground"
						aria-label="Friday"
					>
						Fr
					</th>
					<th
						scope="col"
						class="w-8 rounded-md text-[0.8rem] font-normal text-muted-foreground"
						aria-label="Saturday"
					>
						Sa
					</th>
				</tr>
			</thead>
			<tbody class="rdp-tbody">
				{#each weeks as week}
					<tr class="mt-2 flex w-full">
						{#each week as day}
							{@render daySnippet(day)}
						{/each}
					</tr>
				{/each}
			</tbody>
		</table>
	</div>
</div>

<style lang="postcss">
	.selected {
		@apply inline-flex h-8 w-8 items-center justify-center whitespace-nowrap rounded-md bg-primary p-0 text-sm font-normal text-primary-foreground transition-colors hover:bg-primary hover:text-primary-foreground focus:bg-primary focus:text-primary-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50;
	}
</style>
