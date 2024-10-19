<script lang="ts">
	import { enhance } from '$app/forms';
	import { AButton, AInput } from 'ui';

	let { data } = $props();
	const { version } = data;
</script>

<svelte:head>
	<title>Register | {data.settings.organization.name} &middot; Astral</title>
</svelte:head>

<h1 class="text-center text-3xl font-bold">Register</h1>
<p class="text-balance text-center text-sm text-muted-foreground">
	Fill out the form below to create an account.
</p>
<form class="grid gap-3" method="post" use:enhance>
	<div class="grid gap-3 lg:grid-cols-2">
		<AInput
			name="firstname"
			type="text"
			required
			label="First Name"
			placeholder="First Name"
			hint="Your first name."
		/>
		<AInput
			name="lastname"
			type="text"
			required
			label="Last Name"
			placeholder="Last Name"
			hint="Your last name."
		/>
	</div>
	<AInput
		name="email"
		type="email"
		required
		label="Email"
		placeholder="Email"
		hint="An email for your account."
	/>
	<AInput
		name="email_confirmation"
		type="email"
		required
		label="Email Confirmation"
		placeholder="Confirm Email"
		hint="Type your email again."
	/>

	<AInput
		name="password"
		type="password"
		required
		label="Password"
		placeholder="Password"
		hint="A password for you account."
	/>
	<AInput
		name="password_confirmation"
		type="password"
		required
		label="Password Confirmation"
		placeholder="Password"
		hint="Type your password again."
	/>

	<AButton text="Submit" />
</form>
<div class="mt-4 text-center text-sm">
	<a class="underline" href="/login">I already have an account.</a>
</div>
