<script lang="ts">
	import type { HTMLInputAttributes } from 'svelte/elements';

	interface IACheckboxProps extends Pick<HTMLInputAttributes, 'name' | 'checked' | 'disabled'> {
		label?: string;
		hint?: string;
	}

	let { label, hint, disabled, name, checked = $bindable() }: IACheckboxProps = $props();
</script>

<div class="flex flex-row items-start space-x-3 space-y-0">
	<input
		{name}
		{disabled}
		type="checkbox"
		id={name}
		{checked}
		class="form-checkbox rounded text-foreground focus:ring-ring"
	/>
	<div class="space-y-1 leading-none">
		<label
			class="cursor-pointer text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
			for={name}>{label}</label
		>
		<p id=":r13:-form-item-description" class="text-sm text-muted-foreground">
			{hint}
		</p>
	</div>
</div>
