<script lang="ts">
	import AdminLayout from '../../AdminLayout.svelte';
	import SalePartial from '$lib/components/SalePartial.svelte';

	const { data } = $props();
	const { sale } = data;
</script>

{#snippet header()}
	<div class="flex w-full items-center justify-between">
		<h2 class="text-xl font-bold">Sale #{sale.id}</h2>
		<!-- <AButton text="Edit" href={`/admin/sales/${sale.id}/edit`} /> -->
	</div>
{/snippet}

<AdminLayout title={`Sale #${sale.id}`} {header} backHref="/admin/sales">
	<SalePartial sale={data.sale} />
</AdminLayout>
