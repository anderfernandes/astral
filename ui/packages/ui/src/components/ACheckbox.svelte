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
		class="peer h-4 w-4 shrink-0 rounded-sm border border-primary text-primary accent-primary shadow focus:outline-none focus:ring-1 focus:ring-ring disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-primary data-[state=checked]:text-primary-foreground dark:bg-black dark:text-black"
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
