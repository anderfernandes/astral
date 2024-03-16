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

	let { event_types, shows, organization } = data;

	let is_all_day = $state(false);

	let loading = $state(false);

	let end = $state('');
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
			name="0[is_all_day]"
			bind:checked={is_all_day}
			label="All Day"
			hint="Check if this is an all day event."
		/>
		<ASelect
			name="0[type_id]"
			label="Event Type"
			required
			hint="The type of event this is going to be."
			options={event_types}
		/>
		<ACheckbox
			name="0[is_public]"
			checked={true}
			label="Public"
			hint="Check if this event should be available to the general public to attend."
		/>
		{#if is_all_day}
			<AInput
				name="[0]title"
				label="Title"
				placeholder="Title"
				required
				hint="The title of the all day calendar entry."
			/>
			<ADatePicker
				name="[0]date"
				label="Date"
				placeholder="Date"
				required
				hint="The date of this all day calendar entry."
			/>
		{:else}
			<ASelect
				name="0[show_id]"
				options={shows}
				label="Show"
				hint="The show for this event."
				required
			/>
			<ADateTimePicker
				name="0[start]"
				label="Start"
				placeholder="Start"
				required
				hint="The start date and time of the event."
				onchange={(date: Date) => {
					end = addHours(date, 1).toISOString()
				}}
			/>
			<ADateTimePicker
				name="0[end]"
				label="End"
				placeholder="End"
				required
				hint="The end date and time of the event."
				bind:value={end}
			/>
		{/if}
		<ASlider
			name="0[seats]"
			label="Seats"
			hint="The number of seats available for this event."
			required
			min={1}
			max={organization.seats}
			value={organization.seats}
		/>
		<ATextarea
			name="0[memo]"
			label="Memo"
			required
			placeholder="Memo"
			hint="Explain why you are creating this event."
		/>
		<AButton text="Submit" type="submit" />
	</form>
</section>
