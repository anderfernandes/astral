<script lang="ts">
	import type { HTMLInputAttributes } from 'svelte/elements';
	import AInputLabel from './AInputLabel.svelte';

	let {
		label,
		required,
		hint,
		errors = [],
		placeholder,
		value,
		name,
		type,
		readonly,
		disabled,
		onclick
	} = $props<
		Pick<
			HTMLInputAttributes,
			'required' | 'placeholder' | 'value' | 'name' | 'type' | 'readonly' | 'disabled' | 'onclick'
		> &
			ICommonInputProps
	>();

	$effect(() => {
		if (errors?.length > 0)
			setTimeout(() => {
				errors = [];
			}, 10000);

		return () => {};
	});
</script>

<AInputLabel {label} {required} {hint} {errors}>
	{#if type === 'number'}
		<input
			class="flex h-10 w-full rounded-md border border-zinc-300 bg-transparent text-sm placeholder:text-zinc-500 focus:border-black focus:ring-black focus:ring-offset-black disabled:cursor-not-allowed disabled:bg-zinc-100 dark:border-zinc-800 dark:placeholder:text-zinc-400 dark:focus:border-zinc-600"
			{placeholder}
			aria-describedby={name}
			aria-invalid={errors?.length! > 0}
			bind:value
			{name}
			type="number"
			{required}
			{readonly}
			{disabled}
			{onclick}
		/>
	{:else if type === 'email'}
		<input
			class="flex h-10 w-full rounded-md border border-zinc-300 bg-transparent text-sm placeholder:text-zinc-500 focus:border-black focus:ring-black focus:ring-offset-black disabled:cursor-not-allowed disabled:bg-zinc-100 dark:border-zinc-800 dark:placeholder:text-zinc-400 dark:focus:border-zinc-600"
			{placeholder}
			aria-describedby={name}
			aria-invalid={errors?.length! > 0}
			bind:value
			{name}
			type="text"
			{required}
			{readonly}
			{disabled}
			{onclick}
		/>
	{:else if type === 'password'}
		<input
			class="flex h-10 w-full rounded-md border border-zinc-300 bg-transparent text-sm placeholder:text-zinc-500 focus:border-black focus:ring-black focus:ring-offset-black disabled:cursor-not-allowed disabled:bg-zinc-100 dark:border-zinc-800 dark:placeholder:text-zinc-400 dark:focus:border-zinc-600"
			{placeholder}
			aria-describedby={name}
			aria-invalid={errors?.length! > 0}
			bind:value
			{name}
			type="password"
			{required}
			{readonly}
			{disabled}
			{onclick}
		/>
	{:else}
		<input
			class="flex h-10 w-full rounded-md border border-zinc-300 bg-transparent text-sm placeholder:text-zinc-500 read-only:cursor-pointer focus:border-black focus:ring-black focus:ring-offset-black disabled:cursor-not-allowed disabled:bg-zinc-100 dark:border-zinc-800 dark:placeholder:text-zinc-400 dark:focus:border-zinc-600"
			{placeholder}
			aria-describedby={name}
			aria-invalid={errors?.length! > 0}
			bind:value
			{name}
			type="text"
			{required}
			{readonly}
			{disabled}
			{onclick}
		/>
	{/if}
</AInputLabel>
