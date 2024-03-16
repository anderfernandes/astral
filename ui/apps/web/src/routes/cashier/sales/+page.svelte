<script lang="ts">
	import { format, formatDistanceToNow } from 'date-fns';
	import _ from 'lodash';
	import { AChip, AIcon } from 'ui';
	import {
		account_circle,
		badge_account_horizontal_outline,
		package_variant_closed,
		ticket_outline
	} from 'ui/icons';

	let { data } = $props();
	let { sales } = data;
</script>

<section class="flex w-full flex-col gap-3 p-6">
	<h1>Sales ({sales.length})</h1>
	<table class="w-full table-auto border text-sm">
		<thead>
			<tr>
				<th>#</th>
				<th>Status</th>
				<th>Created by</th>
				<th>Customer</th>
				<th>Items</th>
				<th>Total</th>
				<th>Balance</th>
				<th>Created on</th>
			</tr>
		</thead>
		<tbody>
			{#each sales as sale}
				<tr class="even:bg-zinc-50 hover:bg-zinc-100 dark:even:bg-zinc-950 dark:hover:bg-zinc-900">
					<td>
						<a href={`/cashier/sales/${sale.id}`}>
							{sale.id}
						</a>
					</td>
					<td>{sale.status}</td>
					<td>
						<div class="flex items-center gap-1">
							<AIcon data={badge_account_horizontal_outline} />
							<span>{sale.creator?.firstname}</span>
						</div>
					</td>
					<td>
						<div class="flex items-center gap-1">
							<AIcon data={account_circle} />
							<span>{sale.customer?.firstname}</span>
						</div>
					</td>
					<td class="flex flex-col gap-2">
						<div class="flex items-center gap-2">
							{#if sale.tickets.length > 0}
								<span class="flex gap-1 text-xs">
									<AIcon data={ticket_outline} />
									{sale.tickets.length}
								</span>
							{/if}
							<div class="flex gap-1">
								{#each sale.events! as event}
									{#each _.uniqBy(sale.tickets, 'event_id') as ticket}
										{@const quantity = sale.tickets.filter(
											(t) => t.event_id === event.id && t.type_id === ticket.type_id
										).length}
										<AChip text={`${ticket.type.name} x ${quantity} (#${ticket.event_id})`} />
									{/each}
								{/each}
							</div>
						</div>
						<div class="flex items-center gap-2">
							{#if sale.products.length > 0}
								<span class="flex gap-1 text-xs">
									<AIcon data={package_variant_closed} />
									{sale.products.length}
								</span>
							{/if}
							{#each _.uniqBy(sale.products, 'id') as product}
								{@const quantity = sale.products.filter((p) => p.id === product.id).length}
								<AChip text={`${product.name} x ${quantity}`} />
							{/each}
						</div>
					</td>
					<td>${sale.total.toFixed(2)}</td>
					<td>${sale.balance.toFixed(2)}</td>
					<td class="text-xs text-zinc-500 dark:text-zinc-400"
						>{format(new Date(sale.created_at), 'EEE MMM d h:mm a')}<br />
						({formatDistanceToNow(new Date(sale.created_at), { addSuffix: true })})</td
					>
				</tr>
			{/each}
		</tbody>
	</table>
</section>

<style lang="postcss">
	th {
		@apply border-b p-3 pl-8 text-left font-medium;
	}
	td {
		@apply border-b p-3 pl-8;
	}
</style>
