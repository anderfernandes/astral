<script lang="ts">
	let { data, children } = $props();
	const { settings } = data;
</script>

<main class="grid h-svh grid-cols-2">
	<section class="relative hidden bg-[url('/storage/cover.jpg')] bg-cover bg-center lg:block">
		<h1
			class="relative z-20 flex h-1/6 items-start gap-4 bg-gradient-to-b from-background/35 to-transparent p-6 text-lg font-medium text-white"
		>
			<img
				src={settings.organization.logo}
				class="object-cover"
				width="32"
				height="32"
				alt="Logo"
			/>
			{settings?.organization.name}
		</h1>
	</section>
	<section class="flex w-screen flex-col items-center justify-center gap-3 lg:w-full">
		<article class="grid w-full gap-3 p-6 lg:w-96">
			<svg
				viewBox="0 0 24 24"
				xmlns="http://www.w3.org/2000/svg"
				stroke="currentColor"
				stroke-width="1.25"
				class="mx-auto size-16"
			>
				<circle cx="12" cy="12" r="5" fill="transparent" />
				<path
					stroke="currentColor"
					fill="transparent"
					d="M 3.3357286,6.9976809 6.3405211,6.3405212 6.9976805,3.3357289 9.9284869,4.2690082 12,1.9953613 14.071513,4.2690081 17.002319,3.3357286 17.659479,6.3405211 20.664271,6.9976805 19.730992,9.9284869 22.004639,12 l -2.273647,2.071513 0.933279,2.930806 -3.004792,0.65716 L 17.00232,20.664271 14.071513,19.730992 12,22.004639 9.9284871,19.730992 6.9976809,20.664271 6.3405212,17.659479 3.3357289,17.00232 4.2690082,14.071513 1.9953613,12 4.2690081,9.9284871 Z"
				/>
			</svg>

			{@render children()}
			<div role="none" class="my-4 h-[1px] w-full shrink-0 bg-border"></div>
			<div class="mt-4 text-center text-sm">
				<div
					class="inline-flex items-center rounded-md border border-transparent bg-primary px-2.5 py-0.5 text-xs font-semibold text-primary-foreground shadow transition-colors hover:bg-primary/80 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2"
				>
					{settings?.version}
				</div>
			</div>
		</article>
	</section>
</main>
