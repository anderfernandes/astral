<script lang="ts">
	import type { HTMLTextareaAttributes } from 'svelte/elements';

	interface IAInputProps
		extends Pick<
			HTMLTextareaAttributes,
			'id' | 'name' | 'required' | 'placeholder' | 'value' | 'onchange' | 'oninput' | 'onclick'
		> {
		label?: string;
		hint?: string;
		errors?: string[];
	}

	let {
		label,
		required,
		placeholder,
		id,
		name,
		hint,
		errors = [],
		value = $bindable(),
		onchange,
		oninput,
		onclick
	}: IAInputProps = $props();
</script>

<div class="grid gap-2">
	<label
		class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
		for="email"
	>
		{label}
		{#if required}
			<span class="text-red-500">*</span>
		{/if}
	</label>
	<textarea
		class="form-textarea flex min-h-[60px] w-full rounded-md border border-input p-4 text-sm shadow-sm placeholder:text-muted-foreground focus:border-border focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
		class:bg-transparent={errors.length === 0}
		class:bg-red-50={errors.length > 0}
		{id}
		{placeholder}
		{required}
		{name}
		bind:value
		{onchange}
		{oninput}
		{onclick}
	></textarea>
	{#if hint}
		{#if errors.length > 0}
			<span class="text-sm text-red-500">{errors[0]}</span>
		{:else}
			<span class="text-sm text-muted-foreground">{hint}</span>
		{/if}
	{/if}
</div>
