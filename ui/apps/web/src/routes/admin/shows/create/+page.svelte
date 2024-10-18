<script lang="ts">
	import { enhance } from '$app/forms';
	import { AButton, ACheckbox, ADatePicker, AFileUpload, AInput, ASelect, ATextArea } from 'ui';
	import AdminLayout from '../../AdminLayout.svelte';

	let { data } = $props();
	let { show_types } = data;
</script>

{#snippet header()}
	<h2 class="text-xl font-bold">New Show</h2>
{/snippet}

<AdminLayout title="New Show" {header} backHref="/admin/shows">
	<form method="post" class="grid gap-6" enctype="multipart/form-data" use:enhance>
		<ACheckbox
			checked={true}
			name="is_active"
			label="Active"
			hint="Check to make this show an option for events."
		/>
		<div class="grid gap-3 lg:grid-cols-2">
			<AInput
				name="name"
				label="Name"
				hint="The name of the show"
				placeholder="The name of the show."
				required
			/>
			<ASelect options={show_types} name="type_id" label="Type" hint="The type of show" required />
		</div>
		<div class="grid gap-3 lg:grid-cols-2">
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
			<AInput
				type="number"
				name="duration"
				label="Duration (in minutes)"
				placeholder="Duration (in minutes)"
				hint="The duration of the show in minutes"
				required
			/>
		</div>
		<ATextArea
			name="description"
			label="Description"
			placeholder="Description"
			hint="A description of the show."
		/>
		<AFileUpload name="cover" label="Cover" hint="The cover of the show." required />
		<div class="flex justify-end gap-3">
			<AButton text="Reset" type="reset" variant="secondary" />
			<AButton text="Save" />
		</div>
	</form>
</AdminLayout>
