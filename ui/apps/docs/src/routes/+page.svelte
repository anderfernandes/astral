<script lang="ts">
	import { AButton } from 'ui';

	let { data } = $props();
	const { version } = data;
</script>

<svelte:head>
	<title>Astral Docs {version}</title>
</svelte:head>

<section class="flex h-full w-full flex-col items-center justify-center gap-3">
	<div class="rounded bg-black px-2 py-1 text-xs font-bold text-white">{version}</div>
	<h1 class="text-center text-3xl font-extrabold lg:text-5xl">
		We help non-profit planetarium, museums and science center focus on teaching their communities.
	</h1>
	<h5 class="text-center text-muted-foreground">
		With Astral these organizations can sell tickets and gifts, create and manage events, visitors
		and memberships.
	</h5>
	<hr />
	<div class="flex gap-3">
		<AButton text="Get Started" href="/docs/introduction" />
		<AButton text="Support Us" variant="secondary" />
	</div>
</section>
