<script lang="ts">
	import AInput from './AInput.svelte';
	import AInputLabel from './AInputLabel.svelte';
	import AMiniCalendar from './AMiniCalendar.svelte';

	interface IDatePickerProps {
		value?: string;
		onchange?(value: string): void;
		label?: string;
		required?: boolean;
		hint?: string;
		name?: string;
		placeholder?: string;
	}

	let { value, onchange, label, required, hint, name, placeholder } = $props<
		IDatePickerProps & ICommonInputProps
	>();

	let selected = $state(value ? new Date(value) : undefined);
</script>

<div class="grid gap-4">
	<AInput
		readonly
		value={selected?.toDateString()}
		{name}
		{label}
		{required}
		{hint}
		{placeholder}
	/>
	<AMiniCalendar
		value={selected}
		onchange={(date) => {
			//if (onchange) onchange(date.toDateString());
			selected = date;
		}}
	/>
</div>
