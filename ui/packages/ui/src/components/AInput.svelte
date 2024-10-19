<script lang="ts">
	import type { HTMLInputAttributes } from 'svelte/elements';

	interface IAInputProps
		extends Pick<
			HTMLInputAttributes,
			| 'type'
			| 'id'
			| 'name'
			| 'required'
			| 'placeholder'
			| 'value'
			| 'onchange'
			| 'oninput'
			| 'onclick'
			| 'minlength'
			| 'maxlength'
			| 'disabled'
			| 'min'
			| 'readonly'
		> {
		label?: string;
		hint?: string;
		errors?: string[];
	}

	let {
		label,
		required,
		type,
		placeholder,
		id,
		name,
		hint,
		minlength,
		maxlength,
		disabled,
		min,
		readonly,
		errors = [],
		value = $bindable(),
		onchange,
		oninput,
		onclick
	}: IAInputProps = $props();
</script>

<div class="grid gap-2">
	{#if label}
		<label
			class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
			for="email"
		>
			{label}
			{#if required}
				<span class="text-red-500">*</span>
			{/if}
		</label>
	{/if}
	<input
		{type}
		class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus:border-none focus:outline-none focus:ring-1 focus:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
		class:errors={errors.length > 0}
		{id}
		{placeholder}
		{required}
		{name}
		bind:value
		{onchange}
		{oninput}
		{onclick}
		{minlength}
		{maxlength}
		{disabled}
		{min}
		{readonly}
	/>
	{#if errors.length > 0}
		<span class="text-sm text-destructive dark:text-red-200">{errors[0]}</span>
	{:else if hint}
		<span class="text-sm text-muted-foreground">{hint}</span>
	{/if}
</div>

<style lang="postcss">
	.errors {
		@apply border-destructive/10 bg-destructive/10 dark:border-destructive/40 dark:bg-destructive/10;
	}
</style>
