<script lang="ts">
	import { enhance } from '$app/forms';
	import { AButton, ACheckbox, ADatePicker, AFileUpload, AInput, ASelect, ATextArea } from 'ui';

	let { data, form } = $props();
	let { show, show_types } = data;
</script>

<svelte:head>
	<title>Edit Show {show.name} &middot; Astral</title>
</svelte:head>

<header
	class="fixed top-0 flex w-full flex-col bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/60 lg:w-[1080px]"
>
	<div class="flex h-16 items-center gap-3">
		<a href={`/admin/shows/${show.id}`} aria-label="back">
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
		<h3 class="font-semibold leading-none tracking-tight">Edit Show #{show.id}</h3>
	</div>
</header>

<article class="mt-16 grid gap-6">
	<form method="POST" class="grid gap-6" enctype="multipart/form-data" use:enhance>
		<ACheckbox
			checked={show.is_active}
			name="is_active"
			label="Active"
			hint="Check to make this show an option for events."
		/>
		<div class="grid gap-3 lg:grid-cols-2">
			<AInput
				value={show.name}
				name="name"
				label="Name"
				hint="The name of the show"
				placeholder="The name of the show."
				required
			/>
			<ASelect
				value={show.type_id}
				options={show_types}
				name="type_id"
				label="Type"
				hint="The type of show"
				required
			/>
		</div>
		<div class="grid gap-3 lg:grid-cols-2">
			<AInput
				value={show.trailer_url}
				name="trailer_url"
				label="Trailer URL"
				placeholder="Trailer URL"
				hint="Link to a trailer of the show from Youtube. Paste the URL from the address bar here."
			/>
			<ADatePicker
				value={show.expiration ? new Date(show.expiration) : undefined}
				name="expiration"
				label="Expiration"
				hint="The last day you're allowed to show this show. Leave blank if none."
			/>
			<AInput
				value={show.duration}
				type="number"
				name="duration"
				label="Duration (in minutes)"
				placeholder="Duration (in minutes)"
				hint="The duration of the show in minutes"
				required
			/>
		</div>
		<ATextArea
			value={show.description}
			name="description"
			label="Description"
			placeholder="Description"
			hint="A description of the show."
			required
			errors={form?.errors.description}
		/>
		<AFileUpload
			value={show.cover}
			name="cover"
			label="Cover"
			hint="The cover of the show."
			required
		/>
		<div class="flex justify-end gap-3">
			<AButton text="Reset" type="reset" variant="secondary" />
			<AButton text="Save" />
		</div>
	</form>
	{#if form?.errors}
		<ol
			class="fixed top-0 z-[100] flex max-h-screen w-full flex-col-reverse p-4 sm:bottom-0 sm:right-0 sm:flex-col md:max-w-[420px]"
		>
			<li
				role="status"
				aria-live="off"
				aria-atomic="true"
				tabindex="-1"
				class="pointer-events-auto relative flex w-full items-center justify-between space-x-4 overflow-hidden rounded-md border border-destructive bg-destructive p-6 pr-8 text-destructive-foreground shadow-lg transition-all"
				style="user-select: none; touch-action: none;"
			>
				<div class="grid gap-1">
					<div class="text-sm font-semibold">Uh oh! Something went wrong.</div>
					<div class="text-sm opacity-90">{form.message}</div>
				</div>
				<button
					type="button"
					class="inline-flex h-8 shrink-0 items-center justify-center rounded-md border bg-transparent px-3 text-sm font-medium ring-offset-background transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:pointer-events-none disabled:opacity-50"
				>
					OK
				</button>
				<button
					type="button"
					class="absolute right-2 top-2 rounded-md p-1 text-white"
					aria-label="close"
				>
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
						class="size-4"
					>
						<path d="M18 6 6 18" />
						<path d="m6 6 12 12" />
					</svg>
				</button>
			</li>
		</ol>
	{/if}
</article>
