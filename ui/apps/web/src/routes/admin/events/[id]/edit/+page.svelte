<script lang="ts">
	import { addHours } from 'date-fns';
	import { AButton, ACheckbox, ADateTimePicker, ASelect, ASlider, ATextArea } from 'ui';
	import { applyAction, enhance } from '$app/forms';

	const { data } = $props();
	const { organization } = data.settings;
	const { event_types, event, shows } = data;

	let start = $state<Date>(new Date(event.start));
	let end = $state(new Date(event.end));
	let loading = $state(false);

	console.log(event);
</script>

<svelte:head>
	<title>Edit Event #{event.id} | Astral</title>
</svelte:head>

<header
	class="sticky top-0 -mx-6 flex h-16 items-center gap-3 bg-background/50 px-6 font-semibold backdrop-blur"
>
	<a href={`/admin/events/${event.id}`} aria-label="back">
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
	<h2 class="text-xl font-semibold">
		Edit Event #{event.id}
	</h2>
</header>

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
