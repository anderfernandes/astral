<script lang="ts">
	import { enhance } from '$app/forms';
	import { AButton, AInput } from 'ui';

	let { data } = $props();
	const { version, settings } = data;
	const { organization } = settings;
</script>

<svelte:head>
	<title>Account Recovery | {organization.name} &middot; Astral</title>
</svelte:head>

<h1 class="text-center text-3xl font-bold">Account Verified</h1>
<p class="text-balance text-center text-sm text-muted-foreground">
	Your account has been succesfully verified. Please log in.
</p>
<AButton href="/login" text="Login" />
