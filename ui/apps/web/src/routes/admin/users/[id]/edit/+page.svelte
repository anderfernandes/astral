<script>
	import { enhance } from '$app/forms';
	import { AButton, ACheckbox, AInput, ASelect } from 'ui';

	let { data } = $props();
	let { user } = data;
</script>

<div class="flex w-full justify-center">
	<form method="POST" class="grid gap-3 md:w-80" use:enhance>
		<AInput
			value={user.firstname}
			name="firstname"
			label="First Name"
			placeholder="First Name"
			hint="The first name of the user."
			required
		/>
		<AInput
			value={user.lastname}
			name="lastname"
			label="Last Name"
			placeholder="Last Name"
			hint="The last name of the user."
			required
		/>
		<AInput
			value={user.email}
			type="email"
			name="email"
			label="Email"
			placeholder="Email"
			hint="The email of the user. Must not be on record already."
			required
		/>
		<AInput
			value={user.address}
			name="address"
			label="Address"
			placeholder="Address"
			hint="The address of the user."
		/>
		<AInput
			value={user.city}
			name="city"
			label="City"
			placeholder="City"
			hint="The city of the user."
		/>
		<ASelect
			value={user.state || undefined}
			name="state"
			label="State"
			placeholder="Select one"
			options={[{ id: 'Texas', name: 'Texas' }]}
		/>
		<AInput value={user.zip} name="zip" label="Zip" placeholder="Zip" hint="Zip code." />
		<ACheckbox
			checked={user.newsletter}
			name="newsletter"
			label="Send newsletters"
			hint="Check if this user should receive email newsletters."
		/>
		<div>
			<AButton text="Save" type="submit" />
		</div>
	</form>
</div>
