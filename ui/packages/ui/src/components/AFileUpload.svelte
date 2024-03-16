<script lang="ts">
	import type { HTMLInputAttributes, HTMLLabelAttributes } from 'svelte/elements';
	import { AButton } from '.';
	import AIcon from './AIcon.svelte';
	import { file_image_outline } from '../lib/icons';

	let {
		errors = [],
		label,
		hint,
		required,
		htmlFor,
		name,
		multiple = false,
		value
	} = $props<
		{
			label?: string;
			hint?: string;
			errors?: string[];
			htmlFor?: HTMLLabelAttributes['for'];
		} & Pick<HTMLInputAttributes, 'required' | 'name' | 'multiple' | 'value'>
	>();

	let input: HTMLInputElement;
	let preview = $state('');
</script>

<div class="grid gap-2">
	<label
		class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
		for={htmlFor}
		>{label}
		{#if required}<span class="text-red-500">*</span>{/if}
	</label>
	{#if errors.length === 0}
		<span class="text-sm text-zinc-500 dark:text-zinc-400">
			{hint}
		</span>
	{:else}
		<span class="text-sm text-red-500">
			{errors[0]}
		</span>
	{/if}
	{#if preview || value}
		<div
			style={`background-image: url(${preview || value})`}
			class="flex h-64 w-64 flex-col items-center justify-center gap-3 rounded-xl border border-zinc-300 bg-cover bg-center text-sm text-zinc-500 md:w-64 dark:border-zinc-700 dark:text-zinc-400"
		></div>
	{:else}
		<div
			class="flex h-64 w-full flex-col items-center justify-center gap-3 rounded-xl border border-zinc-300 text-sm text-zinc-500 md:w-64 dark:border-zinc-700 dark:text-zinc-400"
		>
			<AIcon data={file_image_outline} size={5} />
			<span>PNG, JPEG or JPG up to 2MB</span>
		</div>
	{/if}

	<div>
		<AButton
			text="Choose File"
			onclick={() => {
				input.click();
			}}
		/>
	</div>

	<input
		style="opacity:0.01"
		type="file"
		{name}
		{multiple}
		{required}
		bind:this={input}
		accept=".jpg, .jpeg, .png"
		onchange={(e) => {
			if (e.currentTarget.files) {
				for (const file of e.currentTarget.files) {
					preview = URL.createObjectURL(file);
				}
			}
		}}
	/>
</div>
