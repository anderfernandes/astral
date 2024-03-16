<script lang="ts">
	import { AButton, AScreenSize } from 'ui';

	export let data;
	const { organization, version } = data;
</script>

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
					<h1 class="text-center text-2xl font-bold tracking-tight">Email Verification</h1>
					<h5 class="text-muted-foreground text-center">{organization.name}</h5>
				</div>
				<p class="text-center">Your email has been verified!</p>
				<AButton text="Login" href="/login" />
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
