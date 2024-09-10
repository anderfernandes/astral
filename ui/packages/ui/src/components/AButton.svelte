<script lang="ts">
	import type { HTMLButtonAttributes } from 'svelte/elements';

	interface IButtonProps extends Pick<HTMLButtonAttributes, 'onclick' | 'type' | 'disabled'> {
		text: string;
		href?: string;
		variant?: 'primary' | 'secondary';
	}
	const { text, href, type, variant, onclick, disabled }: IButtonProps = $props();
</script>

{#if variant === 'secondary'}
	{#if href}
		<a
			{href}
			class="inline-flex h-9 items-center justify-center whitespace-nowrap rounded-md bg-secondary px-4 py-2 text-sm font-medium text-secondary-foreground shadow-sm transition-colors hover:bg-secondary/80 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50"
			type="submit"
		>
			{text}
		</a>
	{:else}
		<button
			{onclick}
			{disabled}
			class="inline-flex h-9 items-center justify-center whitespace-nowrap rounded-md bg-secondary px-4 py-2 text-sm font-medium text-secondary-foreground shadow-sm transition-colors hover:bg-secondary/80 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50"
			{type}
		>
			{text}
		</button>
	{/if}
{:else if href}
	<a
		{href}
		class="inline-flex h-9 items-center justify-center whitespace-nowrap rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow transition-colors hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50"
		type="submit"
	>
		{text}
	</a>
{:else}
	<button
		{onclick}
		{disabled}
		class="inline-flex h-9 items-center justify-center whitespace-nowrap rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow transition-colors hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50"
		{type}
	>
		{text}
	</button>
{/if}
