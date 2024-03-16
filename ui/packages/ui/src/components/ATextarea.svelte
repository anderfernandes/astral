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
	} = $props<
		BaseTextareaProps & {
			label: string;
			hint: string;
			errors?: string[];
			required?: boolean;
			value?: string;
		}
	>();
</script>

<AInputLabel {label} {hint} {errors} {required}>
	<textarea
		bind:value
		{name}
		{placeholder}
		{required}
		class="block w-full rounded-md border border-gray-300 text-sm shadow-sm focus:border-black focus:ring-black dark:focus:border-white dark:focus:ring-white"
	></textarea>
</AInputLabel>
