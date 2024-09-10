<script lang="ts">
	import type { Snippet } from 'svelte';

	let { children, href, active }: { children: Snippet; href: string; active: boolean } = $props();
</script>

{#if active}
	<a
		class="inline-flex h-9 items-center justify-start whitespace-nowrap rounded-md bg-primary px-3 text-sm font-medium text-primary-foreground ring-offset-background transition-colors hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 dark:bg-muted dark:text-white dark:hover:bg-muted dark:hover:text-white"
		{href}
	>
		{@render children()}
	</a>
{:else}
	<a
		class="inline-flex h-9 items-center justify-start whitespace-nowrap rounded-md px-3 text-sm font-medium ring-offset-background transition-colors hover:bg-accent hover:text-accent-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50"
		{href}
	>
		{@render children()}
	</a>
{/if}
