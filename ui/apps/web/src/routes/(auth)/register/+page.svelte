<script lang="ts">
	import { applyAction, enhance } from '$app/forms';
	import { AButton, AInput } from 'ui';

	let { data, form } = $props();
	let loading = $state(false);
</script>

<svelte:head>
	<title>Register | {data.settings.organization.name} &middot; Astral</title>
</svelte:head>

<h1 class="text-center text-3xl font-bold">Register</h1>
<p class="text-balance text-center text-sm text-muted-foreground">
	Fill out the form below to create an account.
</p>
<form
	class="grid gap-3"
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
	<div class="grid gap-3 lg:grid-cols-2">
		<AInput
			name="firstname"
			type="text"
			required
			label="First Name"
			placeholder="First Name"
			hint="Your first name."
			disabled={loading}
			errors={form?.errors['firstname'] ?? []}
		/>
		<AInput
			name="lastname"
			type="text"
			required
			label="Last Name"
			placeholder="Last Name"
			hint="Your last name."
			disabled={loading}
			errors={form?.errors['lastname'] ?? []}
		/>
	</div>
	<AInput
		name="email"
		type="email"
		required
		label="Email"
		placeholder="Email"
		hint="An email for your account."
		disabled={loading}
		errors={form?.errors['email'] ?? []}
	/>
	<AInput
		name="email_confirmation"
		type="email"
		required
		label="Email Confirmation"
		placeholder="Confirm Email"
		hint="Type your email again."
		disabled={loading}
		errors={form?.errors['email'] ?? []}
	/>

	<AInput
		name="password"
		type="password"
		required
		label="Password"
		placeholder="Password"
		hint="A password for you account."
		disabled={loading}
		errors={form?.errors['password'] ?? []}
	/>
	<AInput
		name="password_confirmation"
		type="password"
		required
		label="Password Confirmation"
		placeholder="Password"
		hint="Type your password again."
		disabled={loading}
		errors={form?.errors['password'] ?? []}
	/>

	<AButton text="Submit" {loading} />
</form>

<div class="mt-4 text-center text-sm">
	<a class="underline" href="/login">I already have an account.</a>
</div>

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
				<div class="text-sm opacity-90">FIx the errors below.</div>
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
