<script lang="ts">
	import type { Snippet } from 'svelte';

	let { children, href, active }: { children: Snippet; href: string; active: boolean } = $props();
</script>

{#if active}
	<a
		class="flex flex-col items-center justify-center gap-3 whitespace-nowrap rounded-md bg-primary p-3 text-sm font-medium text-primary-foreground ring-offset-background transition-colors hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 lg:inline-flex lg:h-9 lg:flex-row lg:justify-start lg:px-3"
		{href}
	>
		{@render children()}
	</a>
{:else}
	<a
		class="flex w-full flex-col items-center justify-center gap-3 whitespace-nowrap rounded-md p-3 text-sm font-medium ring-offset-background transition-colors hover:bg-accent hover:text-accent-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 lg:inline-flex lg:h-9 lg:flex-row lg:justify-start lg:px-3"
		{href}
	>
		{@render children()}
	</a>
{/if}
