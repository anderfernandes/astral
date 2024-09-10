<script lang="ts">
	import { AButton, ACheckbox, ADatePicker, AFileUpload, AInput, ASelect, ATextArea } from 'ui';

	let { data } = $props();
	let { show, show_types } = data;
</script>

<section class="mt-16 space-y-6 p-6 lg:mx-96">
	<div class="space-y-1">
		<h2 class="text-2xl font-semibold tracking-tight">New Show</h2>
		<p class="text-sm text-muted-foreground">Changes take effect upon clicking save.</p>
	</div>

	<hr />

	<form method="POST" class="space-y-8" enctype="multipart/form-data">
		<AInput
			name="name"
			label="Name"
			hint="The name of the show"
			placeholder="The name of the show"
			value={show.name}
		/>
		<ASelect
			options={show_types}
			name="type_id"
			label="Type"
			hint="The type of show"
			required
			value={show.type_id}
		/>
		<AInput
			type="number"
			name="duration"
			label="Duration (in minutes)"
			placeholder="Duration (in minutes)"
			hint="The duration of the show in minutes"
			required
			value={show.duration}
		/>
		<ATextArea
			name="description"
			label="Description"
			placeholder="Description"
			hint="A description of the show."
			value={show.description}
		/>
		<AFileUpload
			name="cover"
			label="Cover"
			hint="The cover of the show."
			required
			value={show.cover}
		/>
		<AInput
			name="trailer_url"
			label="Trailer URL"
			placeholder="Trailer URL"
			hint="Link to a trailer of the show from Youtube. Paste the URL from the address bar here."
			value={show.trailer_url}
		/>
		<ADatePicker
			name="expiration"
			label="Expiration"
			hint="The last day you're allowed to show this show. Leave blank if none."
			value={show.expiration ? new Date(show.expiration) : undefined}
		/>
		<ACheckbox
			checked={show.is_active}
			name="is_active"
			label="Active"
			hint="Check to make this show an option for events."
		/>
		<input type="hidden" name="_method" value="PUT" />
		<div class="flex justify-end gap-3">
			<AButton text="Reset" type="reset" variant="secondary" />
			<AButton text="Save" />
		</div>
	</form>
</section>
