<script lang="ts">
	import { addHours } from 'date-fns';
	import { AButton, ACheckbox, ADateTimePicker, ASelect, ASlider, ATextArea } from 'ui';

	let { data } = $props();
	let { event_types, event, shows, organization } = data;

	let start = $state<Date>(new Date(event.start));
	let end = $state(new Date(event.end));
</script>

<section class="space-y-6 p-6 lg:mx-96">
	<div class="space-y-1">
		<h2 class="text-2xl font-semibold tracking-tight">
			Edit Event #{event.id}
		</h2>
		<p class="text-sm text-muted-foreground">Changes take effect upon clicking save.</p>
	</div>

	<hr />

	<form class="space-y-8" method="POST">
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
			<AButton text="Save" />
		</div>
	</form>
</section>
