<script>
	import { AButton, ACheckbox, AInput } from 'ui';

	let { data } = $props();
</script>

<svelte:head>
	<title>Settings - Astral Admin</title>
</svelte:head>

<br />

<form method="POST" class="grid gap-3">
	<div class="grid lg:grid-cols-4 lg:gap-3">
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
		<div class="col-span-1">
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
		<div class="col-span-1">
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
		<AButton type="submit" text="Submit" />
	</div>
</form>
