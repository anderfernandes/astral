<script lang="ts">
	import type { HTMLInputAttributes } from 'svelte/elements';

	interface IACheckboxProps extends Pick<HTMLInputAttributes, 'checked' | 'name' | 'disabled'> {
		label?: string;
		hint?: string;
	}

	let { label, hint, checked = $bindable(), name, disabled } : IACheckboxProps = $props();
</script>

<div class="flex items-center gap-3 text-sm">
	<input
		class="border-input rounded text-black focus:ring-black dark:bg-black focus:dark:ring-white"
		type="checkbox"
		{checked}
		{name}
		{disabled}
		id={name}
	/>
	<label for={name} class="grid">
		<span class="font-medium">{label}</span>
		<span class="text-zinc-500 dark:text-zinc-400">{hint}</span>
	</label>
</div>
