<script lang="ts">
	import SalePartial from '$lib/components/SalePartial.svelte';

	const { data } = $props();
</script>

<svelte:head>
	<title>Sale #{data.sale.id} Details | Astral Cashier</title>
</svelte:head>

<header
	class="sticky top-0 -mx-6 -mt-6 flex h-16 w-screen items-center bg-background/50 px-6 backdrop-blur lg:-mx-0 lg:w-full lg:pl-0 lg:pr-4"
>
	<h2 class="font-semibold">Sale #{data.sale.id}</h2>
</header>

<SalePartial sale={data.sale} />
