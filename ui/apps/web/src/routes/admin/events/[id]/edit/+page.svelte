<script lang="ts">
	import { enhance } from '$app/forms';
	import { addHours } from 'date-fns';
	import {
		AButton,
		ACheckbox,
		ADatePicker,
		ADateTimePicker,
		AInput,
		ASelect,
		ASlider,
		ATextarea
	} from 'ui';

	let { data } = $props();
	let { event, organization, event_types, shows } = data;

	let loading = $state(false);
	let is_all_day = $state(event.is_all_day);
	let end = $state(event.end);
</script>

<svelte:head>
	<title>New Event | Astral &middot; {organization.name}</title>
</svelte:head>

<section class="flex h-[calc(89vh)] justify-center overflow-y-auto">
	<form
		method="POST"
		class="grid gap-3 px-3 md:w-96"
		use:enhance={() => {
			loading = true;
			return async ({ result, update }) => {
				await update();
				if (result.type === 'failure') {
					loading = false;
				}
			};
		}}
	>
		<ACheckbox
			name="is_all_day"
			bind:checked={is_all_day}
			label="All Day"
			hint="Check if this is an all day event."
		/>
		<ASelect
			name="type_id"
			value={event.type_id}
			label="Event Type"
			required
			hint="The type of event this is going to be."
			options={event_types}
		/>
		<ACheckbox
			name="is_public"
			checked={event.is_public}
			label="Public"
			hint="Check if this event should be available to the general public to attend."
		/>
		{#if is_all_day}
			<AInput
				name="title"
				label="Title"
				placeholder="Title"
				required
				hint="The title of the all day calendar entry."
			/>
			<ADatePicker
				name="date"
				label="Date"
				placeholder="Date"
				required
				hint="The date of this all day calendar entry."
			/>
		{:else}
			<ASelect
				name="show_id"
				value={event.show_id}
				options={shows}
				label="Show"
				hint="The show for this event."
				required
			/>
			<ADateTimePicker
				name="start"
				value={event.start}
				label="Start"
				placeholder="Start"
				required
				hint="The start date and time of the event."
				onchange={(date: Date) => {
					end = addHours(date, 1).toISOString()
				}}
			/>
			<ADateTimePicker
				name="end"
				label="End"
				placeholder="End"
				required
				hint="The end date and time of the event."
				bind:value={end}
			/>
		{/if}
		<ASlider
			name="seats"
			label="Seats"
			hint="The number of seats available for this event."
			required
			min={1}
			max={organization.seats}
			value={organization.seats}
		/>
		<ATextarea
			name="memo"
			label="Memo"
			required
			placeholder="Memo"
			hint="Explain why you are updating this event."
		/>
		<AButton text="Submit" type="submit" />
	</form>
</section>
