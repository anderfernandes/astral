<script lang="ts">
	import { enhance } from '$app/forms';
	import { AAlert, AButton, AInput, ASelect } from 'ui';

	let { data, form } = $props();
	const { organization, organization_types } = data;
</script>

<svelte:head>
	<title>New Organization | Astral</title>
</svelte:head>

<header
	class="fixed left-0 top-0 flex w-full flex-col bg-background/95 px-5 backdrop-blur supports-[backdrop-filter]:bg-background/60 lg:left-[inherit] lg:-mx-6 lg:w-[calc(1080px-288px)]"
>
	<div class="flex h-16 items-center gap-3">
		<a href={`/admin/organizations/${organization.id}`} aria-label="back">
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
		<h3 class="font-semibold leading-none tracking-tight">Edit Organization #{organization.id}</h3>
	</div>
</header>

<div class="mt-24">
	{#if form?.message}
		<AAlert title={form.message} type="error" />
	{/if}
</div>

<form method="POST" class="grid gap-6" use:enhance>
	<AInput
		value={organization.name}
		name="name"
		required
		label="Name"
		hint="The full name of the organization"
		placeholder="Name"
	/>
	<AInput
		value={organization.address}
		name="address"
		required
		label="Address"
		hint="Address of the organization"
		placeholder="Address"
	/>
	<AInput value={organization.city} name="city" required placeholder="City" />
	<ASelect
		required
		label="State"
		disabled
		value="Texas"
		options={[{ text: 'Texas', value: 'Texas' }]}
	/>
	<AInput value={organization.zip} name="zip" required label="ZIP" placeholder="ZIP" />
	<AInput
		value={organization.phone}
		type="tel"
		name="phone"
		required
		label="Phone"
		placeholder="Phone"
		hint="Phone"
		maxlength={10}
	/>
	<AInput
		value={organization.fax}
		type="tel"
		name="fax"
		label="Fax"
		placeholder="Fax"
		hint="Fax or secondary phone"
		maxlength={10}
	/>
	<AInput
		value={organization.email}
		name="email"
		type="email"
		required
		label="Email"
		placeholder="Email"
		hint="Main email of the organization"
	/>
	<AInput
		value={organization.website}
		type="url"
		name="website"
		label="Website"
		placeholder="Website"
		hint="Website"
	/>
	<ASelect
		value={organization.type_id}
		name="type_id"
		required
		label="Type"
		placeholder="Type"
		hint="Type"
		options={organization_types}
	/>
	<div class="flex justify-end gap-3">
		<AButton text="Reset" type="reset" variant="secondary" />
		<AButton text="Save" />
	</div>
</form>
