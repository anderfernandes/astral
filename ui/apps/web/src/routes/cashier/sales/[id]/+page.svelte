<script lang="ts">
	import { formatDistanceToNow } from 'date-fns';
	import uniqBy from 'lodash/uniqBy.js';
	import { AButton, ADialog } from 'ui';

	let { data } = $props();

	const paid = data.sale.payments.reduce((a, b) => a + b.total, 0);

	let dialog = $state(false);

	const toggle = () => {
		dialog = !dialog;
	};

	const created_at = new Date(data.sale.created_at);
	const updated_at = new Date(data.sale.updated_at);
</script>

<svelte:head>
	<title>Sale #{data.sale.id} Details | Astral Cashier</title>
</svelte:head>

<section class="flex w-full flex-col gap-6 px-6 py-4">
	<div>
		<div class="flex items-center gap-3">
			<a href="/cashier/sales" aria-label="sale">
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
					class="size-5"><path d="m12 19-7-7 7-7" /><path d="M19 12H5" /></svg
				>
			</a>
			<h1 class="text-lg font-semibold md:text-2xl">Sale #{data.sale.id}</h1>
		</div>
		<div class="my-1 flex gap-3 text-sm text-muted-foreground">
			<div class="flex items-center gap-1">
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
					class="size-4"
				>
					<path d="M18 20a6 6 0 0 0-12 0" />
					<circle cx="12" cy="10" r="4" />
					<circle cx="12" cy="12" r="10" />
				</svg>
				<span> {data.sale.creator?.firstname}</span>
			</div>
			<div class="flex items-center gap-1">
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
					class="size-4"
				>
					<path d="M3 5v14" />
					<path d="M21 12H7" />
					<path d="m15 18 6-6-6-6" />
				</svg>
				<span>{data.sale.source}</span>
			</div>
			<div class="flex items-center gap-1">
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
					class="size-4"
				>
					<path d="M18 21a6 6 0 0 0-12 0" />
					<circle cx="12" cy="11" r="4" />
					<rect width="18" height="18" x="3" y="3" rx="2" />
				</svg>
				<span>{data.sale.customer?.firstname} {data.sale.customer?.lastname}</span>
			</div>
			<div class="flex items-center gap-1">
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
					class="size-4"
				>
					<path
						d="M12.586 2.586A2 2 0 0 0 11.172 2H4a2 2 0 0 0-2 2v7.172a2 2 0 0 0 .586 1.414l8.704 8.704a2.426 2.426 0 0 0 3.42 0l6.58-6.58a2.426 2.426 0 0 0 0-3.42z"
					/>
					<circle cx="7.5" cy="7.5" r=".5" fill="currentColor" />
				</svg>
				<span>{data.sale.status}</span>
			</div>
		</div>
		<div class="flex gap-3 text-sm text-muted-foreground">
			<div class="flex items-center gap-1">
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
					class="size-4"
				>
					<path
						d="M12.586 2.586A2 2 0 0 0 11.172 2H4a2 2 0 0 0-2 2v7.172a2 2 0 0 0 .586 1.414l8.704 8.704a2.426 2.426 0 0 0 3.42 0l6.58-6.58a2.426 2.426 0 0 0 0-3.42z"
					/>
					<circle cx="7.5" cy="7.5" r=".5" fill="currentColor" />
				</svg>
				<span
					>{Intl.DateTimeFormat('en-US', { dateStyle: 'medium', timeStyle: 'short' }).format(
						created_at
					)}
					({formatDistanceToNow(created_at, { addSuffix: true })})
				</span>
			</div>
			{#if data.sale.updated_at !== data.sale.updated_at}
				<div class="flex items-center gap-1">
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
						class="size-4"
					>
						<path
							d="M12.586 2.586A2 2 0 0 0 11.172 2H4a2 2 0 0 0-2 2v7.172a2 2 0 0 0 .586 1.414l8.704 8.704a2.426 2.426 0 0 0 3.42 0l6.58-6.58a2.426 2.426 0 0 0 0-3.42z"
						/>
						<circle cx="7.5" cy="7.5" r=".5" fill="currentColor" />
					</svg>
					<span
						>{Intl.DateTimeFormat('en-US', { dateStyle: 'medium', timeStyle: 'short' }).format(
							updated_at
						)}
						({formatDistanceToNow(updated_at, { addSuffix: true })})
					</span>
				</div>
			{/if}
		</div>
	</div>
	{#if data.sale.customer_id > 1}
		<div class="grid grid-cols-2 gap-3">
			<div class="grid gap-3">
				<div class="font-semibold">Customer Information</div>
				<dl class="grid gap-3">
					<div class="flex items-center justify-between">
						<dt class="text-muted-foreground">Customer</dt>
						<dd>{data.sale.customer?.firstname} {data.sale.customer?.lastname}</dd>
					</div>
					<div class="flex items-center justify-between">
						<dt class="text-muted-foreground">Email</dt>
						<dd><a href="mailto:">{data.sale.customer?.email}</a></dd>
					</div>
					<div class="flex items-center justify-between">
						<dt class="text-muted-foreground">Phone</dt>
						<dd><a href="tel:">+1 234 567 890</a></dd>
					</div>
				</dl>
			</div>
			{#if data.sale.organization_id > 1}
				<div class="grid gap-3">
					<div class="font-semibold">Customer Information</div>
					<dl class="grid gap-3">
						<div class="flex items-center justify-between">
							<dt class="text-muted-foreground">Customer</dt>
							<dd>{data.sale.organization?.name} {data.sale.customer?.lastname}</dd>
						</div>
						<div class="flex items-center justify-between">
							<dt class="text-muted-foreground">Email</dt>
							<dd><a href="mailto:">liam@acme.com</a></dd>
						</div>
						<div class="flex items-center justify-between">
							<dt class="text-muted-foreground">Phone</dt>
							<dd><a href="tel:">+1 234 567 890</a></dd>
						</div>
					</dl>
				</div>
			{/if}
		</div>
	{/if}
	<!-- Tickets -->
	{#if data.sale.tickets?.length! > 0}
		<hr />
		<div class="flex flex-col gap-3">
			<div>
				<h3 class="font-semibold leading-none tracking-tight">
					Tickets ({data.sale.events?.length})
				</h3>
				<p class="text-sm text-muted-foreground">The tickets purchased in this sale.</p>
			</div>
			{#each data.sale.events! as event}
				<div class="flex gap-3">
					<img
						alt={event.show.name}
						loading="lazy"
						width="80"
						height="80"
						decoding="async"
						data-nimg="1"
						class="aspect-square rounded-md object-cover"
						style="color:transparent"
						src={event.show.cover}
					/>
					<div class="flex flex-col gap-1">
						<div class="grid gap-1 lg:flex">
							<p class="align-middle text-sm font-medium">
								#{event.id}
								{event.show.name}
							</p>
							<div>
								<span
									class="inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold text-foreground transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2"
								>
									{event.type.name}
								</span>
								<span
									class="inline-flex items-center rounded-md border border-transparent bg-secondary px-2.5 py-0.5 text-xs font-semibold text-secondary-foreground transition-colors hover:bg-secondary/80 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2"
								>
									{event.show.type?.name}
								</span>
							</div>
						</div>
						<span class="text-sm text-muted-foreground">
							{Intl.DateTimeFormat('en-US', { dateStyle: 'medium', timeStyle: 'short' }).format(
								new Date(event.start)
							)}
						</span>
						<div class="flex gap-1">
							{#each uniqBy(data.sale.tickets, 'type_id') as ticket}
								{@const quantity = data.sale.tickets.filter(
									(t) => t.event_id === event.id && t.type_id === t.type_id
								).length}
								<div
									class="inline-flex items-center gap-1 rounded-md border px-2.5 py-0.5 text-xs font-semibold text-foreground transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2"
								>
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
										class="size-4"
									>
										<path
											d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"
										/>
										<path d="M13 5v2" />
										<path d="M13 17v2" />
										<path d="M13 11v2" />
									</svg>
									{ticket.type.name} x {quantity}
								</div>
							{/each}
						</div>
					</div>
				</div>
			{/each}
		</div>
	{/if}
	<!-- Products -->
	{#if data.sale.products.length! > 0}
		<hr />
		<div>
			<h3 class="font-semibold leading-none tracking-tight">
				Products ({data.sale.products?.length})
			</h3>
			<p class="text-sm text-muted-foreground">The products purchased in this sale.</p>
		</div>
		<div class="grid gap-3 lg:grid-cols-3">
			{#each uniqBy(data.sale.products, 'id') as product}
				{@const quantity = data.sale.products.filter((p) => p.id === product.id).length}
				<div class="flex items-center space-x-4 space-y-2">
					<span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full">
						<img class="aspect-square h-full w-full" alt={product.name} src={product.cover} />
					</span>
					<div>
						<p class="text-left text-sm font-medium leading-none">
							{product.name} ${product.price} x {quantity}
						</p>
						<div>
							<div
								class="inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold text-foreground transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2"
							>
								{product.type?.name}
							</div>
						</div>
					</div>
				</div>
			{/each}
		</div>
	{/if}
	<!-- Totals -->
	<hr />
	<div>
		<h3 class="font-semibold leading-none tracking-tight">Totals</h3>
		<p class="text-sm text-muted-foreground">Costs, payments and balances.</p>
	</div>
	<div class="grid grid-cols-2 gap-3 lg:grid-cols-5">
		<div class="flex flex-col items-center justify-center gap-3">
			<h3 class="font-semibold leading-none tracking-tight">Subtotal</h3>
			<div class="flex items-baseline gap-2 text-3xl font-bold tabular-nums leading-none">
				{Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(
					data.sale.subtotal
				)}
			</div>
		</div>
		<div class="flex flex-col items-center justify-center gap-3">
			<h3 class="font-semibold leading-none tracking-tight">Tax</h3>
			<div class="flex items-baseline gap-2 text-3xl font-bold tabular-nums leading-none">
				{Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(data.sale.tax)}
			</div>
		</div>
		<div class="flex flex-col items-center justify-center gap-3">
			<h3 class="font-semibold leading-none tracking-tight">Total</h3>
			<div class="flex items-baseline gap-2 text-3xl font-bold tabular-nums leading-none">
				{Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(data.sale.total)}
			</div>
		</div>
		<div class="flex flex-col items-center justify-center gap-3">
			<h3 class="font-semibold leading-none tracking-tight">Paid</h3>
			<div class="flex items-baseline gap-2 text-3xl font-bold tabular-nums leading-none">
				{Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(paid)}
			</div>
		</div>
		<div class="flex flex-col items-center justify-center gap-3">
			<h3 class="font-semibold leading-none tracking-tight">Balance</h3>
			<div class="flex items-baseline gap-2 text-3xl font-bold tabular-nums leading-none">
				{Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(
					data.sale.balance
				)}
			</div>
		</div>
	</div>
	<!-- Payments -->
	<hr />
	<div>
		<h3 class="font-semibold leading-none tracking-tight">
			Payments ({data.sale.payments.length})
		</h3>
		<p class="text-sm text-muted-foreground">Payments made for this sale.</p>
	</div>
	<table class="w-full caption-bottom text-sm">
		<thead class="[&amp;_tr]:border-b"
			><tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted"
				><th class="h-10 px-2 text-left align-middle font-medium text-muted-foreground"> # </th>
				<th
					class="h-10 px-2 text-left align-middle font-medium text-muted-foreground sm:table-cell"
				>
					Method
				</th>
				<th
					class="h-10 px-2 text-left align-middle font-medium text-muted-foreground sm:table-cell"
				>
					Paid
				</th>
				<th
					class="h-10 px-2 text-left align-middle font-medium text-muted-foreground md:table-cell"
				>
					Tendered
				</th>
				<th
					class="hidden h-10 px-2 text-left align-middle font-medium text-muted-foreground md:table-cell"
				>
					Change
				</th>
				<th
					class="hidden h-10 px-2 text-left align-middle font-medium text-muted-foreground md:table-cell"
				>
					Date
				</th>
				<th
					class="h-10 px-2 text-left align-middle font-medium text-muted-foreground md:table-cell"
				>
					Cashier
				</th>
			</tr>
		</thead>
		<tbody class="[&amp;_tr:last-child]:border-0">
			{#each data.sale.payments as payment}
				<tr class="border-b transition-colors hover:bg-muted/50">
					<td class="p-2 align-middle">
						{payment.id}
					</td>
					<td class="p-2 align-middle sm:table-cell">
						<div
							class="inline-flex items-center rounded-md border border-transparent bg-secondary px-2.5 py-0.5 text-xs font-semibold text-secondary-foreground transition-colors hover:bg-secondary/80 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2"
						>
							{payment.method.name}
						</div>
					</td>
					<td class="p-2 align-middle sm:table-cell">
						{Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(
							payment.total
						)}
					</td>
					<td class="p-2 align-middle md:table-cell">
						{Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(
							payment.tendered
						)}
					</td>
					<td class="hidden p-2 align-middle md:table-cell">
						{Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(
							payment.change_due
						)}
					</td>
					<td class="hidden p-2 align-middle md:table-cell">
						{Intl.DateTimeFormat('en-US', { dateStyle: 'medium', timeStyle: 'short' }).format(
							new Date(payment.created_at)
						)}
					</td>
					<td
						class="p-2 align-middle md:table-cell [&:has([role=checkbox])]:pr-0 [&>[role=checkbox]]:translate-y-[2px]"
						>{payment.cashier.firstname}
					</td>
				</tr>
			{/each}
		</tbody>
	</table>
	<!-- Memos -->
	<hr />
	<div class="flex items-center gap-3">
		<div class="grow">
			<h3 class="font-semibold leading-none tracking-tight">Memos ({data.sale.memos.length})</h3>
			<p class="text-sm text-muted-foreground">Notes left on a sale.</p>
		</div>
		<AButton text="Add" onclick={toggle} />
		{#if dialog}
			<ADialog
				onclose={toggle}
				title="Add Memo"
				subtitle={`A new memo will be added to Sale #${data.sale.id}.`}
			>
				<form method="post" action="?/memo">
					<div class="grid gap-4">
						<textarea
							name="message"
							class="flex min-h-[60px] w-full rounded-md border border-input bg-transparent p-4 text-sm shadow-sm placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
							placeholder="Memo"
						></textarea>
						<div class="flex items-center justify-end">
							<AButton text="Save" type="submit" />
						</div>
					</div>
				</form>
			</ADialog>
		{/if}
	</div>
	{#each data.sale.memos as memo}
		{@const created_at = new Date(memo.created_at)}
		<div
			class="flex flex-col items-start gap-2 rounded-lg py-2 text-left text-sm transition-all hover:bg-accent"
		>
			<div class="flex w-full flex-col gap-1">
				<div class="flex items-center">
					<div class="flex items-center gap-2">
						<div class="font-semibold">{memo.author.firstname}</div>
					</div>
					<div class="ml-auto text-xs text-muted-foreground">
						{Intl.DateTimeFormat('en-US', { dateStyle: 'medium', timeStyle: 'short' }).format(
							created_at
						)}
						({formatDistanceToNow(created_at, { addSuffix: true })})
					</div>
				</div>
				<div class="text-xs font-medium">{memo.author.role.name}</div>
			</div>
			<div class="line-clamp-2 text-xs text-muted-foreground">
				{memo.message}
			</div>
			<hr />
		</div>
	{:else}
		<span class="text-sm w-full text-center">No memos on this sale.</span>
	{/each}
</section>
