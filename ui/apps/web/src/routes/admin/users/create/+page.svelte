<script>
	import { enhance } from '$app/forms';
	import { AButton, ACheckbox, AInput, ASelect } from 'ui';

	let { form } = $props();
</script>

<svelte:head>
	<title>New User | Astral</title>
</svelte:head>

<section class="flex flex-col gap-6 lg:mx-60">
	<div class="flex items-center">
		<h2 class="grow text-3xl font-bold tracking-tight">New User</h2>
	</div>
	{#if form?.message}
		<p class="text-sm text-red-500">{form.message}</p>
	{/if}
</section>

<form method="POST" class="grid gap-4 lg:mx-60" use:enhance>
	<div class="grid gap-4 lg:grid-cols-2">
		<AInput
			name="firstname"
			label="First Name"
			placeholder="First Name"
			hint="The first name of the user."
			required
		/>
		<AInput
			name="lastname"
			label="Last Name"
			placeholder="Last Name"
			hint="The last name of the user."
			required
		/>
	</div>
	<AInput
		type="email"
		name="email"
		label="Email"
		placeholder="Email"
		hint="The email of the user. Must not be on record already."
		required
	/>
	<div class="grid gap-4 lg:grid-cols-2">
		<AInput name="address" label="Address" placeholder="Address" hint="The address of the user." />
		<AInput name="city" label="City" placeholder="City" hint="The city of the user." />
		<ASelect
			name="state"
			label="State"
			placeholder="Select one"
			hint="The state where the user lives."
			options={[{ value: 'Texas', text: 'Texas' }]}
		/>
		<AInput name="zip" label="Zip" placeholder="Zip" hint="Zip code." />
	</div>

	<ACheckbox
		name="newsletter"
		label="Send newsletters"
		hint="Check if this user should receive email newsletters."
	/>
	<div>
		<AButton text="Save" type="submit" />
	</div>
</form>
