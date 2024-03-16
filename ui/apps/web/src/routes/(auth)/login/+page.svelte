<script lang="ts">
	import { enhance } from '$app/forms';
	import { AButton, AInput, ACheckbox, AScreenSize } from 'ui';

	let loading = $state(false);

	let { data, form } = $props();

	const { organization } = data;
</script>

<svelte:head>
	<title>Login &middot; {organization.name} | Astral</title>
</svelte:head>

<main class="grid h-screen lg:grid-cols-3 2xl:grid-cols-4">
	<section class="relative col-span-2 hidden h-full lg:block 2xl:col-span-3">
		<div
			class="absolute left-0 z-20 h-full w-full bg-gradient-to-l from-white to-95% dark:from-black"
		></div>
		<img class="h-full object-cover" src={organization.cover} alt="cover" />
	</section>
	<section class="flex flex-col items-center justify-center gap-4 p-6">
		<div class="flex w-full flex-col items-center gap-4 md:p-6">
			<div class="w-full">
				<AScreenSize />
				<h1 class="text-center text-2xl font-bold tracking-tight">Astral</h1>
				<h5 class="text-muted-foreground text-center">{organization.name}</h5>
			</div>
			<form
				class="grid w-full gap-4"
				method="POST"
				use:enhance={() => {
					loading = true;
					return async ({ result, update }) => {
						await update();
						if (result.type === 'failure') {
							loading = false;
						}
					};
				}}
			>
				<AInput
					name="email"
					label="Email"
					required
					hint="The email you have registered with us."
					placeholder="Email"
					disabled={loading}
					errors={form?.message ? [form?.message] : []}
				/>
				<AInput
					name="password"
					label="Password"
					required
					hint="Your password."
					placeholder="Password"
					type="password"
					disabled={loading}
					errors={form?.message ? [form?.message] : []}
				/>
				<ACheckbox
					name="remember"
					label="Remember me"
					hint="Check only if you are not on a public computer."
					disabled={loading}
				/>
				<div class="mt-12">
					<AButton {loading} text="Login" type="submit" />
				</div>
			</form>
			<div class="flex w-full items-center gap-3 text-sm">
				<hr />
				<span class="text-muted-foreground shrink">or</span>
				<hr />
			</div>
			<a href="/register" class="text-center text-sm font-medium">I don't have an account yet</a>
			<a href="/forgot" class=" text-center text-sm font-medium"> I forgot my password </a>
			<p class="text-muted-foreground text-sm">
				&copy; 2017-{new Date().getFullYear()}
				<a class="underline underline-offset-4" href="https://anderfernandes.com" target="_blank"
					>@anderfernandes</a
				>
			</p>
			<div class="flex justify-center">
				<span
					class="rounded-full bg-black px-3 py-1 text-xs text-white dark:bg-white dark:text-black"
				>
					{data.version}
				</span>
			</div>
		</div>
	</section>
</main>
