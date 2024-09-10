<script lang="ts">
	import { AAlert, AButton, AInput, ASelect } from 'ui';

	let { data, form } = $props();
</script>

<svelte:head>
	<title>New Organization | Astral</title>
</svelte:head>

<div class="space-y-1 xl:w-96">
	<h2 class="text-2xl font-semibold tracking-tight">New Organization</h2>
	<p class="text-sm text-muted-foreground">Changes take effect upon clicking save.</p>
</div>

{#if form?.message}
	<AAlert title={form.message} type="error" />
{/if}

<form method="POST" class="space-y-8 lg:w-96">
	<AInput
		value={data.organization.name}
		name="name"
		required
		label="Name"
		hint="The full name of the organization"
		placeholder="Name"
	/>
	<AInput
		value={data.organization.address}
		name="address"
		required
		label="Address"
		hint="Address of the organization"
		placeholder="Address"
	/>
	<AInput value={data.organization.city} name="city" required placeholder="City" />
	<ASelect
		required
		label="State"
		disabled
		value="Texas"
		options={[{ text: 'Texas', value: 'Texas' }]}
	/>
	<AInput value={data.organization.zip} name="zip" required label="ZIP" placeholder="ZIP" />
	<AInput
		value={data.organization.phone}
		type="tel"
		name="phone"
		required
		label="Phone"
		placeholder="Phone"
		hint="Phone"
		maxlength={10}
	/>
	<AInput
		value={data.organization.fax}
		type="tel"
		name="fax"
		required
		label="Fax"
		placeholder="Fax"
		hint="Fax or secondary phone"
		maxlength={10}
	/>
	<AInput
		value={data.organization.email}
		name="email"
		type="email"
		required
		label="Email"
		placeholder="Email"
		hint="Main email of the organization"
	/>
	<AInput
		value={data.organization.website}
		type="url"
		name="website"
		label="Website"
		placeholder="Website"
		hint="Website"
	/>
	<ASelect
		value={data.organization.type_id}
		name="type_id"
		required
		label="Type"
		placeholder="Type"
		hint="Type"
		options={data.organization_types}
	/>
	<div class="flex justify-end gap-3">
		<AButton text="Reset" type="reset" variant="secondary" />
		<AButton text="Save" />
	</div>
</form>
