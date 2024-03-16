<script lang="ts">
	import { type Snippet } from 'svelte';

	let { children, title, subtitle, onclose } = $props<{
		children: Snippet;
		title: string;
		subtitle: string;
		onclose(): void;
	}>();
</script>

<div class="fixed left-0 top-0 flex h-screen w-screen items-center justify-center bg-black/75">
	<div
		role="dialog"
		class="z-50 m-3 grid max-h-[calc(95vh)] w-full max-w-lg gap-4 overflow-y-auto rounded-lg border border-zinc-300 bg-white py-6 shadow-lg duration-200 sm:max-w-[425px] dark:border-zinc-800 dark:bg-black"
		tabindex="-1"
		style="pointer-events: auto;"
	>
		<div class="flex items-start px-6">
			<div class="flex grow flex-col space-y-1.5 text-center sm:text-left">
				{#if title}
					<h2 id="radix-:r34:" class="text-lg font-semibold leading-none tracking-tight">
						{title}
					</h2>
				{/if}
				{#if subtitle}
					<span class="text-sm text-zinc-500 dark:text-zinc-400">
						{subtitle}
					</span>
				{/if}
			</div>
			<button
				onclick={() => {
					onclose();
				}}
				type="button"
				class="cursor-pointer"
				><svg
					xmlns="http://www.w3.org/2000/svg"
					width="24"
					height="24"
					viewBox="0 0 24 24"
					fill="none"
					stroke="currentColor"
					stroke-width="2"
					stroke-linecap="round"
					stroke-linejoin="round"
					class="h-4 w-4"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg
				><span class="sr-only">Close</span></button
			>
		</div>
		<div class="grid gap-4 overflow-y-auto px-6">
			{@render children()}
		</div>
	</div>
</div>
