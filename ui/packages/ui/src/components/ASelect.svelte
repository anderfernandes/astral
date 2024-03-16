<script lang="ts">
	import type { HTMLSelectAttributes } from 'svelte/elements';
	import AInputLabel from './AInputLabel.svelte';

	let {
		label,
		required,
		hint,
		errors,
		placeholder,
		options = [],
		name,
		value,
		onchange
	} = $props<
		Pick<HTMLSelectAttributes, 'required' | 'placeholder' | 'name' | 'value' | 'onchange'> &
			ICommonInputProps & { options: { id: number; name: string }[] }
	>();
</script>

<AInputLabel {label} {required} {hint} {errors}>
	<select
		{required}
		{placeholder}
		{name}
		{onchange}
		bind:value
		class="flex h-10 w-full rounded-md border border-zinc-300 bg-transparent text-sm placeholder:text-zinc-500 focus:border-black focus:ring-black focus:ring-offset-black dark:border-zinc-800 dark:placeholder:text-zinc-400 dark:focus:border-zinc-600"
	>
		<option value="">{placeholder || 'Select one'}</option>
		{#each options as option}
			<option value={option.id}>{option.name}</option>
		{/each}
	</select>
</AInputLabel>
