<script lang="ts">
	// TODO: GET SEATS FROM SETTINGS

	import { addHours } from 'date-fns';
	import { AAlert, AButton, ACheckbox, ADateTimePicker, ASelect, ASlider, ATextArea } from 'ui';

	let { data, form } = $props();
	let { event_types, shows } = data;

	let start = $state<Date>();
	let end = $derived(start ? addHours(start, 1) : undefined);
</script>

<svelte:head>
	<title>New Event &middot; Astral</title>
</svelte:head>

<section class="space-y-6 p-6 lg:mx-60 2xl:mx-96">
	<div class="space-y-1">
		<h2 class="text-2xl font-semibold tracking-tight">New Event</h2>
		<p class="text-sm text-muted-foreground">Fill out the form below to create a new event.</p>
	</div>

	<hr />

	{#if form?.errors}
		<AAlert type="error" title="Please fix the following errors.">
			{#each form.errors as { field, errors }}
				<span>{field}:{errors[0]}</span>
			{/each}
		</AAlert>
	{/if}

	<form class="space-y-8" method="POST">
		<!-- <ACheckbox
			label="All Day"
			name="0[is_all_day]"
			hint="Check if this is an all day event."
			disabled
		/> -->
		<ASelect
			name="0[type_id]"
			label="Type"
			hint="The type of event."
			options={event_types}
			required
		/>
		<ACheckbox
			label="Public"
			name="0[is_public]"
			hint="Check if this event is available for the general public to attend."
			checked
		/>
		<ASelect
			name="0[show_id]"
			label="Show"
			hint="The show attendees will be seeing in this event."
			options={shows}
			required
		/>
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
			<AButton text="Save" />
		</div>
	</form>
</section>
