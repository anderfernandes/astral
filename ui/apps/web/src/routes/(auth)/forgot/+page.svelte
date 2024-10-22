<script lang="ts">
	import { applyAction, enhance } from '$app/forms';
	import { AButton, AInput } from 'ui';

	let { data, form } = $props();
	const { settings } = data;
	const { organization } = settings;
	let loading = $state(false);
</script>

<svelte:head>
	<title>Account Recovery | {organization.name} &middot; Astral</title>
</svelte:head>

<h1 class="text-center text-3xl font-bold">Forgot Password</h1>

{#if form?.success}
	<p class="text-center text-sm">
		If you have an account with us you will receive a password reset link.
	</p>
{:else}
	<p class="text-balance text-center text-sm text-muted-foreground">
		Enter your email below to get a password reset link.
	</p>
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
			name="email"
			type="email"
			required
			label="Email"
			placeholder="Email"
			disabled={loading}
			hint="The email you used to create your account."
		/>
		<AButton type="submit" text="Submit" {loading} />
	</form>
	<div class="mt-4 text-center text-sm">
		<a class="underline" href="/login">I already have an account.</a>
	</div>
{/if}
