<script lang="ts">
	import { AButton, ACheckbox, ADatePicker, AFileUpload, AInput, ASelect, ATextArea } from 'ui';

	let { data } = $props();
	let { show_types } = data;
</script>

<svelte:head>
	<title>New Show | Astral</title>
</svelte:head>

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
		/>
		<ASelect options={show_types} name="type_id" label="Type" hint="The type of show" required />
		<AInput
			type="number"
			name="duration"
			label="Duration (in minutes)"
			placeholder="Duration (in minutes)"
			hint="The duration of the show in minutes"
			required
		/>
		<ATextArea
			name="description"
			label="Description"
			placeholder="Description"
			hint="A description of the show."
		/>
		<AFileUpload name="cover" label="Cover" hint="The cover of the show." required />
		<AInput
			name="trailer_url"
			label="Trailer URL"
			placeholder="Trailer URL"
			hint="Link to a trailer of the show from Youtube. Paste the URL from the address bar here."
		/>
		<ADatePicker
			name="expiration"
			label="Expiration"
			hint="The last day you're allowed to show this show. Leave blank if none."
		/>
		<ACheckbox
			checked={true}
			name="is_active"
			label="Active"
			hint="Check to make this show an option for events."
		/>
		<div class="flex justify-end gap-3">
			<AButton text="Reset" type="reset" variant="secondary" />
			<AButton text="Save" />
		</div>
	</form>
</section>
