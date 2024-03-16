<script lang="ts">
	import type { Snippet } from 'svelte';
	import type { HTMLInputAttributes, HTMLLabelAttributes } from 'svelte/elements';

	let {
		label,
		required,
		hint,
		errors = [],
		children,
		htmlFor
	} = $props<{
		label?: string;
		required?: HTMLInputAttributes['required'];
		hint?: string;
		errors?: string[];
		htmlFor?: HTMLLabelAttributes['for'];
		children: Snippet;
	}>();
</script>

<div class:space-y-2={label}>
	<label
		class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
		for={htmlFor}
		>{label}
		{#if required}<span class="text-red-500">*</span>{/if}
	</label>
	{@render children()}
	{#if errors.length === 0}
		<span class="text-sm text-zinc-500 dark:text-zinc-400">
			{hint}
		</span>
	{:else}
		<span class="text-sm text-red-500">
			{errors[0]}
		</span>
	{/if}
</div>
