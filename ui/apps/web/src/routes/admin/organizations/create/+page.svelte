<script lang="ts">
	import { AAlert, AButton, AInput, ASelect } from 'ui';
	import AdminLayout from '../../AdminLayout.svelte';

	let { data, form } = $props();
</script>

{#snippet header()}
	<h2 class="text-xl font-bold">New Organization</h2>
{/snippet}

<AdminLayout title="New Organization" {header} backHref="/admin/organizations">
	{#if form?.message}
		<div class="space-y-1">
			<AAlert title={form.message} type="error" />
		</div>
	{/if}
	<form method="post" class="grid gap-6">
		<AInput
			name="name"
			required
			label="Name"
			hint="The full name of the organization"
			placeholder="Name"
		/>
		<AInput
			name="address"
			required
			label="Address"
			hint="Address of the organization"
			placeholder="Address"
		/>
		<AInput name="city" required placeholder="City" />
		<ASelect
			required
			label="State"
			disabled
			value="Texas"
			options={[{ text: 'Texas', value: 'Texas' }]}
		/>
		<input type="hidden" name="state" value="Texas" />
		<AInput name="zip" required label="ZIP" placeholder="ZIP" />
		<AInput
			type="tel"
			name="phone"
			required
			label="Phone"
			placeholder="Phone"
			hint="Phone"
			maxlength={10}
		/>
		<AInput
			type="tel"
			name="fax"
			required
			label="Fax"
			placeholder="Fax"
			hint="Fax or secondary phone"
		/>
		<AInput
			name="email"
			type="email"
			required
			label="Email"
			placeholder="Email"
			hint="Main email of the organization"
		/>
		<AInput type="url" name="website" label="Website" placeholder="Website" hint="Website" />
		<ASelect
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
</AdminLayout>
