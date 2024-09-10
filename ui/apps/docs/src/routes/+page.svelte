<script lang="ts">
	let { data } = $props();
	const { version } = data;
</script>

<svelte:head>
	<title>Astral Docs {version}</title>
</svelte:head>

<section class="flex h-screen w-screen flex-col items-center justify-center gap-3">
	<h1 class="text-5xl font-extrabold">Astral Docs</h1>
	<div class="rounded bg-black px-2 py-1 text-xs font-bold text-white">{version}</div>
</section>
