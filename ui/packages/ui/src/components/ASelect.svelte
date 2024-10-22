<script lang="ts">
	import type { HTMLSelectAttributes } from 'svelte/elements';

	interface IASelectOption {
		text: string;
		value: string | number;
	}
	interface IAstralDataBasicProps {
		id: number;
		name: string;
	}

	interface IASelectProps
		extends Pick<
			HTMLSelectAttributes,
			'name' | 'disabled' | 'required' | 'value' | 'onchange' | 'placeholder'
		> {
		label?: string;
		hint?: string;
		options: IASelectOption[] | Partial<IAstralDataBasicProps>[];
		errors?: string[];
	}

	let {
		options,
		label,
		hint,
		name,
		disabled,
		required,
		errors = [],
		value = $bindable(),
		onchange,
		placeholder
	}: IASelectProps = $props();
</script>

<div class="grid gap-2">
	{#if label}
		<label
			class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
			for={name}
		>
			{label}
			{#if required}
				<span class="text-red-500">*</span>
			{/if}
		</label>
	{/if}
	<select
		{onchange}
		{name}
		id={name}
		{disabled}
		{required}
		bind:value
		class=" form-select line-clamp-1 flex h-9 w-full items-center justify-between whitespace-nowrap rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-sm ring-offset-background placeholder:text-muted-foreground focus:border-primary-foreground focus:outline-none focus:ring-1 focus:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
	>
		<option disabled selected>{placeholder || 'Select one'}</option>
		{#each options as option}
			<option value={(option as IAstralDataBasicProps).id || (option as IASelectOption).value}
				>{(option as IAstralDataBasicProps).name || (option as IASelectOption).text}</option
			>
		{/each}
	</select>
	{#if errors.length > 0}
		<span class="text-[0.8rem] text-red-500">
			{hint}
		</span>
	{:else if hint}
		<span class="text-sm text-muted-foreground">
			{hint}
		</span>
	{/if}
</div>
