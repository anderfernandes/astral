<script lang="ts">
	import { enhance } from '$app/forms';
	import { AButton, ACheckbox, ADatePicker, AFileUpload, AInput, ASelect, ATextarea } from 'ui';

	let { data } = $props();
	let { show, show_types } = data;

	let loading = $state(false);
</script>

<section class="h-[calc(100vh-7rem)] overflow-y-auto">
	<form
		method="POST"
		class="grid gap-3 px-3 md:mx-64"
		enctype="multipart/form-data"
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
		<AInput
			value={show.name}
			name="name"
			label="Name"
			placeholder="Name"
			hint="The name of the show."
			required
		/>
		<ASelect
			value={show.type_id}
			options={show_types}
			name="type_id"
			label="Type"
			hint="The type of show."
			required
		/>
		<AInput
			value={show.duration}
			type="number"
			name="duration"
			label="Duration (in minutes)"
			placeholder="Duration (in minutes)"
			hint="The duration of the show."
			required
		/>
		<ATextarea
			value={show.description}
			name="description"
			label="Description"
			required
			placeholder="Description"
			hint="A description of the show."
		/>
		<AFileUpload value={show.cover} name="cover" label="Cover" hint="The cover of the show." />
		<AInput
			value={show.trailer_url}
			name="trailer_url"
			label="Trailer URL"
			placeholder="Trailer URL"
			hint="Find a trailer for this show on Youtube, paste the its URL from the address bar here."
		/>
		<ADatePicker
			value={show.expiration}
			name="expiration"
			label="Expiration"
			hint="The last day you're allowed (by contract) to show this show. Leave blank if it can be shown indefinetely."
			placeholder="Expiration"
		/>
		<ACheckbox
			checked={show.is_active}
			name="is_active"
			label="Active"
			hint="Check to make this show available for events."
		/>
		<div>
			<AButton text="Submit" type="submit" />
		</div>
	</form>
</section>
