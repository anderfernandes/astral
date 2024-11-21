<script lang="ts">
	import { applyAction, enhance } from '$app/forms';
	import { AButton, ACheckbox, AFileUpload, AInput } from 'ui';

	const { data } = $props();
	const { settings } = data;
	let loading = $state(false);
</script>

<svelte:head>
	<title>General Settings | Astral</title>
</svelte:head>

<form
	method="POST"
	enctype="multipart/form-data"
	class="grid gap-3 overflow-y-auto px-1 pb-6"
	use:enhance={() => {
		loading = true;
		return async ({ result, update }) => {
			console.log(result.status);
			if (result.status! >= 400) {
				loading = false;
			} else await applyAction(result);

			await update();
			loading = false;
		};
	}}
>
	<div class="grid gap-3 lg:grid-cols-4">
		<div class="col-span-2">
			<AInput
				name="organization"
				label="Organization Name"
				required
				hint="The name of your organization."
				value={data.settings?.organization.name}
				placeholder="Organization Name"
			/>
		</div>
		<div class="col-span-2 lg:col-span-4">
			<AFileUpload
				name="logo"
				value={settings.organization.logo}
				label="Logo"
				required
				hint="The logo of your organization."
			/>
		</div>
		<div class="col-span-2">
			<AInput
				name="seats"
				value={data.settings?.organization.seats}
				type="number"
				label="Seats"
				hint="Maximum number of seats or capacity."
				placeholder="Seats"
				required
			/>
		</div>
		<div class="col-span-2">
			<AInput name="tax" value={data.settings?.organization.tax} label="Sales Tax" required />
		</div>
	</div>
	<ACheckbox
		name="astc"
		checked={data.settings?.organization.astc}
		label="Member of ASTC"
		hint="Leave unchecked if not sure."
	/>
	<AInput
		name="address"
		value={data.settings?.organization.address}
		label="Address"
		hint="The physical address of your non-profit."
		placeholder="Address"
	/>
	<div class="grid lg:grid-cols-2 lg:gap-3">
		<AInput
			name="phone"
			value={data.settings?.organization.phone}
			label="Phone"
			hint="A phone number people may call if they ahve questions."
			placeholder="Phone"
		/>
		<AInput
			name="fax"
			value={data.settings?.organization.fax}
			label="Fax"
			hint="A secondary phone number or fax"
			placeholder="Fax"
		/>
	</div>
	<div class="grid lg:grid-cols-4">
		<div class="col-span-2">
			<AInput
				name="email"
				value={data.settings?.organization.email}
				label="Email"
				hint="An email address customers can contact."
				placeholder="Email"
			/>
		</div>
	</div>
	<div>
		<AButton type="submit" text="Submit" {loading} />
	</div>
</form>
