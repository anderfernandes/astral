<script lang="ts">
	let { title = 'Alert', message } = $props<{ title?: string; message: string }>();

	import AButton from './AButton.svelte';
</script>

<li
	role="status"
	aria-live="off"
	aria-atomic="true"
	data-state="open"
	data-swipe-direction="right"
	class="pointer-events-auto relative flex w-full items-center justify-between space-x-4 overflow-hidden rounded-md border border-zinc-200 bg-white p-6 pr-8 shadow-lg transition-all dark:border-zinc-700 dark:bg-black"
	style="user-select: none; touch-action: none;"
	data-radix-collection-item=""
>
	<div class="grid gap-1">
		<div class="text-sm font-semibold">{title}</div>
		<div class="text-sm opacity-90">{message}</div>
	</div>
	<AButton text="OK" basic />
	<button
		type="button"
		class="absolute right-2 top-2 rounded-md p-1 opacity-10 transition-opacity hover:opacity-100 focus:opacity-100 focus:outline-none focus:ring-2"
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
			class="h-4 w-4"
		>
			<path d="M18 6 6 18"></path>
			<path d="m6 6 12 12"></path>
		</svg>
	</button>
</li>
