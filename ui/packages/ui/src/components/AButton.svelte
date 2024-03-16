<script lang="ts">
	import type { HTMLButtonAttributes } from 'svelte/elements';
	import ASpinner from './ASpinner.svelte';
	import AIcon from './AIcon.svelte';

	interface IAButtonProps
		extends Pick<HTMLButtonAttributes, 'type' | 'disabled' | 'onclick' | 'formaction'> {
		text?: string;
		href?: string;
		loading?: boolean;
		basic?: boolean;
		icon?: IconData;
	}

	let {
		text,
		href,
		loading = false,
		basic = false,
		type = 'button',
		disabled = false,
		onclick,
		formaction,
		icon
	} = $props<IAButtonProps>();
</script>

{#if href}
	<a {href} class="a-button" class:a-button-icon={icon && !text} class:a-button-basic={basic}>
		{#if icon}<AIcon data={icon} size={1.25} />{/if}
		{text}
	</a>
{:else}
	<button
		{onclick}
		{type}
		{formaction}
		disabled={loading || disabled}
		class="a-button"
		class:a-button-basic={basic}
		class:a-button-icon={icon && !text}
	>
		{#if loading}<ASpinner />{/if}
		{#if icon}<AIcon data={icon} size={1.25} />{/if}
		{text}
	</button>
{/if}

<style lang="postcss">
	.a-button {
		@apply inline-flex h-9 items-center justify-center whitespace-nowrap rounded-md bg-black px-4 py-2 text-sm font-medium text-white shadow transition-colors hover:bg-black/90 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-black disabled:pointer-events-none disabled:opacity-50 dark:bg-white dark:text-black dark:hover:bg-white/90;
	}

	.a-button-icon {
		@apply inline-flex h-9 items-center justify-center whitespace-nowrap rounded-md bg-black p-2 text-sm font-medium text-white shadow transition-colors hover:bg-black/90 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-black disabled:pointer-events-none disabled:opacity-50 dark:bg-white dark:text-black dark:hover:bg-white/90;
	}

	.a-button-basic {
		@apply bg-zinc-300 text-black ring-offset-zinc-300 hover:bg-zinc-300/80 focus-visible:ring-zinc-300 dark:bg-zinc-700 dark:text-white dark:ring-offset-zinc-700 dark:hover:bg-zinc-700/80;
	}
</style>
