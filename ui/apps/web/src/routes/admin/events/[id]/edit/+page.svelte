<script lang="ts">
	import { addHours } from 'date-fns';
	import { AButton, ACheckbox, ADateTimePicker, ASelect, ASlider, ATextArea } from 'ui';
	import AdminLayout from '../../../AdminLayout.svelte';
	import { applyAction, enhance } from '$app/forms';

	const { data } = $props();
	const { organization } = data.settings;
	const { event_types, event, shows } = data;

	let start = $state<Date>(new Date(event.start));
	let end = $state(new Date(event.end));
	let loading = $state(false);
</script>

{#snippet header()}
	<h2 class="text-xl font-bold">Edit Event #{event.id}</h2>
{/snippet}

<AdminLayout title={`Edit Event #${event.id}`} {header} backHref={`/admin/events/${event.id}`}>
	<form
		class="space-y-8"
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
		<ASelect
			name="type_id"
			label="Type"
			hint="The type of event."
			options={event_types}
			required
			value={event.type_id}
		/>
		<ACheckbox
			label="Public"
			name="is_public"
			hint="Check if this event is available for the general public to attend."
			checked={event.is_public}
		/>
		<ASelect
			name="show_id"
			label="Show"
			hint="The show attendees will be seeing in this event."
			options={shows}
			required
			value={event.show_id}
		/>
		<div class="grid gap-3 lg:grid-cols-2">
			<ADateTimePicker
				name="start"
				label="Start"
				placeholder="Start"
				required
				hint="The start date and time of the event."
				bind:value={start}
				onchange={() => {
					end = addHours(start, 1);
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
		</div>
		<ASlider
			name="seats"
			value={event.seats.total}
			max={organization.seats}
			label="Seats"
			hint="The number of seats available for this event."
			required
		/>
		<ATextArea
			name="memo"
			label="Memo"
			placeholder="Memo"
			hint="Explain why you are changing this event."
			required
		/>
		<input type="hidden" name="_method" value="PUT" />
		<div class="flex justify-end gap-3">
			<AButton text="Reset" type="reset" variant="secondary" />
			<AButton text="Save" {loading} />
		</div>
	</form>
</AdminLayout>
