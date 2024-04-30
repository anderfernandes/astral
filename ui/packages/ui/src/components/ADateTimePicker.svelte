<script lang="ts">
	import { format, getHours, getYear, setMinutes } from 'date-fns';
	import AInput from './AInput.svelte';
	import AMiniCalendar from './AMiniCalendar.svelte';

	interface IDatePickerProps {
		value?: string;
		onchange?(value: Date): void;
		label?: string;
		required?: boolean;
		hint?: string;
		name?: string;
		stringFormat?: string;
		placeholder?: string;
	}

	let {
		value = $bindable(),
		onchange,
		label,
		required,
		hint,
		name,
		placeholder,
		stringFormat = 'EEE MMM d yyyy @ h:mm a'
	}: IDatePickerProps & ICommonInputProps = $props();

	/**
	 * `Date` version of `value`.
	 */
	let selected = $derived(value ? new Date(value) : undefined);

	let open = $state(false);

	const toggle = () => {
		open = !open;
	};
</script>

<div class="grid gap-4 md:relative">
	<AInput
		readonly
		value={(selected && format(selected, stringFormat)) ||
			(value && format(new Date(value), stringFormat))}
		{label}
		{hint}
		{placeholder}
		{required}
		onclick={toggle}
	/>
	<input type="hidden" {name} {required} bind:value />
	{#if open}
		<div
			class="z-10 mt-20 flex w-full flex-col items-center rounded border border-zinc-200 bg-white p-3 md:absolute md:w-80 dark:border-zinc-800 dark:bg-black"
		>
			<AMiniCalendar
				value={value ? new Date(value) : selected}
				{name}
				onchange={(date) => {
					console.log(!!selected);
					date.setHours(selected?.getHours() || 0);
					date.setMinutes(selected?.getMinutes() || 0);
					value = date.toISOString();
					if (onchange) onchange(date);
				}}
			/>
			<div class="flex w-72 justify-center">
				<input
					class="flex h-10 w-32 rounded-md border bg-transparent text-sm placeholder:text-zinc-500 focus:border-black focus:ring-black dark:placeholder:text-zinc-400"
					type="time"
					value={(selected && format(selected, 'HH:mm')) ||
						(value && format(new Date(value), 'HH:mm'))}
					oninput={(e) => {
						const [hours, minutes] = e.currentTarget.value.split(':');
						if (selected) {
							selected.setHours(parseInt(hours));
							selected.setMinutes(parseInt(minutes));
							value = selected.toISOString();
							if (onchange) onchange(selected);
						}
					}}
					onfocusout={() => {
						toggle();
					}}
				/>
			</div>
		</div>
	{/if}
</div>
