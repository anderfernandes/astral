<script lang="ts">
	import SalePartial from '$lib/components/SalePartial.svelte';

	const { data } = $props();
</script>

<svelte:head>
	<title>Sale #{data.sale.id} Details | Astral Cashier</title>
</svelte:head>

<SalePartial sale={data.sale} />
