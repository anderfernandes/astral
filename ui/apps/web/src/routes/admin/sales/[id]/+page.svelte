<script lang="ts">
	import SalePartial from '$lib/components/SalePartial.svelte';

	const { data } = $props();
	const { sale } = data;
</script>

<svelte:head>
	<title>Sale #{sale.id} Details | Astral</title>
</svelte:head>

<header
	class="sticky top-0 -mx-6 flex h-16 items-center gap-3 bg-background/50 px-6 font-semibold backdrop-blur"
>
	<a href="/admin/sales" aria-label="back">
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
			class="size-6"
		>
			<path d="m12 19-7-7 7-7" />
			<path d="M19 12H5" />
		</svg>
	</a>
	<h2 class="grow text-xl font-semibold">Sale #{sale.id}</h2>
	<!-- <AButton text="Edit" href={`/admin/sales/${sale.id}/edit`} /> -->
</header>

<SalePartial sale={data.sale} />
