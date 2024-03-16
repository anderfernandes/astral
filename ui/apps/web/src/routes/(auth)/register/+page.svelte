<script lang="ts">
	import { enhance } from '$app/forms';
	import { AInput, AButton, AScreenSize } from 'ui';
	import { getContext } from 'svelte';

	let { data, form } = $props();

	const { organization, version } = data;

	let loading = $state(false);

	let toast = getContext<IToastContext>('toasts');

	// TODO: BLOCK USERS FROM REPEATEDILY CREATING ACCOUNTS
</script>

<svelte:head>
	<title>Create an Account &middot; {organization.name} | Astral</title>
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
				<h1 class="text-center text-2xl font-bold tracking-tight">Create an Account</h1>
				<h5 class="text-muted-foreground text-center">{organization.name}</h5>
			</div>
			{#if form?.success === true}
				<p class="text-center">We sent you an email to verify your account.</p>
			{:else}
				<form
					class="grid gap-4"
					method="POST"
					use:enhance={() => {
							loading = true;
							return async ({ result, update }) => {
								loading = false;
								if (result.type === 'failure') {
									toast.push({ title: 'Error', message: result.data?.message as string });
								}
								await update();
							};
						}}
				>
					<AInput
						name="firstname"
						required
						label="First Name"
						placeholder="First Name"
						hint="First Name"
						disabled={loading}
					/>
					<AInput
						name="lastname"
						required
						label="Last Name"
						placeholder="Last Name"
						hint="Last Name"
						disabled={loading}
					/>
					<AInput name="email" label="Email" required placeholder="Email" hint="Email" />
					<AInput
						name="password"
						label="Password"
						required
						placeholder="Password"
						type="password"
						hint="Password"
						errors={form?.errors?.password}
						disabled={loading}
					/>
					<AInput
						name="password_confirmation"
						label="Password Confirmation"
						required
						placeholder="Password Confirmation"
						type="password"
						hint="Password Confirmation"
						errors={form?.errors?.password}
						disabled={loading}
					/>
					<div>
						<AButton {loading} text="Submit" type="submit" />
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
					{version}
				</span>
			</div>
		</div>
	</section>
</main>
