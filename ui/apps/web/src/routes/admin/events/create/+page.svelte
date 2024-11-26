<script lang="ts">
	import { applyAction, enhance } from '$app/forms';

	// TODO: GET SEATS FROM SETTINGS

	import { addHours } from 'date-fns';
	import { AAlert, AButton, ACheckbox, ADateTimePicker, ASelect, ASlider, ATextArea } from 'ui';

	const { data, form } = $props();
	const { event_types, shows } = data;

	let start = $state<Date>();
	let end = $derived(start ? addHours(start, 1) : undefined);
	let loading = $state(false);
</script>

<svelte:head>
	<title>New Event | Astral</title>
</svelte:head>

<h2
	class="sticky top-0 -mx-6 flex h-16 items-center gap-3 bg-background/50 px-6 text-xl font-bold backdrop-blur"
>
	<a href="/admin/calendar" aria-label="back">
		<svg
			xmlns="http://www.w3.org/2000/svg"
			width="24"
			height="24"
			viewBox="0 0 24 24"
			fill="none"
			stroke="currentColor"
			stroke-width="2"
			stroke-linecap="round"
			stroke-linejoin="round"
			class="size-6"
		>
			<path d="m12 19-7-7 7-7" />
			<path d="M19 12H5" />
		</svg>
	</a>
	New Event
</h2>

{#if form?.errors}
	<AAlert type="error" title="Please fix the following errors.">
		{#each form.errors as { field, errors }}
			<span>{field}:{errors[0]}</span>
		{/each}
	</AAlert>
{/if}
<form
	class="space-y-8 lg:w-[calc(100%-20rem)]"
	method="post"
	use:enhance={() => {
		loading = true;
		return async ({ result, update }) => {
			console.log(result.status);
			if (result.status! >= 400) {
				loading = false;
			} else await applyAction(result);
			await update();
		};
	}}
>
	<ACheckbox
		label="Public"
		name="0[is_public]"
		hint="Check if this event is available for the general public to attend."
		checked
	/>
	<div class="grid gap-3 lg:grid-cols-2">
		<ASelect
			name="0[type_id]"
			label="Type"
			hint="The type of event."
			options={event_types}
			required
		/>
		<ASelect
			name="0[show_id]"
			label="Show"
			hint="The show attendees will be seeing in this event."
			options={shows}
			required
		/>
	</div>
	<div class="grid gap-3 lg:grid-cols-2">
		<ADateTimePicker
			name="0[start]"
			label="Start"
			placeholder="Start"
			required
			hint="The start date and time of the event."
			bind:value={start}
		/>
		<ADateTimePicker
			name="0[end]"
			label="End"
			placeholder="End"
			required
			hint="The end date and time of the event."
			value={end}
		/>
	</div>
	<ASlider
		name="0[seats]"
		value={data.settings.organization.seats}
		max={data.settings.organization.seats}
		label="Seats"
		hint="The number of seats available for this event."
		required
	/>
	<ATextArea
		name="0[memo]"
		label="Memo"
		placeholder="Memo"
		hint="Explain why you are creating this event."
		required
	/>
	<div class="flex justify-end gap-3">
		<AButton text="Reset" type="reset" variant="secondary" />
		<AButton text="Save" {loading} />
	</div>
</form>
