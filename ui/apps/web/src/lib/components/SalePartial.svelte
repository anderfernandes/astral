<script lang="ts">
	import { applyAction, enhance } from '$app/forms';
	import { distinctBy } from '@std/collections';
	import { formatDistanceToNow } from 'date-fns';
	import { AButton, ADialog } from 'ui';

	const { sale }: { sale: ISale } = $props();

	let dialog = $state(false);

	let loading = $state(false);

	const toggle = () => {
		dialog = !dialog;
	};

	const paid = sale.payments.reduce((a, b) => a + b.total, 0);

	const created_at = new Date(sale.created_at);
	const updated_at = new Date(sale.updated_at);
</script>

<section class="flex w-full flex-col gap-6">
	<div>
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
					class="size-5"
				>
					<path d="M18 20a6 6 0 0 0-12 0" />
					<circle cx="12" cy="10" r="4" />
					<circle cx="12" cy="12" r="10" />
				</svg>
				<span> {sale.creator?.firstname}</span>
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
					class="size-5"
				>
					<path d="M3 5v14" />
					<path d="M21 12H7" />
					<path d="m15 18 6-6-6-6" />
				</svg>
				<span>{sale.source}</span>
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
					class="size-5"
				>
					<path d="M18 21a6 6 0 0 0-12 0" />
					<circle cx="12" cy="11" r="4" />
					<rect width="18" height="18" x="3" y="3" rx="2" />
				</svg>
				<span>{sale.customer?.firstname} {sale.customer?.lastname}</span>
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
					class="size-5"
				>
					<path
						d="M12.586 2.586A2 2 0 0 0 11.172 2H4a2 2 0 0 0-2 2v7.172a2 2 0 0 0 .586 1.414l8.704 8.704a2.426 2.426 0 0 0 3.42 0l6.58-6.58a2.426 2.426 0 0 0 0-3.42z"
					/>
					<circle cx="7.5" cy="7.5" r=".5" fill="currentColor" />
				</svg>
				<span>{sale.status}</span>
			</div>
		</div>
		<div class="flex gap-3 text-sm text-muted-foreground">
			<div class="flex items-center gap-1">
				<svg class="size-5" viewBox="0 0 24 24"
					><path
						fill="currentColor"
						d="M19,3H18V1H16V3H8V1H6V3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H10V19H5V8H19V9H21V5A2,2 0 0,0 19,3M21.7,13.35L20.7,14.35L18.65,12.35L19.65,11.35C19.85,11.14 20.19,11.13 20.42,11.35L21.7,12.63C21.89,12.83 21.89,13.15 21.7,13.35M12,18.94L18.07,12.88L20.12,14.88L14.06,21H12V18.94Z"
					></path></svg
				>
				<span
					>{Intl.DateTimeFormat('en-US', { dateStyle: 'medium', timeStyle: 'short' }).format(
						created_at
					)}
					({formatDistanceToNow(created_at, { addSuffix: true })})
				</span>
			</div>
			{#if sale.updated_at !== sale.updated_at}
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
						class="size-5"
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
	{#if sale.customer_id > 1}
		<div class="grid grid-cols-2 gap-3">
			<div class="col-span-3 rounded-xl bg-card text-card-foreground">
				<div class="flex flex-col space-y-1.5 pb-3">
					<h3 class="font-semibold leading-none tracking-tight">Customer</h3>
					<!-- <p class="text-sm text-muted-foreground">You made 265 sales this month.</p> -->
				</div>
				<div class="pt-0">
					<div class="space-y-8">
						<div class="flex items-center">
							<span class="relative flex h-9 w-9 shrink-0 overflow-hidden rounded-full">
								<svg class="size-full" viewBox="0 0 24 24"
									><path
										fill="currentColor"
										d="M12,4A4,4 0 0,1 16,8A4,4 0 0,1 12,12A4,4 0 0,1 8,8A4,4 0 0,1 12,4M12,14C16.42,14 20,15.79 20,18V20H4V18C4,15.79 7.58,14 12,14Z"
									></path></svg
								>
							</span>
							<div class="ml-4 space-y-1">
								<p class="text-sm font-medium leading-none">
									{sale.customer?.firstname}
									{sale.customer?.lastname}
								</p>
								<p class="text-sm text-muted-foreground">{sale.customer?.email}</p>
								<p class="text-sm text-muted-foreground">
									{sale.customer?.phone
										?.replace(/\D+/g, '')
										.replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3')}
								</p>
							</div>
							<!-- <div class="ml-auto font-medium">+$1,999.00</div> -->
						</div>
					</div>
				</div>
			</div>
			<!-- <div class="grid gap-3">
				<div class="font-semibold">Customer Information</div>
				<dl class="grid gap-3">
					<div class="flex items-center justify-between">
						<dt class="text-muted-foreground">Customer</dt>
						<dd>{sale.customer?.firstname} {sale.customer?.lastname}</dd>
					</div>
					<div class="flex items-center justify-between">
						<dt class="text-muted-foreground">Email</dt>
						<dd><a href="mailto:">{sale.customer?.email}</a></dd>
					</div>
					<div class="flex items-center justify-between">
						<dt class="text-muted-foreground">Phone</dt>
						<dd><a href="tel:">+1 234 567 890</a></dd>
					</div>
				</dl>
			</div> -->
			{#if sale.organization_id > 1}
				<div class="grid gap-3">
					<div class="font-semibold">Customer Information</div>
					<dl class="grid gap-3">
						<div class="flex items-center justify-between">
							<dt class="text-muted-foreground">Customer</dt>
							<dd>{sale.organization?.name} {sale.customer?.lastname}</dd>
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
	{#if sale.tickets?.length! > 0}
		<hr />
		<div class="flex flex-col gap-3">
			<div>
				<h3 class="font-semibold leading-none tracking-tight">
					Tickets ({sale.events?.length})
				</h3>
				<p class="text-sm text-muted-foreground">The tickets purchased in this sale.</p>
			</div>
			{#each sale.events! as event}
				<div class="flex items-center gap-3">
					<img
						alt={event.show.name}
						class="aspect-square h-[112px] w-[80px] rounded-md object-cover"
						style="color:transparent"
						src={event.show.cover}
					/>
					<div class="grid gap-1">
						<div class="flex items-center gap-1">
							<span class="text-sm text-muted-foreground">
								#{event.id}
							</span>
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
						<h5 class="truncate align-middle text-sm font-medium">
							{event.show.name}
						</h5>
						<span class="flex text-sm text-muted-foreground">
							<svg class="size-5" viewBox="0 0 24 24"
								><path
									fill="currentColor"
									d="M19,3H18V1H16V3H8V1H6V3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H10V19H5V8H19V9H21V5A2,2 0 0,0 19,3M21.7,13.35L20.7,14.35L18.65,12.35L19.65,11.35C19.85,11.14 20.19,11.13 20.42,11.35L21.7,12.63C21.89,12.83 21.89,13.15 21.7,13.35M12,18.94L18.07,12.88L20.12,14.88L14.06,21H12V18.94Z"
								></path></svg
							>
							{Intl.DateTimeFormat('en-US', { dateStyle: 'medium', timeStyle: 'short' }).format(
								new Date(event.start)
							)}
						</span>
						<div class="flex flex-wrap gap-1">
							{#each distinctBy(sale.tickets, (t) => t.type_id) as ticket}
								{@const quantity = sale.tickets
									.filter((t) => t.event_id === ticket.event_id)
									.filter((t) => t.type_id === ticket.type_id).length}
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
										class="size-5"
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
	{#if sale.products.length! > 0}
		<hr />
		<div>
			<h3 class="font-semibold leading-none tracking-tight">
				Products ({sale.products?.length})
			</h3>
			<p class="text-sm text-muted-foreground">The products purchased in this sale.</p>
		</div>
		<div class="grid gap-3 lg:grid-cols-3">
			{#each distinctBy(sale.products, (p) => p.id) as product}
				{@const quantity = sale.products.filter((p) => p.id === product.id).length}
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
				{Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(sale.subtotal)}
			</div>
		</div>
		<div class="flex flex-col items-center justify-center gap-3">
			<h3 class="font-semibold leading-none tracking-tight">Tax</h3>
			<div class="flex items-baseline gap-2 text-3xl font-bold tabular-nums leading-none">
				{Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(sale.tax)}
			</div>
		</div>
		<div class="flex flex-col items-center justify-center gap-3">
			<h3 class="font-semibold leading-none tracking-tight">Total</h3>
			<div class="flex items-baseline gap-2 text-3xl font-bold tabular-nums leading-none">
				{Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(sale.total)}
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
				{Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(sale.balance)}
			</div>
		</div>
	</div>
	<!-- Payments -->
	<hr />
	<div>
		<h3 class="font-semibold leading-none tracking-tight">
			Payments ({sale.payments.length})
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
			{#each sale.payments as payment}
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
			<h3 class="font-semibold leading-none tracking-tight">Memos ({sale.memos.length})</h3>
			<p class="text-sm text-muted-foreground">Notes left on a sale.</p>
		</div>
		<AButton text="Add" onclick={toggle} />
		{#if dialog}
			<ADialog
				onclose={toggle}
				title="Add Memo"
				subtitle={`A new memo will be added to Sale #${sale.id}.`}
			>
				<form
					method="post"
					action="?/memo"
					use:enhance={() => {
						loading = true;
						return async ({ result, update }) => {
							console.log(result.status);
							if (result.status! >= 400) {
								loading = false;
							} else await applyAction(result);
							await update();
							dialog = false;
						};
					}}
				>
					<div class="grid gap-4">
						<textarea
							name="message"
							class="flex min-h-[60px] w-full rounded-md border border-input bg-transparent p-4 text-sm shadow-sm placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
							placeholder="Memo"
						></textarea>
						<div class="flex items-center justify-end">
							<AButton text="Save" type="submit" {loading} />
						</div>
					</div>
				</form>
			</ADialog>
		{/if}
	</div>
	{#each sale.memos as memo}
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
