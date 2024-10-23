<script lang="ts">
	import { applyAction, enhance } from '$app/forms';
	import { AButton, ACheckbox, AInput } from 'ui';

	const { data, form } = $props();
	const { settings } = data;
	let loading = $state(false);
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
		loading = true;
		return async ({ result, update }) => {
			console.log(result.status);
			if (result.status! >= 400) {
				loading = false;
			} else await applyAction(result);
			await update();
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
		errors={form?.message ? ['Invalid credentials'] : []}
	/>
	<AInput
		name="password"
		type="password"
		required
		label="Password"
		placeholder="Password"
		hint="Your account password."
		disabled={loading}
		errors={form?.message ? ['Invalid credentials'] : []}
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

{#if form?.message}
	<ol class="absolute right-0 top-0 grid w-screen p-3 lg:w-[420px]">
		<li
			aria-label="notification"
			role="status"
			aria-live="off"
			aria-atomic="true"
			tabindex="-1"
			data-state="open"
			data-swipe-direction="right"
			class="group pointer-events-auto relative flex w-full items-center justify-between space-x-2 overflow-hidden rounded-md border bg-destructive p-4 pr-6 text-destructive-foreground shadow-lg transition-all data-[swipe=cancel]:translate-x-0 data-[swipe=end]:translate-x-[var(--radix-toast-swipe-end-x)] data-[swipe=move]:translate-x-[var(--radix-toast-swipe-move-x)] data-[swipe=move]:transition-none"
			style="user-select: none; touch-action: none;"
			data-radix-collection-item=""
		>
			<div class="grid gap-1">
				<div class="[&amp;+div]:text-xs text-sm font-semibold">Uh oh! Something went wrong.</div>
				<div class="text-sm opacity-90">Invalid credentials.</div>
			</div>
			<button
				aria-label="close notification"
				type="button"
				class="absolute right-1 top-1 rounded-md p-1 text-foreground/50 opacity-0 transition-opacity hover:text-foreground focus:opacity-100 focus:outline-none focus:ring-1 group-hover:opacity-100 group-[.destructive]:text-red-300 group-[.destructive]:hover:text-red-50 group-[.destructive]:focus:ring-red-400 group-[.destructive]:focus:ring-offset-red-600"
				><svg
					width="15"
					height="15"
					viewBox="0 0 15 15"
					fill="none"
					xmlns="http://www.w3.org/2000/svg"
					class="h-4 w-4"
					><path
						d="M11.7816 4.03157C12.0062 3.80702 12.0062 3.44295 11.7816 3.2184C11.5571 2.99385 11.193 2.99385 10.9685 3.2184L7.50005 6.68682L4.03164 3.2184C3.80708 2.99385 3.44301 2.99385 3.21846 3.2184C2.99391 3.44295 2.99391 3.80702 3.21846 4.03157L6.68688 7.49999L3.21846 10.9684C2.99391 11.193 2.99391 11.557 3.21846 11.7816C3.44301 12.0061 3.80708 12.0061 4.03164 11.7816L7.50005 8.31316L10.9685 11.7816C11.193 12.0061 11.5571 12.0061 11.7816 11.7816C12.0062 11.557 12.0062 11.193 11.7816 10.9684L8.31322 7.49999L11.7816 4.03157Z"
						fill="currentColor"
						fill-rule="evenodd"
						clip-rule="evenodd"
					></path></svg
				></button
			>
		</li>
	</ol>
{/if}
