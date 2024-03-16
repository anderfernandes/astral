<script lang="ts">
	import { format } from 'date-fns';

	let { data } = $props();
	let { organization } = data;
	const start = new Date(data.start);
	const end = new Date(data.end);
</script>

<svelte:head>
	<title>Payment Report | {organization.name} &middot; Astral</title>
</svelte:head>

<section class="p-6 text-sm">
	<h5 class="text-center font-medium">Payment Report</h5>
	<h5 class="text-center font-medium">{organization.name}</h5>
	<br />
	<p>Run: {format(new Date(), 'EEE MMM d yyyy h:mm a')}</p>
	<br />
	{#each data.report as report}
		<span class="font-semibold">Cashier: {report.cashier}</span>
		<br /><br />
		<table
			class="w-full table-auto border-separate border-spacing-0 rounded border border-zinc-300"
		>
			<thead class="bg-zinc-100">
				<tr>
					<th class="border-b p-2 text-left">Payment Date and Time</th>
					<th class="border-b p-2 text-left">Sale #</th>
					<th class="border-b p-2 text-left">Customer</th>
					<th class="border-b p-2 text-left">Reference</th>
					<th class="border-b p-2 text-left">Method</th>
					<th class="border-b p-2 text-left">Tendered</th>
					<th class="border-b p-2 text-left">Change</th>
					<th class="border-b p-2 text-left">Amount</th>
				</tr>
			</thead>
			<tbody>
				{#each report.transactions as payment}
					<tr class="border-y" class:bg-red-100={payment.refunded}>
						<td class="border-b border-zinc-300 p-2">
							{format(new Date(payment.created_at), 'EEE MMM d yyyy h:mm a')}
						</td>
						<td class="border-b border-zinc-300 p-2">{payment.sale_id}</td>
						<td class="border-b border-zinc-300 p-2">{payment.customer}</td>
						<td class="border-b border-zinc-300 p-2">{payment.reference || ''}</td>
						<td class="border-b border-zinc-300 p-2"
							>{payment.method}
							{#if payment.refunded}(refunded){/if}</td
						>
						<td class="border-b border-zinc-300 p-2">$ {payment.tendered.toFixed(2)}</td>
						<td class="border-b border-zinc-300 p-2">$ {payment.change.toFixed(2)}</td>
						<td class="border-b border-zinc-300 p-2">$ {payment.amount.toFixed(2)}</td>
					</tr>
				{/each}
			</tbody>
			<tfoot class="bg-zinc-100">
				<tr>
					<th colspan="8" class="p-2 text-right">
						Totals for {report.cashier}: $ {report.totals}
					</th>
				</tr>
			</tfoot>
		</table>
		<br />
	{/each}
</section>
