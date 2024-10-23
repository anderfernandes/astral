<script lang="ts">
	import type { HTMLInputAttributes } from 'svelte/elements';

	interface IASliderProps
		extends Pick<HTMLInputAttributes, 'required' | 'name' | 'value' | 'min' | 'max' | 'disabled'> {
		label?: string;
		hint?: string;
	}

	let {
		label,
		hint,
		required,
		name,
		value = $bindable(),
		min = 0,
		max,
		disabled
	}: IASliderProps = $props();
</script>

<div class="space-y-2">
	<label
		class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
		for={name}
	>
		{label}
		{#if required}
			<span class="text-red-500">*</span>
		{/if}
	</label>
	<div class="flex w-full justify-center text-5xl font-bold tracking-tighter">
		{value}
	</div>
	<div class="flex items-center gap-3">
		<span>{min}</span>
		<input
			type="range"
			bind:value
			class="h-2 w-full cursor-pointer appearance-none rounded-lg bg-secondary accent-primary"
			{min}
			{max}
			{name}
			{disabled}
		/>
		<span>{max == 0 ? '' : max}</span>
	</div>
	<span class="text-[0.8rem] text-muted-foreground">
		{hint}
	</span>
</div>
