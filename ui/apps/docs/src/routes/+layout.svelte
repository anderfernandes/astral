<script lang="ts">
	import { page } from '$app/stores';
	import DocsMenuItems from '$lib/DocsMenuItems.svelte';
	import '../styles.css';

	let { children, data } = $props();

	const { version } = data;

	let open = $state(false);

	function toggle() {
		open = !open;
	}
</script>

<svelte:head>
	<title>Astral</title>
</svelte:head>

<header
	class="sticky top-0 z-10 mx-auto flex h-16 w-full max-w-screen-lg items-center gap-3 bg-background/60 px-6 backdrop-blur-md"
>
	<svg
		onkeypress={toggle}
		tabindex="-1"
		role="button"
		onclick={toggle}
		xmlns="http://www.w3.org/2000/svg"
		width="24"
		height="24"
		viewBox="0 0 24 24"
		fill="none"
		stroke="currentColor"
		stroke-width="2"
		stroke-linecap="round"
		stroke-linejoin="round"
		class="block lg:hidden"
		><line x1="4" x2="20" y1="12" y2="12" /><line x1="4" x2="20" y1="6" y2="6" /><line
			x1="4"
			x2="20"
			y1="18"
			y2="18"
		/></svg
	>
	<h3 class="flex grow items-center gap-3 font-extrabold lg:w-56 lg:grow-0">
		<svg
			viewBox="0 0 24 24"
			xmlns="http://www.w3.org/2000/svg"
			stroke="currentColor"
			stroke-width="1.5"
			class="size-8"
		>
			<circle cx="12" cy="12" r="5" fill="transparent" />
			<path
				stroke="currentColor"
				fill="transparent"
				d="M 3.3357286,6.9976809 6.3405211,6.3405212 6.9976805,3.3357289 9.9284869,4.2690082 12,1.9953613 14.071513,4.2690081 17.002319,3.3357286 17.659479,6.3405211 20.664271,6.9976805 19.730992,9.9284869 22.004639,12 l -2.273647,2.071513 0.933279,2.930806 -3.004792,0.65716 L 17.00232,20.664271 14.071513,19.730992 12,22.004639 9.9284871,19.730992 6.9976809,20.664271 6.3405212,17.659479 3.3357289,17.00232 4.2690082,14.071513 1.9953613,12 4.2690081,9.9284871 Z"
			/>
		</svg>
		Astral
	</h3>
	<div class="flex gap-3">
		<a href="/" class:font-bold={$page.url.pathname === '/'}>Home</a>
		<a href="/docs/introduction" class:font-bold={$page.url.pathname.includes('/docs')}>Docs</a>
	</div>
</header>

{#if open}
	<aside class="fixed left-0 top-0 z-20 h-svh w-3/4 border-r bg-background p-6 lg:w-64">
		<div class="grid gap-3">
			<div class="flex w-full justify-end">
				<button onclick={toggle} onkeypress={toggle} aria-label="close">
					<svg
						xmlns="http://www.w3.org/2000/svg"
						width="24"
						height="24"
						viewBox="0 0 24 24"
						fill="none"
						stroke="currentColor"
						stroke-width="2"
						stroke-linecap="round"
						stroke-linejoin="round"
						class="text-muted-foreground"><path d="M18 6 6 18" /><path d="m6 6 12 12" /></svg
					>
				</button>
			</div>
			<svg
				viewBox="0 0 24 24"
				xmlns="http://www.w3.org/2000/svg"
				stroke="currentColor"
				stroke-width="1.5"
				class="-mt-6 size-12"
			>
				<circle cx="12" cy="12" r="5" fill="transparent" />
				<path
					stroke="currentColor"
					fill="transparent"
					d="M 3.3357286,6.9976809 6.3405211,6.3405212 6.9976805,3.3357289 9.9284869,4.2690082 12,1.9953613 14.071513,4.2690081 17.002319,3.3357286 17.659479,6.3405211 20.664271,6.9976805 19.730992,9.9284869 22.004639,12 l -2.273647,2.071513 0.933279,2.930806 -3.004792,0.65716 L 17.00232,20.664271 14.071513,19.730992 12,22.004639 9.9284871,19.730992 6.9976809,20.664271 6.3405212,17.659479 3.3357289,17.00232 4.2690082,14.071513 1.9953613,12 4.2690081,9.9284871 Z"
				/>
			</svg>
			<a href="/" class:font-bold={$page.url.pathname === '/'}>Home</a>
			<a href="/docs/introduction" class:font-bold={$page.url.pathname.includes('/docs')}>Docs</a>
		</div>
		<DocsMenuItems />
		<hr class="my-3" />
		<div class="mt-3 flex">
			<div class="rounded bg-black px-2 py-1 text-xs font-bold text-white">{version}</div>
		</div>
	</aside>
{/if}

<main class="mx-auto h-[calc(100svh-4rem)] w-full p-6 lg:max-w-screen-lg">
	{@render children()}
</main>
