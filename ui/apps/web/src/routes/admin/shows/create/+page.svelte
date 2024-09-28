<script lang="ts">
	import { enhance } from '$app/forms';
	import { AButton, ACheckbox, ADatePicker, AFileUpload, AInput, ASelect, ATextArea } from 'ui';

	let { data } = $props();
	let { show_types } = data;
</script>

<svelte:head>
	<title>New Show | Astral</title>
</svelte:head>

<header
	class="fixed top-0 flex w-full flex-col bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/60 lg:w-[calc(1080px-288px)]"
>
	<div class="flex h-16 items-center gap-3">
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
		<h3 class="font-semibold leading-none tracking-tight">New Show</h3>
	</div>
</header>

<article class="mt-16 grid gap-6">
	<form method="POST" class="grid gap-6" enctype="multipart/form-data" use:enhance>
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
</article>
