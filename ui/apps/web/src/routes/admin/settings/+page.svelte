<script>
	import { AButton, ACheckbox, AInput } from 'ui';

	let { data } = $props();

	let { organization } = data;
</script>

<form method="POST" class="grid gap-3">
	<AInput
		name="organization"
		value={organization.name}
		label="Organization Name"
		hint="The name of your non-profit."
		placeholder="Organization Name"
	/>
	<ACheckbox
		name="astc"
		checked={organization.astc}
		label="Member of ASTC"
		hint="Leave unchecked if not sure."
	/>
	<AInput
		name="seats"
		value={organization.seats}
		type="number"
		label="Seats"
		hint="The maximum number of seats or capacity."
		placeholder="Seats"
	/>
	<AInput
		name="address"
		value={organization.address}
		label="Address"
		hint="The physical address of your non-profit."
		placeholder="Address"
	/>
	<AInput
		name="phone"
		value={organization.phone}
		label="Phone"
		hint="A phone number people may call if they ahve questions."
		placeholder="Phone"
	/>
	<AInput
		name="fax"
		value={organization.fax}
		label="Fax"
		hint="A secondary phone number or fax"
		placeholder="Fax"
	/>
	<AInput
		name="email"
		value={organization.email}
		label="Email"
		hint="An email address customers can contact."
		placeholder="Email"
	/>
	<div>
		<AButton type="submit" text="Submit" />
	</div>
</form>
