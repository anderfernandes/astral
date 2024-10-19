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
		class="form-checkbox h-4 w-4 rounded border-gray-300 border-primary bg-background text-primary ring-offset-background checked:border-primary checked:hover:border-primary focus:ring-1 focus:ring-background dark:text-background"
	/>
	<div class="space-y-1 leading-none">
		<label
			class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
			for={name}>{label}</label
		>
		<p id=":r13:-form-item-description" class="text-sm text-muted-foreground">
			{hint}
		</p>
	</div>
</div>
