<script lang="ts">
	import { formatDistanceToNow } from 'date-fns';
	import uniqBy from 'lodash/uniqBy.js';
	import { AButton, ADialog } from 'ui';
	import AdminLayout from '../../AdminLayout.svelte';
	import { applyAction, enhance } from '$app/forms';
	import SalePartial from '$lib/components/SalePartial.svelte';

	const { data } = $props();
	const { sale } = data;

	const paid = data.sale.payments.reduce((a, b) => a + b.total, 0);

	let dialog = $state(false);

	const toggle = () => {
		dialog = !dialog;
	};

	let loading = $state(false);

	const created_at = new Date(data.sale.created_at);
	const updated_at = new Date(data.sale.updated_at);
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
