<script lang="ts">
	import { applyAction, enhance } from '$app/forms';
	import { AButton, AInput } from 'ui';

	let { data } = $props();
	const { version, settings } = data;
	const { organization } = settings;
	let loading = $state(false);
</script>

<svelte:head>
	<title>Reset Password | {organization.name} &middot; Astral</title>
</svelte:head>

<h1 class="text-center text-3xl font-bold">Reset Password</h1>
<p class="text-balance text-center text-sm text-muted-foreground">
	Set a new password, different from your last five.
</p>
<br />
<form
	class="grid gap-6"
	method="post"
	use:enhance={() => {
		loading = true;
		return async ({ result, update }) => {
			console.log(result);
			if (result.status! >= 400) {
				loading = false;
			} else await applyAction(result);
			await update();
		};
	}}
>
	<AInput
		name="password"
		type="password"
		required
		label="Password"
		placeholder="Password"
		hint="A password for you account."
		disabled={loading}
	/>
	<AInput
		name="password_confirmation"
		type="password"
		required
		label="Password Confirmation"
		placeholder="Password"
		hint="Type your password again."
		disabled={loading}
	/>
	<AButton type="submit" text="Submit" {loading} />
</form>
