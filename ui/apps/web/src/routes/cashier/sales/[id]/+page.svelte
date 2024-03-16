<script lang="ts">
	import { enhance } from '$app/forms';
	import { format, formatDistanceToNow } from 'date-fns';
	import _ from 'lodash';
	import { AButton, AChip, ADialog, AIcon, ASelect, ATextarea } from 'ui';
	import {
		account_circle,
		badge_account_horizontal_outline,
		cash,
		calendar_edit_outline,
		message_text_outline,
		ticket_outline,
		package_variant_closed,
		tag_outline
	} from 'ui/icons';

	let { data } = $props();
	let { sale } = data;

	let dialog = $state<'memo' | 'payment' | 'ticket' | undefined>();
	let loading = $state(false);

	function sum(payments: IPayment[]) {
		return payments.reduce((total, payment) => total + payment.total, 0);
	}
</script>

{#snippet hr(text, icon)}
	<div class="flex items-center gap-3">
		<div class="grow border-b border-zinc-300"></div>
		<div class="flex shrink gap-3 px-1 pb-1">
			<AIcon data={icon} size={1.5} />
			<span class="shrink font-semibold">{text}</span>
		</div>
		<div class="grow border-b border-zinc-300"></div>
	</div>
{/snippet}

<section class="flex w-full flex-col gap-3 p-6">
	<div>
		<div class="flex w-full">
			<h1 class="flex grow items-center gap-2">
				Sale #{sale.id}
				{#if sale.refund}
					<span class="rounded bg-red-600 px-2 py-1 text-xs font-medium text-white">refunded</span>
				{/if}
			</h1>
			<div class="flex gap-1">
				{#if sale.balance === 0}
					{#if sale.tickets.length > 0}
						<AButton text="Tickets" href={`/cashier/sales/${sale.id}/tickets`} />
					{/if}
					<AButton text="Receipt" href={`/cashier/sales/${sale.id}/receipt`} />
				{/if}
				{#if !sale.refund}
					<form
						use:enhance={({ cancel }) => {
							if (
								!confirm(
									'Are you sure you want to refund ALL the payments on this sale? This cannot be undone.'
								)
							)
								cancel();
							return async ({ update }) => {};
						}}
						method="POST"
						action="?/refund"
					>
						<AButton text="Refund" basic type="submit" />
					</form>
				{/if}
			</div>
		</div>
		<div class="mb-1 flex items-center gap-1 text-sm">
			<div class="flex items-center gap-1">
				<AIcon data={tag_outline} />
				<span>{sale.status}</span>&middot;
			</div>
			<AIcon data={account_circle} />
			<span>{sale.customer?.firstname} {sale.customer?.lastname}</span>
			&middot;
			<div class="flex items-center gap-1">
				<AIcon data={badge_account_horizontal_outline} />
				{sale.creator?.firstname}
			</div>
			&middot;
			<div class="flex items-center gap-1">
				<AIcon data={message_text_outline} />
				{sale.memos.length}
			</div>
		</div>
		<p class="flex items-center gap-1 text-sm text-zinc-500">
			<AIcon data={calendar_edit_outline} />
			{format(new Date(sale.created_at), 'EEE MMM d yyyy @ h:mm a')}
			({formatDistanceToNow(new Date(sale.created_at), { addSuffix: true })})
		</p>
	</div>

	{@render hr('Totals', cash)}
	<div class="grid grid-cols-5 gap-1">
		<h3 class="grid text-center">
			<span class="text-3xl font-semibold">${sale.subtotal.toFixed(2)}</span>
			<span class="text-sm text-zinc-500">Subtotal</span>
		</h3>
		<h3 class="grid text-center">
			<span class="text-3xl font-semibold">${sale.tax.toFixed(2)}</span>
			<span class="text-sm text-zinc-500">Tax</span>
		</h3>
		<h3 class="grid text-center">
			<span class="text-3xl font-semibold">${sale.total.toFixed(2)}</span>
			<span class="text-sm text-zinc-500">Total</span>
		</h3>
		<h3 class="grid text-center">
			<span class="text-3xl font-semibold">${sum(sale.payments).toFixed(2)}</span>
			<span class="text-sm text-zinc-500">Payments</span>
		</h3>
		<h3 class="grid text-center">
			<span class="text-3xl font-semibold">${sale.balance.toFixed(2)}</span>
			<span class="text-sm text-zinc-500">Balance</span>
		</h3>
	</div>

	{#if sale.tickets.length > 0}
		{@render hr(`Tickets (${sale.tickets.length})`, ticket_outline)}
		{#if sale.balance !== 0 && sale.status !== 'complete'}
			<div class="flex">
				<AButton text="Edit" />
			</div>
		{/if}
		<div class="grid gap-3 md:grid-cols-2">
			{#each sale.events! as event}
				<div class="flex gap-1 rounded-xl border border-zinc-300 text-sm dark:border-zinc-800">
					<div
						class="h-28 w-28 rounded-bl-xl rounded-tl-xl bg-black"
						style={`background-image: url(${event.show.cover});background-size:cover; background-position:center`}
					/>
					<div class="flex flex-col gap-2 rounded-xl p-3">
						<span class="text-sm font-medium"
							>#{event.id} {event.show.name} [{event.type.name}]</span
						>
						<span class="text-sm text-zinc-500 dark:text-zinc-400">
							{format(new Date(event.start), 'EEE MMM d @ h:mm a')}
							({formatDistanceToNow(new Date(event.start), { addSuffix: true })})
						</span>
						<div class="flex gap-1">
							{#each _.uniqBy(sale.tickets, 'type_id') as ticket}
								{@const quantity = sale.tickets.filter(
									(t) => t.event_id === event.id && t.type_id === ticket.type_id
								).length}
								<AChip text={`${ticket.type.name} x ${quantity}`} />
							{/each}
						</div>
					</div>
				</div>
			{/each}
		</div>
	{/if}

	{#if sale.products.length > 0}
		{@render hr(`Products (${sale.products.length})`, package_variant_closed)}

		{#if sale.balance !== 0 && sale.status !== 'complete'}
			<div class="flex">
				<AButton text="Edit" />
			</div>
		{/if}
		<div class="grid gap-3 md:grid-cols-3">
			{#each _.uniqBy(sale.products, 'id') as product}
				{@const quantity = sale.products.filter((p) => p.id === product.id).length}
				<div class="flex gap-3 rounded-xl border border-zinc-300 text-sm dark:border-zinc-800">
					<div
						class="h-16 w-16 rounded-bl-xl rounded-tl-xl bg-black"
						style={`background-image: url(${product.cover});background-size:cover; background-position:center`}
					/>
					<div class="flex flex-col py-3">
						<span class="font-medium">{product.name} [{product.type?.name}]</span>
						<span class="text-zinc-500 dark:text-zinc-400">
							${product.price.toFixed(2)} x {quantity} &middot;
							{#if product.inventory}
								({product.stock} in stock)
							{/if}
						</span>
					</div>
				</div>
			{/each}
		</div>
	{/if}

	{@render hr(`Payments (${sale.payments.length})`, cash)}
	{#if sale.balance !== 0 && sale.status !== 'complete'}
		<div class="flex">
			<AButton text="Add" />
		</div>
	{/if}
	<table class="w-full table-auto text-sm">
		<thead>
			<tr class="h-12 rounded border-b-[1px] border-black">
				<th>#</th>
				<th>Method</th>
				<th>Paid</th>
				<th>Tendered</th>
				<th>Change</th>
				<th>Date</th>
				<th>Cashier</th>
			</tr>
		</thead>
		<tbody>
			{#each sale.payments as payment}
				<tr class="h-14 border-zinc-500" class:bg-red-100={payment.refunded}>
					<td class="text-center">{payment.id}</td>
					<td class="text-center">{payment.method.name}</td>
					<td class="text-center">${payment.total.toFixed(2)}</td>
					<td class="text-center">${payment.tendered?.toFixed(2)}</td>
					<td class="text-center">${payment.change_due.toFixed(2)}</td>
					<td class="text-center">
						{format(new Date(payment.created_at), 'EEE MMM d yyyy @ h:mm a')}
						({formatDistanceToNow(new Date(payment.created_at), { addSuffix: true })})
					</td>
					<td>
						<div class="flex items-center justify-center gap-1">
							<AIcon data={badge_account_horizontal_outline} />
							{payment.cashier.firstname}
						</div>
					</td>
				</tr>
			{/each}
		</tbody>
	</table>

	{@render hr(`Memos (${sale.memos.length})`, message_text_outline)}
	<div class="flex">
		<AButton
			text="Add"
			onclick={() => {
				dialog = 'memo';
			}}
		/>
		{#if dialog === 'memo'}
			<ADialog
				title="Add Memo"
				subtitle={`Add Memo to Sale #${sale.id}`}
				onclose={() => {
					dialog = undefined;
				}}
			>
				<form
					class="grid gap-3"
					method="POST"
					action="?/memo"
					use:enhance={() => {
						loading = true;
						return async ({ result, update }) => {
							if (result.type !== 'success') {
								console.log(result);
							} else {
								dialog = undefined;
								loading = false;
								await update();
							}
						};
					}}
				>
					<input type="hidden" name="sale_id" value={sale.id} />
					<ATextarea
						name="message"
						required
						label="Message"
						hint="A message for anyone who might look at this sale."
						placeholder="Message"
					/>
					<AButton {loading} text="Submit" type="submit" />
				</form>
			</ADialog>
		{/if}
	</div>
	<div class="flex flex-col gap-3">
		{#each data.sale.memos as memo}
			<div class="flex items-center gap-2 text-sm">
				<AIcon data={message_text_outline} size={2} />
				<div class="grid">
					<div class="flex items-center gap-2">
						<p class="font-medium">
							{memo.author.firstname}
							{memo.author.lastname ?? ''}
						</p>
						<AChip text={memo.author.role.name} />
						<span class="text-gray-500">
							{formatDistanceToNow(new Date(memo.created_at), { addSuffix: true })}
						</span>
					</div>
					<p>{memo.message}</p>
				</div>
			</div>
		{/each}
	</div>
</section>
