<script lang="ts">
	import type { HTMLSelectAttributes } from 'svelte/elements';
	import AInputLabel from './AInputLabel.svelte';

	interface IASelectProps
		extends Pick<
			HTMLSelectAttributes,
			'required' | 'placeholder' | 'name' | 'value' | 'onchange' | 'disabled'
		> {
		options: { id: number; name: string }[] | string[];
	}

	let {
		label,
		required,
		hint,
		errors,
		placeholder,
		disabled,
		options = [],
		name,
		value,
		onchange
	}: IASelectProps & ICommonInputProps = $props();
</script>

<AInputLabel {label} {required} {hint} {errors}>
	<select
		{disabled}
		{required}
		{placeholder}
		{name}
		{onchange}
		bind:value
		class="flex h-10 w-full rounded-md border border-zinc-300 bg-transparent text-sm placeholder:text-zinc-500 focus:border-black focus:ring-black focus:ring-offset-black disabled:cursor-not-allowed disabled:bg-zinc-100 dark:border-zinc-800 dark:placeholder:text-zinc-400 dark:focus:border-zinc-600 dark:disabled:bg-zinc-800"
	>
		<option value="">{placeholder || 'Select one'}</option>
		{#each options as option}
			<option value={typeof option === 'string' ? option : option.id}>
				{typeof option === 'string' ? option : option.name}
			</option>
		{/each}
	</select>
</AInputLabel>
