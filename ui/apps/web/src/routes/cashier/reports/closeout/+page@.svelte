<script lang="ts">
	import { format } from 'date-fns';

	let { data } = $props();
	let { organization, closeout } = data;

	const start = new Date(data.closeout.start);
	const end = new Date(data.closeout.end);

	function getDates() {
		return start.toLocaleDateString() === end.toLocaleDateString()
			? format(start, 'M/d/yyyy h:mm a')
			: `${format(start, 'M/d/yyyy h:mm a')} ~ ${format(end, 'M/d/yyyy h:mm a')}`;
	}
</script>

<svelte:head>
	<title>Closeout Report | {organization.name} &middot; Astral</title>
</svelte:head>

<section class="flex w-96 flex-col p-6 text-xs">
	<div>
		<h5 class="font-medium">Closeout Report</h5>
		<h5>
			Run: {format(new Date(), 'EEE MMM d yyyy h:mm a')}
		</h5>
		<span class="text-zinc-500 dark:text-zinc-400">
			Payment Start: {format(start, 'EEE MMM d yyyy h:mm a')}
		</span>
		<br />
		<span class="text-zinc-500 dark:text-zinc-400">
			Payment End: {format(end, 'EEE MMM d yyyy h:mm a')}
		</span>
		{#if closeout.report.length > 1}
			<h5 class="text-zinc-500 dark:text-zinc-400">
				Cashiers: {closeout.report.map((r) => r.cashier).join(', ')}
			</h5>
		{:else}
			<h5 class="text-zinc-500 dark:text-zinc-400">Cashier: {closeout.report[0].cashier}</h5>
		{/if}
	</div>
	<br />
	<table class="table-auto">
		{#each closeout.report as report}
			<thead>
				{#if data.closeout.report.length > 1}
					<tr>
						<td class="py-2 font-semibold" colspan="3">
							Cashier: {report.cashier}
						</td>
					</tr>
				{/if}
				<tr class="border-b border-zinc-300">
					<th class="pr-2">Method</th>
					<th class="border-x border-zinc-300 p-2">Transactions</th>
					<th class="p-2">Amount</th>
				</tr>
			</thead>
			<tbody>
				{#each report.items as item}
					<tr class="border-b border-zinc-300" class:bg-red-50={item.method.includes('refund')}>
						<td class="pr-2">{item.method}</td>
						<td class="border-x border-zinc-300 p-2">{item.transactions}</td>
						<td class="py-2 text-right">${item.amount}</td>
					</tr>
				{/each}
				{#if data.closeout.report.length > 1}
					<tr class="border-b border-zinc-300">
						<td colspan="2" class="py-2">
							{getDates()}
							{#if data.closeout.report.length > 1}
								{report.cashier.split(' ')[0]}'s
							{/if}
							Transactions:
						</td>
						<td class="text-right">
							{report.transactions}
						</td>
					</tr>
					<tr>
						<td colspan="2" class="py-2">
							{getDates()}
							{#if data.closeout.report.length > 1}
								{report.cashier.split(' ')[0]}'s
							{/if}
							Totals:
						</td>
						<td class="text-right">${report.total}</td>
					</tr>
				{/if}
				<tr>
					<td>&nbsp;</td>
				</tr>
			</tbody>
		{/each}
		<tfoot>
			<tr class="border-b border-zinc-300">
				<th colspan="2" class="py-2 text-left">
					{getDates()} Transactions:
				</th>
				<th class="py-2 text-right">{data.closeout.transactions}</th>
			</tr>
			<tr>
				<th colspan="2" class="py-2 text-left">
					{getDates()} Totals:
				</th>
				<th class="py-2 text-right">${data.closeout.total}</th>
			</tr>
		</tfoot>
	</table>
	<br />
	<p>End of Report</p>
</section>
