<script lang="ts">
	import { applyAction, enhance } from '$app/forms';
	import { AAlert, AButton, AInput, ASelect } from 'ui';
	import AdminLayout from '../../../AdminLayout.svelte';

	const { data, form } = $props();
	const { organization, organization_types } = data;
	let loading = $state(false);
</script>

{#snippet header()}
	<h2 class="text-xl font-bold">Edit Organization #{organization.id}</h2>
{/snippet}

<AdminLayout
	title={`Edit Organization #${organization.id}`}
	{header}
	backHref={`/admin/organizations/${organization.id}`}
>
	{#if form?.message}
		<div class="mt-24">
			<AAlert title={form.message} type="error" />
		</div>
	{/if}

	<form
		method="post"
		class="grid gap-6"
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
</AdminLayout>
