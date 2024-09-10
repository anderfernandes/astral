<script lang="ts">
	let { data } = $props();
</script>

<svelte:head>
	<title>Payment Report | {data.organization.name} &middot; Astral</title>
</svelte:head>

<section class="p-6 text-sm">
	<h5 class="text-center font-medium">Payment Report</h5>
	<h5 class="text-center font-medium">{data.organization.name}</h5>
	<br />
	<p>
		Run: {Intl.DateTimeFormat('en-US', { dateStyle: 'medium', timeStyle: 'short' }).format(
			new Date()
		)}
	</p>
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
							{Intl.DateTimeFormat('en-US', { dateStyle: 'medium', timeStyle: 'short' }).format(
								new Date(payment.created_at)
							)}
						</td>
						<td class="border-b border-zinc-300 p-2">{payment.sale_id}</td>
						<td class="border-b border-zinc-300 p-2">{payment.customer}</td>
						<td class="border-b border-zinc-300 p-2">{payment.reference || ''}</td>
						<td class="border-b border-zinc-300 p-2"
							>{payment.method}
							{#if payment.refunded}(refunded){/if}</td
						>
						<td class="border-b border-zinc-300 p-2">
							{Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(
								payment.tendered
							)}
						</td>
						<td class="border-b border-zinc-300 p-2">
							{Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(
								payment.change
							)}
						</td>
						<td class="border-b border-zinc-300 p-2">
							{Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(
								payment.amount
							)}
						</td>
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
