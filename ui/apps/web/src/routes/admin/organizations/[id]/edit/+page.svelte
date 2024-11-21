<script lang="ts">
	import { applyAction, enhance } from '$app/forms';
	import { AAlert, AButton, AInput, ASelect } from 'ui';

	const { data, form } = $props();
	const { organization, organization_types } = data;
	let loading = $state(false);
</script>

<svelte:head>
	<title>Edit Organization #{organization.id} | Astral</title>
</svelte:head>

<header
	class="sticky top-0 -mx-6 flex h-16 items-center gap-3 bg-background/50 px-6 font-semibold backdrop-blur"
>
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
	<h2 class="grow">Edit Organization #{organization.id}</h2>
</header>

{#if form?.message}
	<div class="mt-24">
		<AAlert title={form.message} type="error" />
	</div>
{/if}

<form
	method="post"
	class="grid gap-6 lg:w-[calc(100%-20rem)]"
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
	<AInput label="City" value={organization.city} name="city" required placeholder="City" />
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
		<AButton text="Save" {loading} />
	</div>
</form>
