<script lang="ts">
	import { enhance } from '$app/forms';
	import { AInput, AButton, AScreenSize } from 'ui';
	import { getContext } from 'svelte';

	let { data, form } = $props();

	const { organization, version, email, token } = data;

	let loading = $state(false);

	let toast = getContext<IToastContext>('toasts');

	// TODO: BLOCK USERS FROM REPEATEDILY DOING THIS
</script>

<svelte:head>
	<title>Reset Password &middot; {organization.name} | Astral</title>
</svelte:head>

<main class="relative flex h-screen w-screen items-center justify-center">
	<img
		class="absolute right-0 top-0 h-full w-full object-cover"
		src={organization.cover}
		alt="cover"
	/>
	<section class="z-10 grid h-full w-full lg:grid-cols-3 2xl:grid-cols-5">
		<div class="hidden lg:block 2xl:col-span-2"></div>
		<div
			class="flex items-center justify-center bg-white/90 p-6 lg:bg-transparent dark:bg-black/50 lg:dark:bg-transparent"
		>
			<div class="flex w-full flex-col gap-4 rounded-xl p-6 lg:bg-white/90 lg:dark:bg-black/50">
				<div>
					<AScreenSize />
					<h1 class="text-center text-2xl font-bold tracking-tight">Reset Password</h1>
					<h5 class="text-muted-foreground text-center">{organization.name}</h5>
				</div>

				<form
					class="grid gap-4"
					method="POST"
					use:enhance={() => {
					loading = true
					return async ({ result, update}) => {
						await update()
						loading = false
						if (result.type === "failure") {
							toast.push({title: "Error", message: result.data?.message as string})
						}
						toast.push({title: "Success!", message: "Password reset successful!"})
					}
				}}
				>
					<AInput
						label="Email"
						required
						placeholder="Email"
						value={email}
						disabled
						errors={form?.errors?.email}
					/>
					<AInput
						name="password"
						type="password"
						label="Password"
						required
						placeholder="Password"
						errors={form?.errors?.password}
						hint="Password"
						disabled={loading}
					/>
					<AInput
						name="password_confirmation"
						type="password"
						label="Password Confirmation"
						required
						placeholder="Password Confirmation"
						errors={form?.errors?.password}
						hint="Password Confirmation"
						disabled={loading}
					/>
					<input type="hidden" name="email" value={email} />
					<input type="hidden" name="token" value={token} />
					<div>
						<AButton {loading} text="Submit" type="submit" />
					</div>
				</form>

				<a href="/login" class=" text-center text-sm font-medium"> I already have an account</a>
				<p class="text-muted-foreground text-center text-sm">
					&copy; 2017-{new Date().getFullYear()}
					<a class="underline underline-offset-4" href="https://anderfernandes.com" target="_blank"
						>@anderfernandes</a
					>
				</p>
				<div class="flex justify-center text-center">
					<span
						class="rounded-full bg-black px-3 py-1 text-xs text-white dark:bg-white dark:text-black"
					>
						{version}
					</span>
				</div>
			</div>
		</div>
		<div class="hidden lg:block 2xl:col-span-2"></div>
	</section>
</main>
