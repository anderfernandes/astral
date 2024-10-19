<script lang="ts">
	import { applyAction, enhance } from '$app/forms';
	import { AButton, ACheckbox, AInput } from 'ui';

	let { data } = $props();
	const { settings } = data;
	let loading = $state(false);
	let hasErrors = $state(false);
</script>

<svelte:head>
	<title>Login | {settings?.organization.name} &middot; Astral</title>
</svelte:head>

<h1 class="text-center text-3xl font-bold">Login</h1>
<p class="text-balance text-center text-sm text-muted-foreground">
	Enter your email below to login to your account.
</p>
<form
	class="grid gap-3"
	method="post"
	use:enhance={() => {
		hasErrors = false;
		loading = true;
		return async ({ result }) => {
			console.log(result.status);
			if (result.status! >= 400) {
				loading = false;
				hasErrors = true;
			} else await applyAction(result);
		};
	}}
>
	<AInput
		name="email"
		type="text"
		required
		label="Email"
		placeholder="Email"
		hint="The email you used to create an account."
		disabled={loading}
	/>
	<AInput
		name="password"
		type="password"
		required
		label="Password"
		placeholder="Password"
		hint="Your account password."
		disabled={loading}
	/>
	<ACheckbox
		name="remember"
		label="Remember"
		hint="Check if you are loging in using a personal device."
		disabled={loading}
	/>
	<AButton text="Login" type="submit" {loading} />
	<a class="ml-auto inline-block text-sm underline" href="/forgot"> Forgot your password? </a>
	<div class="mt-4 text-center text-sm">
		Don't have an account?<!-- --> <a class="underline" href="/register">Register</a>
	</div>
</form>
{#if hasErrors}
	<ol
		tabindex="-1"
		class="fixed top-0 z-[100] flex max-h-screen w-full flex-col-reverse p-4 sm:bottom-0 sm:right-0 sm:top-auto sm:flex-col md:max-w-[420px]"
	>
		<li
			role="status"
			aria-live="off"
			aria-atomic="true"
			tabindex="-1"
			class="data-[state=open]:animate-in data-[state=closed]:animate-out data-[swipe=end]:animate-out data-[state=closed]:fade-out-80 data-[state=closed]:slide-out-to-right-full data-[state=open]:slide-in-from-top-full data-[state=open]:sm:slide-in-from-bottom-full group pointer-events-auto relative flex w-full items-center justify-between space-x-4 overflow-hidden rounded-md border bg-background p-6 pr-8 text-foreground shadow-lg transition-all data-[swipe=cancel]:translate-x-0 data-[swipe=end]:translate-x-[var(--radix-toast-swipe-end-x)] data-[swipe=move]:translate-x-[var(--radix-toast-swipe-move-x)] data-[swipe=move]:transition-none"
			style="user-select: none; touch-action: none;"
			data-radix-collection-item=""
		>
			<div class="grid gap-1">
				<div class="text-sm font-semibold">Uh oh! Something went wrong.</div>
				<div class="text-sm opacity-90">Invalid credentials.</div>
			</div>
			<button
				aria-label="Error"
				type="button"
				class="absolute right-2 top-2 rounded-md p-1 text-foreground/50 opacity-0 transition-opacity hover:text-foreground focus:opacity-100 focus:outline-none focus:ring-2 group-hover:opacity-100"
				><svg
					xmlns="http://www.w3.org/2000/svg"
					width="24"
					height="24"
					viewBox="0 0 24 24"
					fill="none"
					stroke="currentColor"
					stroke-width="2"
					stroke-linecap="round"
					stroke-linejoin="round"
					class="lucide lucide-x h-4 w-4"
					><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg
				></button
			>
		</li>
	</ol>
{/if}
