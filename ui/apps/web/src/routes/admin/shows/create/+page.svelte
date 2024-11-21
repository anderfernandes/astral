<script lang="ts">
	import { applyAction, enhance } from '$app/forms';
	import { AButton, ACheckbox, ADatePicker, AFileUpload, AInput, ASelect, ATextArea } from 'ui';
	import AdminLayout from '../../AdminLayout.svelte';

	const { data } = $props();
	const { show_types } = data;
	let loading = $state(false);
</script>

<header
	class="sticky top-0 -mx-6 flex h-16 items-center gap-3 bg-background/50 px-6 font-semibold backdrop-blur"
>
	<a href="/admin/shows" aria-label="back">
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
	<h2 class="grow">New Show</h2>
</header>

<form
	method="post"
	class="grid gap-6 lg:w-[calc(100%-20rem)]"
	enctype="multipart/form-data"
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
		<AButton text="Save" {loading} />
	</div>
</form>
