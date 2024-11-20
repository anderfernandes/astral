<script>
	import { AButton, AMiniCalendar, ASelect } from 'ui';
	import Calendar from './Calendar.svelte';
	import { goto } from '$app/navigation';
	import { format } from 'date-fns';
	import AdminLayout from '../AdminLayout.svelte';

	let { data } = $props();
	let open = $state(false);
</script>

<header class="sticky top-0 -mx-6 flex h-16 items-center gap-2 p-6 backdrop-blur">
	<ASelect
		onchange={(e) => {
			goto(`/admin/calendar?view=${e.currentTarget.value}`, { invalidateAll: true });
		}}
		options={[
			{ text: 'Day', value: 'day' },
			{ text: 'Week', value: 'week' },
			{ text: 'Month', value: 'month' }
		]}
		name="view"
		value={data.view}
	/>
	<button
		onclick={() => {
			open = !open;
		}}
		aria-label="date"
		class="inline-flex h-9 items-center justify-center whitespace-nowrap rounded-[6px] border border-input bg-background p-2 text-sm font-medium shadow-sm transition-colors hover:bg-accent hover:text-accent-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50"
	>
		<svg
			xmlns="http://www.w3.org/2000/svg"
			width="24"
			height="24"
			viewBox="0 0 24 24"
			fill="none"
			stroke="currentColor"
			stroke-width="2"
			stroke-linecap="round"
			stroke-linejoin="round"
			class="size-5"
			><path d="M8 2v4" /><path d="M16 2v4" /><rect
				width="18"
				height="18"
				x="3"
				y="4"
				rx="2"
			/><path d="M3 10h18" /><path d="M8 14h.01" /><path d="M12 14h.01" /><path
				d="M16 14h.01"
			/><path d="M8 18h.01" /><path d="M12 18h.01" /><path d="M16 18h.01" />
		</svg>
	</button>
	<a
		aria-label="previous"
		href={`/admin/calendar?view=${data.view}&start=${data.previous.start}&end=${data.previous.end}`}
		class="inline-flex h-9 items-center justify-center whitespace-nowrap rounded-md bg-primary p-2 text-sm font-medium text-primary-foreground shadow transition-colors hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50"
	>
		<svg
			xmlns="http://www.w3.org/2000/svg"
			width="24"
			height="24"
			viewBox="0 0 24 24"
			fill="none"
			stroke="currentColor"
			stroke-width="2"
			stroke-linecap="round"
			stroke-linejoin="round"
			class="size-5"
			><path d="m12 19-7-7 7-7" /><path d="M19 12H5" />
		</svg>
	</a>
	<a
		aria-label="today"
		href="/admin/calendar"
		class="inline-flex h-9 items-center justify-center whitespace-nowrap rounded-md bg-primary p-2 text-sm font-medium text-primary-foreground shadow transition-colors hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50"
	>
		<svg
			xmlns="http://www.w3.org/2000/svg"
			width="24"
			height="24"
			viewBox="0 0 24 24"
			fill="none"
			stroke="currentColor"
			stroke-width="2"
			stroke-linecap="round"
			stroke-linejoin="round"
			class="size-5"
			><path d="M8 2v4" /><path d="M16 2v4" /><rect
				width="18"
				height="18"
				x="3"
				y="4"
				rx="2"
			/><path d="M3 10h18" /><path d="m9 16 2 2 4-4" />
		</svg>
	</a>
	<a
		aria-label="next"
		href={`/admin/calendar?view=${data.view}&start=${data.next.start}&end=${data.next.end}`}
		class="inline-flex h-9 items-center justify-center whitespace-nowrap rounded-md bg-primary p-2 text-sm font-medium text-primary-foreground shadow transition-colors hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50"
	>
		<svg
			xmlns="http://www.w3.org/2000/svg"
			width="24"
			height="24"
			viewBox="0 0 24 24"
			fill="none"
			stroke="currentColor"
			stroke-width="2"
			stroke-linecap="round"
			stroke-linejoin="round"
			class="size-5"
			><path d="M5 12h14" /><path d="m12 5 7 7-7 7" />
		</svg>
	</a>
	<a
		aria-label="next"
		href="/admin/events/create"
		class="inline-flex h-9 items-center justify-center whitespace-nowrap rounded-md bg-primary p-2 text-sm font-medium text-primary-foreground shadow transition-colors hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50"
	>
		<svg class="size-5" viewBox="0 0 24 24">
			<path
				fill="currentColor"
				d="M19 19V8H5V19H19M16 1H18V3H19C20.11 3 21 3.9 21 5V19C21 20.11 20.11 21 19 21H5C3.89 21 3 20.1 3 19V5C3 3.89 3.89 3 5 3H6V1H8V3H16V1M11 9.5H13V12.5H16V14.5H13V17.5H11V14.5H8V12.5H11V9.5Z"
			/>
		</svg>
	</a>
</header>

<h2 class="grow truncate text-xl font-bold">
	{#if data.view === 'day'}
		{@const start = data.start.split('-').map((n) => parseInt(n))}
		{Intl.DateTimeFormat('en-US', { dateStyle: 'medium' }).format(
			new Date(start[0], start[1] - 1, start[2])
		)}
	{:else if data.view === 'week'}
		{@const start = data.start.split('-').map((n) => parseInt(n))}
		{@const end = data.end.split('-').map((n) => parseInt(n))}
		{Intl.DateTimeFormat('en-US', { dateStyle: 'medium' }).format(
			new Date(start[0], start[1] - 1, start[2])
		)} ~
		{Intl.DateTimeFormat('en-US', { dateStyle: 'medium' }).format(
			new Date(end[0], end[1] - 1, end[2])
		)}
	{:else}
		{Intl.DateTimeFormat('en-US', {
			month: 'short',
			year: 'numeric'
		}).format(new Date(data.end))}
	{/if}
</h2>

<Calendar data={data.events} />

{#if open}
	<div
		class="fixed left-0 z-50 flex h-screen w-screen items-center justify-center border-black/50 bg-black/50"
	>
		<div class="flex flex-col items-center justify-center gap-3 rounded-md bg-background p-3">
			<AMiniCalendar
				onchange={(d) => {
					if (d) {
						goto(
							`/admin/calendar?view=${data.view}&start=${format(d, 'yyy-MM-dd')}&end=${format(d, 'yyy-MM-dd')}`
						);
						open = !open;
					}
				}}
			/>
			<AButton
				text="Close"
				onclick={() => {
					open = !open;
				}}
			/>
		</div>
	</div>
{/if}
