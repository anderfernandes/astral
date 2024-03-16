<script lang="ts">
	import { enhance } from '$app/forms';
	import { AInput, AButton, AScreenSize } from 'ui';
	import { getContext } from 'svelte';

	let { data, form } = $props();

	const { organization, version } = data;

	let loading = $state(false);

	let toast = getContext<IToastContext>('toasts');

	// TODO: BLOCK USERS FROM REPEATEDILY ASKING FOR PASSWORD RECOVERY
</script>

<svelte:head>
	<title>Forgot Password &middot; {organization.name} | Astral</title>
</svelte:head>

<main class="relative flex h-screen w-screen items-center justify-center">
	<img
		class="absolute right-0 top-0 h-full w-full object-cover"
		src={organization.cover}
		alt="cover"
	/>
	<section class="z-10 flex w-full md:w-[unset]">
		<div
			class="flex h-screen w-full flex-col justify-center gap-3 bg-white/90 p-6 md:h-[unset] md:w-96 md:rounded-xl dark:bg-black/60"
		>
			<div>
				<h1 class="text-center text-2xl font-bold tracking-tight">Forgot Password</h1>
				<h5 class="text-muted-foreground text-center">{organization.name}</h5>
			</div>
			{#if form?.success === true}
				<p class="text-center">
					If you have an account with us you will receive a password reset link on your email.
				</p>
			{:else}
				<form
					class="grid gap-4"
					method="POST"
					use:enhance={() => {
						loading = true;
						return async ({ result, update }) => {
							await update();
							if (result.type === 'failure') {
								loading = false;
							}
							if (result.status === 404) {
								toast.push({
									title: 'Done',
									message: 'If you have an account with us you will receive an email.'
								});
							}
						};
					}}
				>
					<AInput
						label="Email"
						required
						placeholder="Email"
						name="email"
						errors={form?.errors?.email}
						disabled={loading || form?.success === false}
						hint="We will send you a reset password link."
					/>
					<div>
						<AButton text="Submit" type="submit" {loading} />
					</div>
				</form>
			{/if}
			<a href="/login" class=" text-center text-sm font-medium"> I already have an account</a>
			<p class="text-muted-foreground text-center text-sm">
				&copy; 2017-{new Date().getFullYear()}
				<a class="underline underline-offset-4" href="https://anderfernandes.com" target="_blank"
					>@anderfernandes</a
				>
			</p>
			<div class="text-center">
				<span
					class="rounded-full bg-black px-3 py-1 text-xs text-white dark:bg-white dark:text-black"
				>
					{data.version}
				</span>
			</div>
		</div>
	</section>
</main>
