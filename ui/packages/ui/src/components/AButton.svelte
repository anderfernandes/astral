<script lang="ts">
	import type { Snippet } from 'svelte';
	import type { HTMLButtonAttributes } from 'svelte/elements';

	interface IButtonProps extends Pick<HTMLButtonAttributes, 'onclick' | 'type' | 'disabled'> {
		text?: string;
		href?: string;
		loading?: boolean | null;
		variant?: 'primary' | 'secondary';
		children?: Snippet;
	}
	let { text, href, type, variant, onclick, disabled, children, loading }: IButtonProps = $props();
</script>

{#if variant === 'secondary'}
	{#if href}
		<a
			{href}
			class="inline-flex h-9 items-center justify-center whitespace-nowrap rounded-md bg-secondary px-4 py-2 text-sm font-medium text-secondary-foreground shadow-sm transition-colors hover:bg-secondary/80 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50"
			type="submit"
		>
			{#if children}
				{@render children()}
			{:else}
				{text}
			{/if}
		</a>
	{:else}
		<button
			{onclick}
			disabled={disabled || loading}
			class="inline-flex h-9 items-center justify-center whitespace-nowrap rounded-md bg-secondary px-4 py-2 text-sm font-medium text-secondary-foreground shadow-sm transition-colors hover:bg-secondary/80 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50"
			{type}
		>
			{#if children}
				{@render children()}
			{:else}
				{text}
			{/if}
		</button>
	{/if}
{:else if href}
	<a
		{href}
		class="inline-flex h-9 items-center justify-center whitespace-nowrap rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow transition-colors hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50"
		type="submit"
	>
		{#if children}
			{@render children()}
		{:else}
			{text}
		{/if}
	</a>
{:else}
	<button
		{onclick}
		disabled={disabled || loading}
		class="inline-flex h-9 items-center justify-center whitespace-nowrap rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow transition-colors hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50"
		{type}
	>
		{#if loading}
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
				class="animate-spin"><path d="M21 12a9 9 0 1 1-6.219-8.56" /></svg
			>
		{:else if children}
			{@render children()}
		{:else}
			{text}
		{/if}
	</button>
{/if}
