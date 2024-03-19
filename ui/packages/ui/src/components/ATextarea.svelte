<script lang="ts">
	import AInputLabel from './AInputLabel.svelte';

	type BaseTextareaProps = Pick<HTMLTextAreaElement, 'placeholder' | 'name'>;

	let {
		label,
		hint,
		placeholder,
		required,
		name,
		errors = [],
		value
	}: BaseTextareaProps & {
		label: string;
		hint: string;
		errors?: string[];
		required?: boolean;
		value?: string;
	} = $props();
</script>

<AInputLabel {label} {hint} {errors} {required}>
	<textarea
		bind:value
		{name}
		{placeholder}
		{required}
		class="block w-full rounded-md border border-zinc-300 text-sm shadow-sm focus:border-black focus:ring-black dark:border-zinc-800 dark:bg-black dark:focus:border-white dark:focus:ring-white"
	></textarea>
</AInputLabel>
