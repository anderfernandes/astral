<script lang="ts">
	import { enhance } from '$app/forms';
	import { AButton, AInput } from 'ui';

	let { data } = $props();
	const { version, settings } = data;
	const { organization } = settings;
</script>

<svelte:head>
	<title>Reset Password | {organization.name} &middot; Astral</title>
</svelte:head>

<main class="grid h-screen grid-cols-2">
	<section class="hidden bg-[url('/storage/cover.jpg')] bg-cover bg-center p-6 text-white lg:block">
		<h1 class="relative z-20 flex items-center text-lg font-medium">{organization.name}</h1>
	</section>
	<section class="flex w-screen flex-col items-center justify-center gap-3 lg:w-full">
		<article class="grid gap-3">
			<h1 class="text-3xl font-bold">Reset Password</h1>
			<p class="text-balance text-muted-foreground">
				Fill out the form below to recover your account
			</p>
			<form class="grid gap-6" method="POST" use:enhance>
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
				<AButton type="submit" text="Submit" />
			</form>
			<div class="mt-4 text-center text-sm">
				<a class="underline" href="/login">I already have an account.</a>
			</div>
			<div role="none" class="my-4 h-[1px] w-full shrink-0 bg-border"></div>
			<div class="mt-4 text-center text-sm">
				<div
					class="inline-flex items-center rounded-md border border-transparent bg-primary px-2.5 py-0.5 text-xs font-semibold text-primary-foreground shadow transition-colors hover:bg-primary/80 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2"
				>
					{version}
				</div>
			</div>
		</article>
	</section>
</main>
